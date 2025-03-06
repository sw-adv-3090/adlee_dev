<?php

namespace App\Livewire\Sponsor\Coupons;

use App\Enums\TemplateLanguage;
use App\Enums\TemplateType;
use App\Models\Coupon;
use App\Models\Template;
use Illuminate\Validation\Rule;
use Livewire\Component;
use AshAllenDesign\ShortURL\Facades\ShortURL;
use App\Models\DesignerTemplate;
use App\Models\Sponsor;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Geometry\Factories\LineFactory;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class Create extends Component
{
    public string $step = "info";
    public string $title, $amount, $confirm_amount, $payout_deadline;
    public string $language, $template_id = "";
    public string $search = "";
    public string $couponId;
    public $coupon_min_amount = 1;

    public function mount()
    {
        $this->language = TemplateLanguage::ENGLISH->value;
        // $this->title = "Deserunt";
        // $this->amount = "49";
        // $this->confirm_amount = "49";
        // $this->payout_deadline = "7";
        // $this->template_id = 2;
        // $this->step = "template";
    }

    public function render() {
        $templates = DesignerTemplate::
         whereLanguage($this->language)
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
                } else if ($key == 'book_number' || $key == 'book_number_1' )  {
                    $this->renderText($image, $value, $key, $sponsor_data->last_booklet);
                } else if ($key == 'coupon_number' || $key == 'coupon_number_1') {
                    $this->renderText($image, $value, $key, $sponsor_data->last_coupon);
                } else if ($key == 'sponsor_address') {
                    $this->renderText($image, $value, $key, $sponsor_data->address);
                } else if ($key == 'sponsor_city') {
                    $this->renderText($image, $value, $key, $sponsor_data->city);
                } else if ($key == 'sponsor_zipcode') {
                    $this->renderText($image, $value, $key, $sponsor_data->postal_code);

                }
                else if($key == 'amount_in_words' && !empty($coupon)){
                    $title = ucwords(str_replace('-', " ", $f->format($coupon->amount)) . ' dollars');
                    $this->renderText($image, $value, $key, $title);
                }
                else if($key == 'amount_in_digit' && !empty($coupon)){
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
                                    
            }

            // Encode the processed image as a base64 string
            $imageBinary = $image->encodeByExtension('png');
            $template->preview = 'data:image/png;base64,' . base64_encode($imageBinary);
        }

        }
        return view('livewire.sponsor.coupons.create', [
            'templates' => $templates
        ]);
    }

    private function placeAdditionalImage(ImageManager $imageManager, \Intervention\Image\Image $image, array $value, string $aImage) {
        $additionalImage = $imageManager->read($aImage);
        $additionalImage->resize($value['width'], $value['height']);
        $image->place($additionalImage, 'absolute', $value['x'] - $value['width'] / 2, $value['y'] - $value['height'] / 2);
    }

    private function renderText(\Intervention\Image\Image $image, array $value, string $key, string $title) {
        $fontSize = (float) str_replace('px', '', $value['font']);
        if (isset($value['fontFamily'])) {
            $fontFile = $this->getFontFile($value['fontFamily'],$value['bold'], $value['italic']);  
        } else {
            $fontFile = $this->getFontFile(null,$value['bold'], $value['italic']);
        }   
        $fontColor = $value['color'];
        $image->text($title, $value['x'], $value['y'] + $fontSize, function ($font) use ($fontFile, $fontSize, $fontColor) {
            $font->file(public_path('fonts/arial-font/' . $fontFile));
            $font->size($fontSize);
            $font->color($fontColor);
        });

        if ($value['underline']) {
            $image->drawLine(function (LineFactory $line) use ($value, $key, $fontSize, $fontColor) {
                $line->from($value['x'], $value['y'] + $fontSize + 5);
                $line->to($value['x'] + strlen($value['dummyText']) * ($fontSize / 2), $value['y'] + $fontSize + 5);
                $line->color($fontColor);
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
        if (!empty($fontMap[$fontFamily])) {
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
        $this->step = $step;
    }

    public function selectTemplate($id)
    {
        $this->template_id = $id;
    }

    public function validateInfo()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:' . $this->coupon_min_amount],
            'confirm_amount' => ['required', 'numeric', 'min:' . $this->coupon_min_amount, 'same:amount'],
            'payout_deadline' => ['required'],
        ]);

        $this->step = "template";
    }
    public function save()
    {
        $this->create();

        return to_route('sponsors.coupons.index')->with('success', 'New coupon created successfully.');

    }

    public function saveAndSend()
    {
        $this->create();

        return to_route('sponsors.coupons.send.index', $this->couponId)->with('success', 'New coupon created successfully.');
    }

    private function create()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:' . $this->coupon_min_amount],
            'confirm_amount' => ['required', 'numeric', 'min:' . $this->coupon_min_amount, 'same:amount'],
            'payout_deadline' => ['required'],
            'language' => ['required', Rule::enum(TemplateLanguage::class)],
            'template_id' => ['required', 'exists:designer_templates,id'],
        ], [
            'template_id.required' => 'Please select a template',
            'template_id.exists' => 'The selected template does not exist.'
        ]);
        $sponsor = auth()->user()->sponsor;

        $data = [];
        $data['user_id'] = auth()->id();
        $data['sponsor_id'] = sponsorId();
        $data['title'] = $this->title;
        $data['amount'] = $this->amount;
        // $data['payout_deadline'] = (int) $sponsor->default_coupon_payout;
        $data['payout_deadline'] = (int) $this->payout_deadline;
        // $data['payout_on'] = now()->addDays($data['payout_deadline']);
        $data['language'] = $this->language;
        $data['template_id'] = $this->template_id;
        $coupon_number = next_number($sponsor->last_coupon);
        $data['number'] = $sponsor->code . '-' . $sponsor->name_code . '-' . $coupon_number;

        // create coupon
        $coupon = Coupon::create($data);

        // update coupon shorten url
        $coupon->update([
            'shorten_url_activate' => ShortURL::destinationUrl(route('sponsors.coupons.activate.index', $coupon->uuid))->make()->default_short_url,
            'shorten_url_redeem' => ShortURL::destinationUrl(route('ad-space-owner.coupons.redeem.index', $coupon->uuid))->make()->default_short_url,
        ]);

        // update sponsor last coupon number
        $sponsor->update([
            'last_coupon' => $coupon_number,
        ]);

        $this->couponId = $coupon->uuid;
    }
}
