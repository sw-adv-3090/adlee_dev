<?php

namespace App\Http\Controllers\AdSpaceOwner;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Sponsor;
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


class PrintTemplateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Coupon $coupon)
    {
        $coupon->load(['task']);
        return view('ad-space-owner.coupons.print', compact('coupon'));
    }
    /**
     * Handle the print request.
     */
    public function print(Request $request, Coupon $coupon, DataService $service)
    {
        // $coupon->load(['task', 'sponsor', 'user']);

    
        // $generatedImage = $this->generateImage($coupon);

        // $htmlContent = '<img src="data:image/png;base64,' . base64_encode($generatedImage) . '" style="max-width: 100%; max-height: auto;width: auto; height: auto;">';
// echo $htmlContent;die;
        // $pdf = Pdf::loadHtml($htmlContent)->setPaper('A3', 'landscape');

        // return $pdf->download($coupon->number . '.pdf');

        $coupon->load(['task', 'sponsor', 'user']);

        if (is_null($coupon->task->document_id) || is_null($coupon->task->signed_at)) {
            return back()->with('error', 'Please provide e-signature consent first to download the template.');
        }

        // if user is not signed his consent through e-signature
        if (is_null($coupon->task->signed_at)) {
            $success = sign_task($coupon);

            if (!$success) {
                return back()->with('error', 'Please provide e-signature consent first to download the template.');
            }
        }

        // update database
        $coupon->task->update(['printed_at' => now(), 'status' => 'printed']);
        $coupon->update(['payout_on' => now()->addDays($coupon->payout_deadline)]);

        // Generate pdf file
        $template = $coupon->task->template;
        $language = $template?->language ?? 'english';
        $name = $language . "_name";
        $commemoration = $coupon->task->$name;
        
        $generatedImage = $this->generateImage($coupon);
            
        // Add the image to the HTML content
        $htmlContent = '<img src="data:image/png;base64,' . base64_encode($generatedImage) . '" style="width: 100%; height: auto;">';


    // echo $htmlContent;die;
    $pdf = Pdf::loadHtml($htmlContent)->setPaper('A4', 'portrait');
    
    // $pdf = Pdf::loadHtml($htmlContent)->setPaper('legal', 'landscape');

        return $pdf->download($coupon->number . '.pdf');

    }
    public function generateImage($coupon){
        //GENERATE IMAGE
        $file = $coupon->task->template->file;
        $id = $coupon->task->template->id;
        $designerTemplate = $coupon->task->template;
        $sponsor_data = Sponsor::where('user_id', $coupon->user_id)->first();
        $coupon_id = (int) $sponsor_data->last_coupon;
        
        if (!empty($coupon->task) && $coupon->task->language == 'english'){
            $title_for = $coupon->task->english_title;
            $person_name = $coupon->task->english_name;
        }else if (!empty($coupon->task) && $coupon->task->language == 'hebrew'){
            $title_for = $coupon->task->hebrew_title;
            $person_name = $coupon->task->hebrew_name;
        }else{
            $template_language = $designerTemplate->language; 
            $title_for = $template_language == 'english' ? $coupon->task->english_title : $coupon->task->hebrew_title;
            $person_name = $template_language == 'english' ? $coupon->task->english_name : $coupon->task->hebrew_name;
         }
    
        //getting latest record of coupon
        // $coupon = Coupon::where('user_id', $sponsor->id)->latest('id')->first();
      
        // $coupon = Coupon::with(['booklet:id,number', 'sponsor:id,company_name,company_logo,address,city,postal_code'])->where('id', $coupon_id)->first();
      
        $designerMetaData = json_decode($designerTemplate->meta_data, true);
        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
        $imageManager = new ImageManager(new Driver());
        $image = $imageManager->read(public_path($file), decoders: FilePathImageDecoder::class);
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
                // $additionalImage = Storage::disk('disk_path')->path($company_logo);
                $additionalImage = Storage::disk('public')->path(str_replace('storage/', '', $company_logo)); //storage_path(str_replace('storage/', '', $company_logo));
                if (file_exists($additionalImage)) {
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
                $this->renderText($image, $value, $key, 'In Honor Of');
            }
            else if($key == 'book_number' || $key == 'book_number_1'){
                $this->renderText($image, $value, $key, $sponsor_data->last_booklet);
            }
            else if($key == 'coupon_number' || $key == 'coupon_number_1'){
                $this->renderText($image, $value, $key, $sponsor_data->last_coupon);
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
            else if ($key == 'qr_code') {
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

}
