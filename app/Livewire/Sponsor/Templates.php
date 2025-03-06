<?php

namespace App\Livewire\Sponsor;

use App\Enums\TemplateLanguage;
use App\Enums\TemplateType;
use App\Models\DesignerTemplate;
use App\Models\SponsorTemplate;
use App\Models\Template;
use App\Models\Coupon;
use Livewire\Component;
use App\Models\Sponsor;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Geometry\Factories\LineFactory;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class Templates extends Component
{
    public string $language = TemplateLanguage::ENGLISH->value;
    public array $selectedTemplates = [];
    public array $templateCategories = [];
    public array $selectedCategories = [];
    public int $perCategoryTemplateLimit = 0;


    public function mount()
    {
        $this->perCategoryTemplateLimit = request()->user()->plan()?->template_limit;
        foreach (auth()->user()->designerTemplates as $item) {
            $this->selectedTemplates[] = $item->template_id;
            $this->selectedCategories[] = $item->category_id;
        }
    }

    public function render()
    {
        // $templatesByCategories = Template::query()
        //     ->with(['category'])
        //     ->select(['id', 'uuid', 'title', 'view', 'preview', 'language', 'category_id', 'sub_category_id'])
        //     ->whereLanguage($this->language)
        //     ->whereType(TemplateType::SPONSOR->value)
        //     ->whereActive(true)
        //     ->whereDate('publish_at', '<=', now())
        //     ->get()
        //     ->groupBy('category_id');

        $templatesByCategories = DesignerTemplate::query()
            ->with(['category'])
            ->select(['id', 'preview', 'file', 'meta_data', 'width', 'height', 'language', 'category_id', 'sub_category_id'])
            ->whereLanguage($this->language)
            ->whereType(TemplateType::SPONSOR->value)
            ->where('approve', true)
            ->whereDate('publish_at', '<=', now())
            ->get()
            ->groupBy('category_id');
        $sponsor = auth()->user();
        $sponsor_data = Sponsor::where('user_id', $sponsor->id)->first();
        $coupon_id = (int) $sponsor_data->last_coupon;
        $coupon = Coupon::with(['booklet:id,number', 'sponsor:id,company_name,company_logo,address,city,postal_code'])->where('id', $coupon_id)->first();
        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
//         echo "<pre>";
// print_r($templatesByCategories);die;

        // $this->templateCategories = [];
        foreach ($templatesByCategories as $categoryId => $templates) {
            // $this->templateCategories[] = $categoryId;
            foreach ($templates as $template) {

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
                        // $additionalImage = storage_path(str_replace('storage/', '', $company_logo));
                        // if (file_exists($additionalImage)) {
                        //     $this->placeAdditionalImage($imageManager, $image, $value, $additionalImage);
                        // }
                        if (Storage::disk('public')->exists(str_replace('storage/', '', $company_logo))) {
                            $additionalImage = Storage::disk('public')->path(str_replace('storage/', '', $company_logo));
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
                    } else if ($key == 'book_number' || $key == 'book_number_1' ) {
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

        $this->templateCategories = $templatesByCategories->keys()->toArray();


        return view('livewire.sponsor.templates', [
            'categories' => $templatesByCategories,
        ]);
    }

    public function toggleTemplates($id, $categoryId)
    {
        if (in_array($id, $this->selectedTemplates)) {
            // remove templates from the list
            $key = array_search($id, $this->selectedTemplates);
            unset($this->selectedTemplates[$key]);

            // remove category from the list
            $key = array_search($categoryId, $this->selectedCategories);
            unset($this->selectedCategories[$key]);
        } else {
            // count the number of templates for specific category
            $categoryExistsCount = count(array_filter($this->selectedCategories, function ($value) use ($categoryId) {
                return $value == $categoryId;
            }));

            // user has not reached the limit of selecting templates for each category
            if ($categoryExistsCount < $this->perCategoryTemplateLimit) {
                // adding template to the list
                $this->selectedTemplates[] = $id;

                // adding category to the list
                $this->selectedCategories[] = $categoryId;
            } else {
                // user has reached the limit of selecting templates for each category
                session()->flash('error', 'You can only choose ' . $this->perCategoryTemplateLimit . ' templates from each category in your current subscription plan.');
            }
        }
    }

    public function saveTemplates()
    {
        // echo "<pre>";
        // print_r($this->templateCategories);
        // echo "selected categories---------";
        // print_r($this->selectedCategories);
        // echo "selected templates---------";
        // print_r($this->selectedTemplates);
        // die;

        // make sure user has select template from each category
        if (count($this->templateCategories) != count(array_unique($this->selectedCategories))) {
            // $this->js("alert('Please select atleast one template from each category.')");
            session()->flash('error', 'Please select atleast one template from each category.');
            return;
        }

        // delete all old templates of sponsors
        SponsorTemplate::where('sponsor_id', auth()->user()->sponsor->id)->delete();

        // saving the selected templates to database
        foreach ($this->selectedTemplates as $templateId) {
            $template = DesignerTemplate::select(['category_id', 'sub_category_id'])->find($templateId);
            SponsorTemplate::updateOrCreate(['user_id' => auth()->id(), 'template_id' => $templateId], [
                'sponsor_id' => auth()->user()->sponsor->id,
                'category_id' => $template->category_id,
                'sub_category_id' => $template->sub_category_id,
            ]);
        }

        return to_route('sponsors.dashboard')->with('status', 'You have successfully complated onboarding process.');

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
            $fontFile = $this->getFontFile($value['fontFamily'],$value['bold'], $value['italic']);  
        } else {
            $fontFile = $this->getFontFile('',$value['bold'], $value['italic']);
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
}
