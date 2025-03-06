<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Template;
use App\Services\DataService;
use App\Services\TestDataService;
use App\Models\DesignerTemplate;
use App\Models\Sponsor;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Decoders\FilePathImageDecoder;
use Intervention\Image\Geometry\Factories\LineFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

use AshAllenDesign\ShortURL\Facades\ShortURL;

class TemplatePreviewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Template $template)
    {
        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);

        if ($request->has('coupon')) {
            $coupon = Coupon::with(['booklet:id,number', 'sponsor:id,company_name,company_logo,address,city,postal_code'])->where('uuid', $request->coupon)->first();

            abort_if(is_null($coupon), 404);

            $data = [
                'adlee_logo' => "https://adlee.io/demo/adlee-logo.png",
                'sponsor_logo' => asset($coupon->sponsor->company_logo),
                'sponsor_name' => $coupon->sponsor->company_name,
                'book_number' => $coupon->booklet?->number,
                'coupon_number' => $coupon->number,
                'sponsor_address' => $coupon->sponsor->address,
                'sponsor_city' => $coupon->sponsor->city,
                'sponsor_zipcode' => $coupon->sponsor->postal_code,
                'amount_in_words' => ucwords(str_replace('-', " ", $f->format($coupon->amount)) . ' dollars'),
                'amount_in_digits' => $coupon->amount,
                'sponsor_qr_code' => QrCode::size(80)->style('round')->generate($coupon->shorten_url_activate),
                'bbo_qr_code' => QrCode::size(50)->style('round')->generate($coupon->shorten_url_redeem),
                'shorten_url' => str_replace(config('services.replace_url'), '', $coupon->shorten_url_redeem),
            ];

        } elseif ($request->has('task')) {
            $service = new DataService();
            $language = $template?->language ?? 'english';
            $name = $language . "_name";
            $coupon = Coupon::with(['task'])->where('uuid', $request->get('task'))->first();
            $data = $service->template($coupon, $coupon->task->$name);
            // dd($template->view);
            // dd($data);
        } else {
            $service = new TestDataService();
            $data = $service->template();
        }


        // return view("templates/coupons/oW659tMThyhVwXRG", $data);
        return view($template->view, $data);
    }

    public function templatePreview(Request $request, DesignerTemplate $template)
    {
        $queryCoupon = \request()->query('coupon');
        
        $from_coupon_listing = true;
        $id = $template->id;
        $designerTemplate = DesignerTemplate::find($id);
        $sponsor = auth()->user();
        $sponsor_data = Sponsor::where('user_id', $sponsor->id)->first();
        $coupon_id = (int) $sponsor_data->last_coupon;
        if(!empty($queryCoupon)){
            $coupon_id = $queryCoupon;
        }
        
        $coupon = Coupon::with(['booklet:id,number', 'sponsor:id,company_name,company_logo,address,city,postal_code'])->where('id', $coupon_id)->first();
        // $coupon = Coupon::get();
        //  echo "<pre>";
        // print_r($coupon);die;
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
                    $this->renderText($image, $value, $key, 'David Smith');
                } 
                else if($key == 'person_title'){
                    $this->renderText($image, $value, $key, 'MR.');
                }
                else if($key == 'commemoration'){
                    $this->renderText($image, $value, $key, 'In Honor Of');
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
            return response()->make($imageBinary, 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'inline; filename="edited_image.png"',
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Image processing failed'.$e->getMessage()], 500);
        }
    }

    private function placeAdditionalImage(ImageManager $imageManager,\Intervention\Image\Image $image, array $value, string $aImage)
    {
        $additionalImage = $imageManager->read($aImage);
        $additionalImage->resize($value['width'], $value['height']);
        $image->place($additionalImage, 'absolute', $value['x'] - $value['width'] / 2, $value['y'] - $value['height'] / 2);
    }

    private function renderText(\Intervention\Image\Image  $image, array $value, string $key, string $title)
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
                        $line->color($value['#000000']);
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
