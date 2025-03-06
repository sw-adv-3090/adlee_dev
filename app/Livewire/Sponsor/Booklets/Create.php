<?php

namespace App\Livewire\Sponsor\Booklets;

use App\Enums\BookletPrintStatus;
use App\Enums\TemplateLanguage;
use App\Enums\TemplateType;
use App\Jobs\SendBookletForPrint;
use App\Models\Booklet;
use App\Models\BookletPrint;
use App\Models\Coupon;
use App\Models\DesignerTemplate;
use App\Models\Template;
use App\Models\Sponsor;
use App\Models\Task;
use App\Notifications\ShipmentCreatedNotification;
use App\Services\ShipEngineService;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use AshAllenDesign\ShortURL\Facades\ShortURL;
use Carbon\Carbon;
use Intervention\Image\Geometry\Factories\LineFactory;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Support\Facades\Notification;

class Create extends Component
{
    public string $step = "info";
    public string $title, $amount, $confirm_amount, $payout_deadline, $coupons;
    public string $language, $template_id = "";
    public string $search = "";
    public int $couponLimit = 50;
    public $booklet_min_amount = 1;
    public $newCreatedbooklet;
    public $data;
    public $bookletLanguage;
    public $english_title;
    public $hebrew_title;
    public $english_name;
    public $hebrew_name;
    public $purpose;
    public $purpose_eng;
    public $purpose_heb;
    // public $purposeHeb;
    public $booklet;
    public $wizard_view;

    public function mount($bookletId = null, $wizard_view = null)
    {
        $this->language = TemplateLanguage::ENGLISH->value;
        $this->coupons = "50";
        if (empty($bookletId) || empty($wizard_view)) {
            // Return an empty response or a default value
            $this->booklet = null;
            $this->wizard_view = null;
            // $this->step = 'info';
        } else {
            $this->booklet = Booklet::find($bookletId);
            $this->newCreatedbooklet = $this->booklet;
            $this->wizard_view = $wizard_view;
            $this->step = $wizard_view;
            if($this->step == 'activate'){
                $this->data['total'] = $this->newCreatedbooklet->coupons->count();
                $this->data['activated'] = $this->newCreatedbooklet->coupons->whereNotNull('activated_at')->count();
                $this->data['notActivated'] = $this->newCreatedbooklet->coupons->whereNull('activated_at')->count();
                $this->data['isCommemoration'] = request()->user()->sponsor->is_commemoration;
            
            }
        }

        // $this->title = "Deserunt";
        // $this->amount = "50";
        // $this->confirm_amount = "50";
        // $this->payout_deadline = "7";
        $this->payout_deadline =  auth()->user()->sponsor->default_coupon_payout; 

        // $this->coupons = "2";
        // $this->template_id = 2;
        // $this->step = "template";
    }

    public function render()
    {
        $templates = DesignerTemplate::whereLanguage($this->language)
            ->whereType(TemplateType::COUPON->value)
            ->where('approve', true)
            ->when($this->search, fn($q) => $q->whereLike(['title'], $this->search))
            ->get();

        // DesignerTemplate::whereType(TemplateType::COUPON->value)->whereLanguage($this->language)->when($this->search, fn($q) => $q->whereLike(['title'], $this->search))->get()
        $sponsor = auth()->user();
        $sponsor_data = Sponsor::where('user_id', $sponsor->id)->first();
        $coupon_id = (int) $sponsor_data->last_coupon;
        $coupon = Coupon::with(['booklet:id,number', 'sponsor:id,company_name,company_logo,address,city,postal_code'])->where('id', $coupon_id)->first();
        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);


