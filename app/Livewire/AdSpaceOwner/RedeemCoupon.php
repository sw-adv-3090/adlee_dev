<?php

namespace App\Livewire\AdSpaceOwner;

use App\Enums\TemplateLanguage;
use App\Models\Coupon;
use App\Models\SponsorTemplate;
use Livewire\Component;
use App\Models\Task;
use App\Models\DesignerTemplate as TemplateModel;
use App\Enums\TemplateType;
use App\Models\Sponsor;
use App\Notifications\CouponRedeemed;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use App\Services\DataService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Decoders\FilePathImageDecoder;
use Intervention\Image\Geometry\Factories\LineFactory;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class RedeemCoupon extends Component
{
    // protected $listeners = ['changeStep'];
    public string $step = "redeem";
    public Coupon $coupon;
    public Task $task;
    public string $language = "";
    public bool $showLanguages = false;
    public int|null $selectedTemplate = null;
    public $sponsorTemplatesId = [];
    public $templates = [];
    public $link;
    protected $listeners = ['callMethodFromJS' => 'handleEventFromJS'];
    public function mount(Coupon $coupon)
    {

        $this->coupon = $coupon;
        $this->task = $coupon->task;

        // Fetch sponsor templates associated with the coupon's sponsor
        $sponsor = $coupon->sponsor;
        $s = SponsorTemplate::where('sponsor_id', $sponsor->id)->get();
        $this->sponsorTemplatesId = SponsorTemplate::where('sponsor_id', $sponsor->id)
            ->pluck('template_id')
            ->toArray(); // Ensure the plucked values are an array for further use

        // Set the language based on task language
        if ($this->task->language === "hebrew") {
            $this->language = TemplateLanguage::HEBREW->value;
        } elseif ($this->task->language === "both") {
            $this->showLanguages = true;
            $this->language = TemplateLanguage::ENGLISH->value;
        } else {
            $this->language = TemplateLanguage::ENGLISH->value;
        }

        // Fetch templates based on the defined conditions
        $this->templates = TemplateModel::query()
            ->with(['category'])
            ->select(['id', 'uuid', 'title', 'preview', 'language', 'category_id', 'sub_category_id'])
            
            ->where('type', TemplateType::SPONSOR->value)
            ->whereIn('id', $this->sponsorTemplatesId) // Filter based on sponsor template IDs
            ->whereDate('publish_at', '<=', now()) // Ensure the templates are published
            ->get();


        if (is_null($this->coupon->redeemed_at)) {
            $this->step = 'redeem';
        } else if (is_null($this->coupon->task->signed_at)) {
            $this->step = 'sign';
            $this->eSign();
        } else if (!is_null($this->coupon->task->signed_at)) {
            $this->step = 'print-template';
        }
        
        if (!is_null($this->coupon->task->printed_at)) {
            // dd($this->coupon->task);
            $this->step = 'download-agreement';
        }
    }
    public function render()
    {

        // Perform your checks
        // if (!is_null($this->coupon->redeemed_by)) {
        //     abort_if($this->coupon->redeemed_by !== auth()->user()->email, 403);
        // }
        // abort_if(!is_null($this->coupon->redeemed_at), 403, 'Coupon already redeemed.');

        // Load related data
        // dd($this->coupon->task->document_id);
        $this->coupon->load(['sponsor:id,company_name']);
        // dd($this->coupon->task);


        // if user is not signed his consent through e-signature


        return view('livewire.ad-space-owner.redeem-coupon');
    }

    public function changeStep($step)
    {

        $this->step = $step;
        if ($step === 'select-template') {

            $this->loadTemplates();
        }
    }

    public function handleEventFromJS($data) {
        this->changeStep($data);
    }

    public function loadTemplates()
    {
        // if (!is_null($this->coupon->redeemed_by)) {
        //     abort_if($this->coupon->redeemed_by !== auth()->user()->email, 403);
        // }
        // abort_if(!is_null($this->coupon->redeemed_at), 403, 'Coupon already redeemed.');
        // $this->coupon = Coupon::with('user', 'sponsor', 'task', 'adSpaceOwner')->find($this->coupon->id);

        // dd($coupon);
        $this->coupon->load(['user:id,email', 'sponsor:id,company_name', 'adSpaceOwner', 'task']);
    }

    public function selectTemplate($templateId)
    {

        $this->selectedTemplate = $templateId;
    }

    public function saveTemplate()
    {
        DB::transaction(function () {
            $this->task->update([
                'template_id' => $this->selectedTemplate,
                'assign_to' => auth()->id()
            ]);

            $this->coupon->update([
                'redeemed_by' => auth()->user()->email,
                'redeemed_at' => now(),
            ]);



            Notification::send($this->coupon->user, new CouponRedeemed($this->coupon));
            $this->eSign();
        });




        // if (!is_null($this->coupon->redeemed_by)) {
        //     // through BBO to provide his consent through e-signature,
        //     session()->flash('status', "Coupon was successfully redeemed. You will now need to provide your consent through e-signature and click 'print' which will be recorded, in order to be paid.");
        //     // return $this->redirect('/ad-space-owner/coupons?coupon_id=' . $this->coupon->uuid);
        //     return $this->redirect('/ad-space-owner/coupons/' . $this->coupon->uuid . '/sign');
        // }
    }

    public function eSign()
    {

        $this->coupon->load(['task']);
        $documentId = $this->coupon->task->document_id;
        $error = "";
        $link = "";

        try {
            if (is_null($documentId)) {
                // Send request to Boldsign API to get document ID
                $response = Http::withHeaders([
                    'X-API-Key' => config('services.boldsign.api_key'),
                ])->post("https://api.boldsign.com/v1/template/send/?templateId=" . config('services.boldsign.template_id'), [
                    "roles" => [
                        [
                            "roleIndex" => 1,
                            "signerName" => auth()->user()->name,
                            "signerEmail" => auth()->user()->email,
                        ]
                    ]

                ])->json();

                if (isset($response['error'])) {
                    $error = $response['error'];
                } else {
                    $documentId = $response['documentId'];

                    $this->coupon->task->update(['document_id' => $documentId]);
                }
            }


            if (!$error) {
                // Get embed sign link from Boldsign API
                $queryString = http_build_query([
                    'DocumentId' => $documentId,
                    'SignerEmail' => auth()->user()->email,
                    'RedirectUrl' => "",
                    'DisableEmails' => true,
                ]);
                $headers = [
                    'X-API-Key' => config('services.boldsign.api_key'),
                ];
                $embedSignAPIUrl = "https://api.boldsign.com/v1/document/getEmbeddedSignLink?$queryString";
                $response = Http::withHeaders($headers)->get($embedSignAPIUrl)->json();
                // dd($response['error']);
                if (isset($response['error'])) {
                    if ($response['error'] === 'This document has already been completed.') {
                        $this->step = 'print-template';
                    }
                    
                    $error = $response['error'];
                    
                } else {
                    $link = $response['signLink'];
                }

                if (!$error) {

                    $this->link = $link;

                    $this->step = 'sign';
                    // return view('ad-space-owner.coupons.sign', ['coupon' => $coupon, 'link' => $link]);
                }
            }

            return back()->with('error', $error);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function print(Request $request, Coupon $coupon, DataService $service)
    {

        $this->coupon->load(['task', 'sponsor', 'user']);

        if (is_null($this->coupon->task->document_id)) {
            dd('documnet id null');
            // return back()->with('error', 'Please provide e-signature consent first to download the template.');
        }

        // if user is not signed his consent through e-signature
        if (is_null($this->coupon->task->signed_at)) {

            $success = sign_task($this->coupon);

            if (!$success) {
                dd('not success');
                // return back()->with('error', 'Please provide e-signature consent first to download the template.');
            }
        }
        // dd('here');
        // update database
        
        // Generate pdf file
        $template = $this->coupon->task->template;
        $language = $template?->language ?? 'english';
        $name = $language . "_name";
        $commemoration = $this->coupon->task->$name;

        $generatedImage = $this->generateImage($this->coupon);
        // dd($generatedImage);
        // // Add the image to the HTML content
        $htmlContent = '<img src="data:image/png;base64,' . base64_encode($generatedImage) . '" style="width: 100%; height: auto;">';

        $pdf = Pdf::loadHtml($htmlContent)->setPaper('legal', 'landscape');
        $this->coupon->task->update(['printed_at' => now(), 'status' => 'printed']);
        $this->coupon->update(['payout_on' => now()->addDays($this->coupon->payout_deadline)]);
        $this->step = 'download-agreement';
        // $this->step = 'download-agreement';
        return $pdf->download($this->coupon->number . '.pdf');

    }
    public function generateImage($coupon)
    {
        //GENERATE IMAGE
        $file = $this->coupon->template->file;
        $id = $this->coupon->template->id;
        $designerTemplate = $this->coupon->template;
        $sponsor_data = Sponsor::where('user_id', $this->coupon->user_id)->first();
        $coupon_id = (int) $sponsor_data->last_coupon;
        //getting latest record of coupon
        // $coupon = Coupon::where('user_id', $sponsor->id)->latest('id')->first();

        // $coupon = Coupon::with(['booklet:id,number', 'sponsor:id,company_name,company_logo,address,city,postal_code'])->where('id', $coupon_id)->first();

        $designerMetaData = json_decode($designerTemplate->meta_data, true);
        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
        $imageManager = new ImageManager(new Driver());
        $image = $imageManager->read(public_path($file), decoders: FilePathImageDecoder::class);
        $image->resize($designerTemplate->width, $designerTemplate->height);

        foreach ($designerMetaData as $key => $value) {
            if ($value['x'] == 0 && $value['y'] == 0) {
                continue;
            }
            if ($key == 'adlee_logo' && isset($value['src'])) {
                $additionalImage = public_path('logo.png');
                if (file_exists($additionalImage)) {
                    $this->placeAdditionalImage($imageManager, $image, $value, $additionalImage);
                }
            } else if ($key == 'sponsor_logo') {
                $company_logo = $sponsor_data->company_logo;
                // $additionalImage = Storage::disk('disk_path')->path($company_logo);
                $additionalImage = Storage::disk('public')->path(str_replace('storage/', '', $company_logo)); //storage_path(str_replace('storage/', '', $company_logo));
                if (file_exists($additionalImage)) {
                    $this->placeAdditionalImage($imageManager, $image, $value, $additionalImage);
                }
            } else if ($key == 'sponsor_name') {
                $this->renderText($image, $value, $key, $sponsor_data->company_name);
            } else if ($key == 'person_name') {
                $this->renderText($image, $value, $key, 'David Smith');
            } else if ($key == 'person_title') {
                $this->renderText($image, $value, $key, 'MR.');
            } else if ($key == 'commemoration') {
                $this->renderText($image, $value, $key, 'In Honor Of');
            } else if ($key == 'book_number' || $key == 'book_number_1') {
                $this->renderText($image, $value, $key, $sponsor_data->last_booklet);
            } else if ($key == 'coupon_number' || $key == 'coupon_number_1') {
                $this->renderText($image, $value, $key, $sponsor_data->last_coupon);
            } else if ($key == 'sponsor_address') {
                $this->renderText($image, $value, $key, $sponsor_data->address);
            } else if ($key == 'sponsor_city') {
                $this->renderText($image, $value, $key, $sponsor_data->city);
            } else if ($key == 'sponsor_zipcode') {
                $this->renderText($image, $value, $key, $sponsor_data->postal_code);
            } else if ($key == 'amount_in_words' && !empty($this->coupon)) {
                $title = ucwords(str_replace('-', " ", $f->format($this->coupon->amount)) . ' dollars');
                $this->renderText($image, $value, $key, $title);
            } else if ($key == 'amount_in_digit' && !empty($this->coupon)) {
                $this->renderText($image, $value, $key, $this->coupon->amount);
            } else if ($key == 'shorten_url' && !empty($this->coupon)) {
                $title = str_replace(config('services.replace_url'), '', $this->coupon->shorten_url_redeem);
                $this->renderText($image, $value, $key, $title);
            } else if ($key == 'sponsor_qr' && !empty($this->coupon)) {
                $options = new QROptions([
                    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                ]);

                $additionalImage = (new QRCode($options))->render($this->coupon->shorten_url_activate);

                $this->placeAdditionalImage($imageManager, $image, $value, $additionalImage);
            } else if ($key == 'bbo_qr' && !empty($this->coupon)) {
                $options = new QROptions([
                    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                ]);


                $additionalImage = (new QRCode($options))->render($this->coupon->shorten_url_redeem);

                $this->placeAdditionalImage($imageManager, $image, $value, $additionalImage);
            } else if ($key == 'qr_code') {
                $options = new QROptions([
                    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                ]);


                $additionalImage = (new QRCode($options))->render("https://adlee.io");

                $this->placeAdditionalImage($imageManager, $image, $value, $additionalImage);
            }
        }
        $imageBinary = (string) $image->encodeByExtension('png');
        return $imageBinary;
    }

    private function placeAdditionalImage(ImageManager $imageManager, \Intervention\Image\Image $image, array $value, string $aImage)
    {
        $additionalImage = $imageManager->read($aImage);
        $additionalImage->resize($value['width'], $value['height']);
        $image->place($additionalImage, 'absolute', $value['x'] - $value['width'] / 2, $value['y'] - $value['height'] / 2);
    }

    private function renderText(\Intervention\Image\Image  $image, array $value, string $key, string $title)
    {
        $fontSize = (float) str_replace('px', '', $value['font']);
        if (isset($value['fontFamily'])) {
            $fontFile = $this->getFontFile($value['fontFamily'], $value['bold'], $value['italic']);
        } else {
            $fontFile = $this->getFontFile('', $value['bold'], $value['italic']);
        }

        $image->text($title, $value['x'], $value['y'] + $fontSize, function ($font) use ($fontFile, $fontSize, $value) {
            $font->file(public_path('fonts/arial-font/' . $fontFile));
            $font->size($fontSize);
            if (isset($value['color'])) {
                $font->color($value['color']);
            } else {
                $font->color('#000000');
            }
        });

        if ($value['underline']) {
            $image->drawLine(function (LineFactory $line) use ($value, $key, $fontSize) {
                $line->from($value['x'], $value['y'] + $fontSize + 5);
                $line->to($value['x'] + strlen($value['dummyText']) * ($fontSize / 2), $value['y'] + $fontSize + 5);
                if (isset($value['color'])) {
                    $line->color($value['color']);
                } else {
                    $line->color('#000000');
                }
                $line->width(2);
            });
        }
    }

    private function getFontFile(string $fontFamily, bool $bold, bool $italic): string
    {
        // Define a font mapping for supported font families
        $fontMap = [
            'Arial' => [
                'normal' => 'arial.ttf',
                'bold' => 'arialbd.ttf',
                'italic' => 'ariali.ttf',
                'bold_italic' => 'arialbi.ttf',
            ],
            'Verdana' => [
                'normal' => 'verdana.ttf',
                'bold' => 'verdanab.ttf',
                'italic' => 'verdanai.ttf',
                'bold_italic' => 'verdanaz.ttf',
            ],
            'Times New Roman' => [
                'normal' => 'times.ttf',
                'bold' => 'timesbd.ttf',
                'italic' => 'timesi.ttf',
                'bold_italic' => 'timesbi.ttf',
            ],
            'Georgia' => [
                'normal' => 'georgia.ttf',
                'bold' => 'georgiab.ttf',
                'italic' => 'georgiai.ttf',
                'bold_italic' => 'georgiaz.ttf',
            ],
            'Courier New' => [
                'normal' => 'cour.ttf',
                'bold' => 'courbd.ttf',
                'italic' => 'couri.ttf',
                'bold_italic' => 'courbi.ttf',
            ],
            'Tahoma' => [
                'normal' => 'tahoma.ttf',
                'bold' => 'tahomabd.ttf',
                'italic' => 'tahomai.ttf', // If not available, add a fallback
                'bold_italic' => 'tahomabi.ttf', // If not available, add a fallback
            ],
            'Comic Sans MS' => [
                'normal' => 'comic.ttf',
                'bold' => 'comicbd.ttf',
                'italic' => 'comici.ttf', // If not available, add a fallback
                'bold_italic' => 'comicbi.ttf', // If not available, add a fallback
            ],
        ];

        // Fallback font family if the provided font is not in the mapping
        if (empty($fontMap[$fontFamily])) {
            $fontFamily = 'Arial'; // Default to Arial
        }

        // Determine the correct font file based on the style
        if ($bold && $italic) {
            return $fontMap[$fontFamily]['bold_italic'] ?? $fontMap[$fontFamily]['bold'];
        } elseif ($bold) {
            return $fontMap[$fontFamily]['bold'] ?? $fontMap[$fontFamily]['normal'];
        } elseif ($italic) {
            return $fontMap[$fontFamily]['italic'] ?? $fontMap[$fontFamily]['normal'];
        } else {
            return $fontMap[$fontFamily]['normal'];
        }
    }

    public function templatePreview(TemplateModel $template,$queryCoupon = null)
    {
    
        $from_coupon_listing = true;
        $id = $template->id;
        $designerTemplate = TemplateModel::find($id);
        $sponsor = auth()->user();
        $sponsor_data = Sponsor::where('user_id', $sponsor->id)->first();
        $coupon_id = !empty($sponsor_data) ? (int) $sponsor_data->last_coupon : null;
        if(!empty($queryCoupon)){
            $coupon_id = $queryCoupon;
        }
        
        $coupon = Coupon::with(['booklet:id,number', 'sponsor:id,company_name,company_logo,address,city,postal_code'])->where('id', $coupon_id)->first();
        if(empty($sponsor_data) && !empty($coupon)){
            $sponsor_data = Sponsor::where('id', $coupon->sponsor_id)->first();
            
        }
        // $coupon = Coupon::get();
        //  echo "<pre>";
        // print_r($coupon);die;
        if (!empty($coupon->task) && $coupon->task->language == 'english'){
            $title_for = $coupon->task->english_title;
            $person_name = $coupon->task->english_name;
            $purpose = $coupon->task->purpose_eng ? $coupon->task->purpose_eng : 'In Honor Of';
        }else if (!empty($coupon->task) && $coupon->task->language == 'hebrew'){
            $title_for = $coupon->task->hebrew_title;
            $person_name = $coupon->task->hebrew_name;
            $purpose = $coupon->task->purpose_heb ?  $coupon->task->purpose_heb : 'לזכר';
        }else{    
            $template_language = $designerTemplate->language; 
            $title_for = $template_language == 'english' ? $coupon->task->english_title : $coupon->task->hebrew_title;
            $person_name = $template_language == 'english' ? $coupon->task->english_name : $coupon->task->hebrew_name;
            $purpose = $template_language == 'english' 
            ? ($coupon->task->purpose_eng ?? 'In Honor of') 
            : ($coupon->task->purpose_heb ?? 'לזכר');
        
        }

        $designerMetaData = json_decode($designerTemplate->meta_data, true);
        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);


        try {
            $imageManager = new ImageManager(new Driver());
            $image = $imageManager->read(public_path($designerTemplate->file));
            $image->resize($designerTemplate->width, $designerTemplate->height);

            foreach ($designerMetaData as $key => $value) {
                if($value['x'] == 0 && $value['y'] == 0){
                    continue;
                }
                if ($key == 'adlee_logo' && isset($value['src'])) {
                    $additionalImage =public_path('logo.png');
                    if (file_exists($additionalImage)) {
                        $this->placeAdditionalImage($imageManager, $image, $value, $additionalImage);
                    }
                }else if($key == 'sponsor_logo'){
                    $company_logo = $sponsor_data->company_logo;
                    // $additionalImage = Storage::url(str_replace('storage/', '', $company_logo));
                    // echo $additionalImage;die;
                    // if (file_exists($additionalImage)) {
                    //     $this->placeAdditionalImage($imageManager, $image, $value, $additionalImage);
                    // }
                    if (Storage::disk('public')->exists(str_replace('storage/', '', $company_logo))) {
                        $additionalImage = Storage::disk('public')->path(str_replace('storage/', '', $company_logo));
                        $this->placeAdditionalImage($imageManager, $image, $value, $additionalImage);
                    }
                }else if($key == 'sponsor_name'){
                    $this->renderText($image, $value, $key, $sponsor_data->company_name);
                }else if($key == 'person_name'){
                    $this->renderText($image, $value, $key, $person_name);
                } 
                else if($key == 'person_title'){
                    $this->renderText($image, $value, $key, $title_for);
                }
                else if($key == 'commemoration'){
                    $this->renderText($image, $value, $key, $purpose);
                }
                else if($key == 'book_number' || $key == 'book_number_1'){
                    $this->renderText($image, $value, $key, $sponsor_data->last_booklet);
                }
                else if(($key == 'coupon_number' || $key == 'coupon_number_1' ) && !empty($queryCoupon)){
                    $this->renderText($image, $value, $key, $coupon->number);
                }
                else if($key == 'sponsor_address'){
                    $this->renderText($image, $value, $key, $sponsor_data->address);
                }
                else if($key == 'sponsor_city'){
                    $this->renderText($image, $value, $key, $sponsor_data->city);
                }
                else if($key == 'sponsor_zipcode'){
                    $this->renderText($image, $value, $key, $sponsor_data->postal_code);
                    
                }
                else if($key == 'amount_in_words' && !empty($coupon) && !empty($queryCoupon)){
                    $title = ucwords(str_replace('-', " ", $f->format($coupon->amount)) . ' dollars');
                    $this->renderText($image, $value, $key, $title);
                }
                else if($key == 'amount_in_digit' && !empty($coupon) && !empty($queryCoupon)){
                    $this->renderText($image, $value, $key, $coupon->amount);
                }
                else if($key == 'shorten_url' && !empty($coupon)){
                    $title = str_replace(config('services.replace_url'), '', $coupon->shorten_url_redeem);
                    $this->renderText($image, $value, $key, $title);

                }else if ($key == 'sponsor_qr' && !empty($coupon)) {
                    $options = new QROptions([
                        'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                        ]);
                        
                    $additionalImage = (new QRCode($options))->render($coupon->shorten_url_activate);
    
                   $this->placeAdditionalImage($imageManager, $image, $value, $additionalImage);
                } else if ($key == 'bbo_qr' && !empty($coupon)) {
                    $options = new QROptions([
                        'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                        ]);
                        
    
                    $additionalImage = (new QRCode($options))->render($coupon->shorten_url_redeem);
    
                    $this->placeAdditionalImage($imageManager, $image, $value, $additionalImage);
                }
                else if ($key == 'qr_code') {
                    $options = new QROptions([
                        'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                        ]);
                        
    
                    $additionalImage = (new QRCode($options))->render("https://adlee.io");
    
                    $this->placeAdditionalImage($imageManager, $image, $value, $additionalImage);
                }
    
            }

            $imageBinary = $image->encodeByExtension('png');
           return base64_encode($imageBinary);
            // return response()->make($imageBinary, 200, [
            //     'Content-Type' => 'image/png',
            //     'Content-Disposition' => 'inline; filename="edited_image.png"',
            // ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Image processing failed'.$e->getMessage()], 500);
        }
    }
    
    public function downloadAgreement()
    {
        $this->coupon->load(['task:coupon_id,document_id,signed_at']);

        if (is_null($this->coupon->task?->signed_at)) {
            return back()->with('error', 'Please provide e-signature consent first to download the template.');
        }

        $downloadDocumentAPIUrl = "https://api.boldsign.com/v1/document/download?documentId=" . $this->coupon->task->document_id;

        $headers = [
            'Accept' => 'application/json',
            'X-API-Key' => config('services.boldsign.api_key')
        ];

        $client = new \GuzzleHttp\Client(['verify' => false]);

        $response = $client->request('GET', $downloadDocumentAPIUrl, ['headers' => $headers]);


        // Debug API Response
        if ($response->getHeaderLine('Content-Type') !== 'application/pdf') {
            dd('Unexpected API response:', [
                'headers' => $response->getHeaders(),
                'body' => $response->getBody()->getContents()
            ]);
        }

        // Fetch binary content safely
        $fileContent = stream_get_contents($response->getBody()->detach());
        // dd($fileContent);
        $fileName = "e-sign-" . $this->coupon->number . ".pdf";
        // session()->flash('redirect_after_download', route('ad-space-owner.coupons.index'));

        return response()->streamDownload(function () use ($fileContent) {
            echo $fileContent;
            $this->redirectToListing();
        }, $fileName, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    public function redirectToListing()
    {
        sleep(3);

        // Redirect to the desired route
        return redirect()->route('ad-space-owner.coupons.index');
    }
}