        foreach ($templates as $template) {
            if (file_exists(public_path($template->file))) {
                $imageManager = new ImageManager(new Driver());
                $image = $imageManager->read(public_path($template->file));
                $image->resize($template->width, $template->height);

                $designerMetaData = json_decode($template->meta_data, true);
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
                        $additionalImage = storage_path(str_replace('storage/', '', $company_logo));

                        // if (Storage::disk('disk_path')->exists($company_logo)) {
                        if (file_exists($additionalImage)) {
                            $this->placeAdditionalImage($imageManager, $image, $value, $additionalImage);
                        }
                        // }
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
                    } else if ($key == 'amount_in_words' && !empty($coupon)) {
                        $title = ucwords(str_replace('-', " ", $f->format($coupon->amount)) . ' dollars');
                        $this->renderText($image, $value, $key, $title);
                    } else if ($key == 'amount_in_digit' && !empty($coupon)) {
                        $this->renderText($image, $value, $key, $coupon->amount);
                    } else if ($key == 'shorten_url' && !empty($coupon)) {
                        $title = str_replace(config('services.replace_url'), '', $coupon->shorten_url_redeem);
                        $this->renderText($image, $value, $key, $title);
                    } else if ($key == 'sponsor_qr' && !empty($coupon)) {
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
                }

                // Encode the processed image as a base64 string
                $imageBinary = $image->encodeByExtension('png');
                $template->preview = 'data:image/png;base64,' . base64_encode($imageBinary);
            }
        }



        // $this->templateCategories = $templatesByCategories->keys()->toArray();

        return view('livewire.sponsor.booklets.create', [
            'templates' => $templates
        ]);
        // return view('livewire.sponsor.booklets.create', [
        //     'templates' => Template::withCount(['booklets'])->whereType(TemplateType::COUPON->value)->whereLanguage($this->language)->when($this->search, fn($q) => $q->whereLike(['title'], $this->search))->get()
        // ]);
    }
    private function placeAdditionalImage(ImageManager $imageManager, \Intervention\Image\Image $image, array $value, string $aImage)
    {
        $additionalImage = $imageManager->read($aImage);
        $additionalImage->resize($value['width'], $value['height']);
        $image->place($additionalImage, 'absolute', $value['x'] - $value['width'] / 2, $value['y'] - $value['height'] / 2);
    }

    private function renderText(\Intervention\Image\Image $image, array $value, string $key, string $title)
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
                'bold' => 'arial-bold.ttf',
                'italic' => 'ARIALBLACKITALIC.ttf',
                'bold_italic' => 'ArialCEBoldItalic.ttf',
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
            'FrankRuhlLibre' => [
                'normal' => 'FrankRuhlLibre-Black.ttf',
                'bold' => 'FrankRuhlLibre-Black.ttf',
                'italic' => 'FrankRuhlLibre-Black.ttf',
                'bold_italic' => 'FrankRuhlLibre-Black.ttf',
            ],
            'ganclm bold' => [
                'normal' => 'ganclm_bold-webfont.ttf',
                'bold' => 'ganclm_bold-webfont.ttf',
                'italic' => 'ganclm_bold-webfont.ttf',
                'bold_italic' => 'ganclm_bold-webfont.ttf',
            ],
            'horevclm' => [
                'normal' => 'horevclm-heavy-webfont.ttf',
                'bold' => 'horevclm-heavy-webfont.ttf',
                'italic' => 'horevclm-heavy-webfont.ttf',
                'bold_italic' => 'horevclm-heavy-webfont.ttf',
            ],
            'journalclm' => [
                'normal' => 'journalclm-light-webfont.ttf',
                'bold' => 'journalclm-light-webfont.ttf',
                'italic' => 'journalclm-light-webfont.ttf',
                'bold_italic' => 'journalclm-light-webfont.ttf',
            ],
            'keteryg' => [
                'normal' => 'keteryg-medium-webfont.ttf',
                'bold' => 'keteryg-medium-webfont.ttf',
                'italic' => 'keteryg-medium-webfont.ttf',
                'bold_italic' => 'keteryg-medium-webfont.ttf',
            ],
            'makabiyg' => [
                'normal' => 'makabiyg-webfont.ttf',
                'bold' => 'makabiyg-webfont.ttf',
                'italic' => 'makabiyg-webfont.ttf',
                'bold_italic' => 'cmakabiyg-webfontourbi.ttf',
            ],
            'migdalfontwin' => [
                'normal' => 'migdalfontwin-webfont.ttf',
                'bold' => 'migdalfontwin-webfont.ttf',
                'italic' => 'migdalfontwin-webfont.ttf',
                'bold_italic' => 'migdalfontwin-webfont.ttf',
            ],
            'miriwin' => [
                'normal' => 'miriwin-webfont.ttf',
                'bold' => 'miriwin-webfont.ttf',
                'italic' => 'miriwin-webfont.ttf',
                'bold_italic' => 'miriwin-webfont.ttf',
            ],
            'MiriamLibre' => [
                'normal' => 'MiriamLibre-Regular.ttf',
                'bold' => 'MiriamLibre-Regular.ttf',
                'italic' => 'MiriamLibre-Regular.ttf',
                'bold_italic' => 'MiriamLibre-Regular..ttf',
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


    public function updatedLanguage()
    {
        $this->template_id = "";
    }

    public function changeStep($step)
    {
        $validSteps = ["info", "template", "printing"];
        if (in_array($step, $validSteps)) {
            $this->step = $step;
        }
    }

    public function selectTemplate($id)
    {
        $this->template_id = $id;
    }

    public function validateInfo()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:' . $this->booklet_min_amount],
            'confirm_amount' => ['required', 'numeric', 'min:' . $this->booklet_min_amount, 'same:amount'],
            'coupons' => ['required', 'numeric', 'multiple_of:' . $this->couponLimit],
            'payout_deadline' => ['required'],
        ], [
            'coupons.multiple_of' => 'The number of coupons must be a multiple of ' . $this->couponLimit
        ]);

        $this->step = "template";
    }
    public function save()
    {
        $this->create();
        $this->step = "printing";
       
        // return to_route('sponsors.booklets.index')->with('success', 'New booklet created successfully.');
    }

    private function create()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:' . $this->booklet_min_amount],
            'confirm_amount' => ['required', 'numeric', 'min:' . $this->booklet_min_amount, 'same:amount'],
            'coupons' => ['required', 'numeric', 'multiple_of:' . $this->couponLimit],
            // 'payout_deadline' => ['required'],
            'language' => ['required', Rule::enum(TemplateLanguage::class)],
            'template_id' => ['required', 'exists:designer_templates,id'],
        ], [
            'coupons.multiple_of' => 'The number of coupons must be a multiple of ' . $this->couponLimit,
            'template_id.required' => 'Please select a template',
            'template_id.exists' => 'The selected template does not exist.'

        ]);

        DB::transaction(function () {
            $sponsor = auth()->user()->sponsor;

            // creating new booklet
            $data = [];
            $data['user_id'] = auth()->id();
            $data['sponsor_id'] = sponsorId();
            $data['title'] = $this->title;
            $data['amount'] = $this->amount;
            // $data['payout_deadline'] = (int) $sponsor->default_coupon_payout;
            $data['payout_deadline'] = (int) $this->payout_deadline;
            $data['language'] = $this->language;
            $data['template_id'] = $this->template_id;
            $booklet_number = next_number($sponsor->last_booklet);
            $data['number'] = $sponsor->name_code . $booklet_number;

            $booklet = Booklet::create($data);
            $this->newCreatedbooklet = $booklet;
            // update sponsor last booklet number
            $sponsor->update([
                'last_booklet' => $booklet_number,
            ]);

            $lastCoupon = $sponsor->last_coupon;

            // creating coupons as sponsors choose to create
            for ($i = 0; $i < $this->coupons; $i++) {
                $data['booklet_id'] = $booklet->id;
                $coupon_number = next_number($lastCoupon);
                $data['number'] = $sponsor->code . '-' . $sponsor->name_code . '-' . $coupon_number;

                // create coupon
                $coupon = Coupon::create($data);

                // update coupon shorten url
                $coupon->update([
                    'shorten_url_activate' => ShortURL::destinationUrl(route('sponsors.coupons.activate.index', $coupon->uuid))->make()->default_short_url,
                    'shorten_url_redeem' => ShortURL::destinationUrl(route('ad-space-owner.coupons.redeem.index', $coupon->uuid))->make()->default_short_url,
                ]);

                $lastCoupon = $coupon_number;
            }

            // update sponsor last coupon number
            $sponsor->update([
                'last_coupon' => $coupon_number,
            ]);
        });
    }

    public function activateBooklet()
    {
        $booklet = Booklet::with('coupons')->find($this->newCreatedbooklet->id);
        foreach ($booklet->coupons as $coupon) {
            if (is_null($coupon->activated_at)) {
                // DB::transaction(function () use ($request, $coupon) {
                // activating coupon
                $coupon->update(['activated_at' => now()]);

                $userId = auth()->id();
                $sponsor = Sponsor::where('user_id', $userId)->first();

                // creating new task
                Task::create([
                    'user_id' => $userId,
                    'sponsor_id' => sponsorId(),
                    'coupon_id' => $coupon->id,
                    'assign_to' => $coupon->redeem?->id,
                    'is_commemoration' => $sponsor->is_commemoration,
                    'language' => $this->bookletLanguage,
                    // 'purpose' => $this->purpose,
                    'purpose_heb' => $this->purpose_heb,
                    'purpose_eng' => $this->purpose_eng,
                    'english_name' => $this->english_name,
                    'hebrew_name' => $this->hebrew_name,
                    'english_title' => $this->english_title,
                    'hebrew_title' => $this->hebrew_title,
                ]);
                // });
            }
        }
        return redirect()->route('sponsors.booklets.index')->with('success', 'Booklet has been sent for printing');
        // $this->step = "printing";
    }

    public function print(Booklet $booklet, ShipEngineService $service)
    {
        
        $booklet = Booklet::with('coupons', 'sponsor', )->find($this->newCreatedbooklet->id);
        abort_if($booklet->user_id != auth()->id(), 403, 'Unathorized action');

        $booklet->load(['coupons.template:id,file,preview,meta_data,height,width', 'user:id,name,email', 'sponsor']);
        // echo "<pre>";print_r($booklet);die;

        $data['service_code'] = settings('service_code');
        $data['ship_from'] = [
            'name' => settings('ship_from_name'),
            'company_name' => settings('ship_from_company_name'),
            'address_line1' => settings('ship_from_address'),
            'city_locality' => settings('ship_from_city'),
            'state_province' => getStateIsoCode(settings('ship_from_state')),
            'postal_code' => settings('ship_from_postal_code'),
            'country_code' => strtoupper(settings('ship_from_country')),
            'phone' => settings('ship_from_phone'),
        ];
        $data['ship_to'] = [
            'name' => $booklet->user?->name,
            'address_line1' => $booklet->sponsor?->shipping_address,
            'city_locality' => $booklet->sponsor?->shipping_city,
            'state_province' => getStateIsoCode($booklet->sponsor?->shipping_state),
            'postal_code' => $booklet->sponsor?->shipping_postal_code,
            'country_code' => strtoupper($booklet->sponsor?->shipping_country),
        ];
        $data['weight'] = settings('weight');
        $data['length'] = settings('length');
        $data['width'] = settings('width');
        $data['height'] = settings('height');

        // create shipengine label shipment
        $response = $service->createLabel($data);
// echo "<pre>"; print_r($response);die;        
        // if any error happened,
        if (isset($response['errors']) && count($response['errors']) > 0) {
            dd($response['errors']);
        } else {
            // DB::transaction(function () use ($booklet, $request, $response) {
                $type = "paid";
                $user = request()->user();
                $plan = $user->plan();
                $printsCurrentMonth = $user->prints()->month()->count();
                $freeBooklets = $plan->free_booklets;
                if ($printsCurrentMonth < $freeBooklets) {
                    $type = "free";
                }
                // $amountPaid = $request->has('amountPaid') ? (int) $request->get('amountPaid') : 0;
                $amountPaid =  0;

                // create database record for printing
                $bookletPrint = BookletPrint::create([
                    'user_id' => auth()->id(),
                    'booklet_id' => $booklet->id,
                    'status' => BookletPrintStatus::CREATED->value,
                    'type' => $type,
                    'amount_paid' => $amountPaid
                ]);

                $bookletPrint->load(['user.sponsor']);

                $bookletPrint->shipment()->create([
                    'label_id' => $response['label_id'],
                    'shipment_id' => $response['shipment_id'],
                    'tracking_number' => $response['tracking_number'],
                    'status' => $response['status'],
                    'carrier_id' => settings('carrier_id'),
                    'carrier_code' => $response['carrier_code'],
                    'service_code' => settings('service_code'),
                    'ship_date' => Carbon::parse($response['ship_date']),
                    'tracking_url' => $response['tracking_url'],
                    'tracking_status' => $response['tracking_status'],
                    'amount' => $response['shipment_cost']['amount'],
                    'download_pdf' => $response['label_download']['pdf'],
                    'download_png' => $response['label_download']['png'],
                    'download_zpl' => $response['label_download']['zpl'],
                ]);

                $bookletPrint->update(['status' => $response['tracking_status']]);

                // send notification mail to sponsor about the shipment
                Notification::send($bookletPrint->user, new ShipmentCreatedNotification($bookletPrint->user->name, $bookletPrint->booklet->number, $response['tracking_number'], $response['tracking_url']));

                // send print job to queue
                SendBookletForPrint::dispatch($booklet, $bookletPrint);
            // });
            
                $this->step = 'activate';
                $this->data['total'] = $this->newCreatedbooklet->coupons->count();
                $this->data['activated'] = $this->newCreatedbooklet->coupons->whereNotNull('activated_at')->count();
                $this->data['notActivated'] = $this->newCreatedbooklet->coupons->whereNull('activated_at')->count();
                $this->data['isCommemoration'] = request()->user()->sponsor->is_commemoration;
                
            // return redirect()->route('sponsors.booklets.index')->with('success', 'Booklet has been sent for printing');
        }
    }
}
