<?php

namespace App\Jobs;

use App\Enums\BookletPrintStatus;
use App\Models\Booklet;
use App\Models\BookletPrint;
use App\Models\Coupon;
use App\Models\Sponsor;
use App\Services\DataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Decoders\FilePathImageDecoder;
use Intervention\Image\Geometry\Factories\LineFactory;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Zip;
use Illuminate\Support\Facades\File;

class SendBookletForPrint  implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Booklet $booklet, public BookletPrint $bookletPrint)
    {
        //
    }

    /**
     * Execute the job.
     */

     public function handle(): void

     {
         $service = new DataService();
         
         $folderName = $this->booklet->number;
         $fileName = "coupons.pdf";

         $htmlContent = '<html><head><style>
                            @page { margin: 0; }
                            body { margin: 0; padding: 0; }
                            .coupon-page { width: 100%; height: 100%; page-break-after: always; }
                            .coupon-image { width: 100%; height: 100%; display: block; }
                        </style></head><body>';

         
         // Initialize a container for all pages
         $pdf = Pdf::loadHtml('');
     
         // Set paper size and orientation
         $pdf->setPaper('legal', 'landscape');
         
         // Loop through all coupons to generate pages
         foreach ($this->booklet->coupons as $index => $coupon) {
            $generatedImage = $this->generateImage($coupon);

            $htmlContent .= '<div class="coupon-page">
                <img src="data:image/png;base64,' . base64_encode($generatedImage) . '" class="coupon-image">
            </div>';
         }

         $htmlContent .= '</body></html>';

         // Generate the PDF
         $pdf = Pdf::loadHtml($htmlContent);
        
         // Set paper size and orientation
         $customPaper = array(0, 0, 486, 216);

         $pdf->setPaper($customPaper, 'portrait');
         
        
         // Add a page break for each coupon except the last one
         // if ($index < count($this->booklet->coupons) - 1) {
         //     $htmlContent .= '<div style="page-break-after: always;"></div>';
         // }
         // break;
 
          // Create a unique file name for the current coupon's PDF
        //   $fileName = "coupon_{$index}.pdf";
 
 
          // Save the PDF to storage
          Storage::disk('local')->put($fileName, $pdf->output());
          
          // Put the PDF path into files array
          $files[] = Storage::disk('local')->path($fileName);
       
         
         
         // $files[] = public_path($fileName);
 
         // Saving shipping info inside coupon folder
         $content = "";
         $content .= $this->booklet->user?->name;
         $content .= "\n\n";
         $content .= $this->booklet->sponsor?->shipping_address;
         $content .= "\n";
         $content .= $this->booklet->sponsor?->shipping_city;
         $content .= "\n";
         $content .= $this->booklet->sponsor?->shipping_state;
         $content .= "\n";
         $content .= country_name($this->booklet->sponsor?->shipping_country);
         $content .= "\n";
         $content .= "order is shipping if possible. - or email when tracking is here ";
         $content .= $this->booklet->user?->email;
         $content .= "\n\nCompany Name: ";
         $content .= $this->booklet->sponsor?->company_name;
         $content .= "\n\nShipEngine Shipment Label:";
         $content .= "\n";
         $content .= "PDF: <a href=\"https://34bf-39-36-43-27.ngrok-free.app/shipengine/webhook\">https://34bf-39-36-43-27.ngrok-free.app/shipengine/webhook</a>";
         $content .= "\n";
         $content .= "PNG: <a href=\"https://34bf-39-36-43-27.ngrok-free.app/shipengine/webhook\">https://34bf-39-36-43-27.ngrok-free.app/shipengine/webhook</a>";
         $content .= "\n";
         $content .= "ZPL: <a href=\"https://34bf-39-36-43-27.ngrok-free.app/shipengine/webhook\">https://34bf-39-36-43-27.ngrok-free.app/shipengine/webhook</a>";
         
         Storage::disk('local')->put($folderName . '/shipping.txt', $content);
         // Add shipping info file to files array to be zipped
         $files[] = Storage::disk('local')->path($folderName . '/shipping.txt');
         
         // Create zip file
         $zipFilePath = public_path('prints');
         $zip = Zip::create($folderName . ".zip", $files)->saveTo($zipFilePath);
         
         // File information
         $fileName = $folderName . '.zip';
         $filePath = $zipFilePath . '/' . $fileName;
         
         // Send email to admin about print booklet information with zip file
         $emails = settings('print-emails');
         $emails = !is_null($emails) ? json_decode($emails) : [];
         
         foreach ($emails as $email) {
             Notification::route('mail', $email)
             ->notify(new \App\Notifications\SendBookletForPrint($this->booklet->user->name, $filePath, $fileName));
         }
         
         // Delete folder from storage path
         Storage::disk('local')->deleteDirectory($folderName);
         
         // Delete zip file from public folder
         File::delete($filePath);
         
         // Update the status of booklet print to send
         $this->bookletPrint->update(['status' => BookletPrintStatus::SEND->value]);
    }


    public function handleOld(): void

    {
        $service = new DataService();
        
        $folderName = $this->booklet->number;
        $fileName = "coupons.pdf";
        $files = [];
        
        // Initialize a container for all pages
        $htmlContent = '';
        
        // Loop through all coupons to generate pages
        foreach ($this->booklet->coupons as $index => $coupon) {
            // $preview = $coupon->template->preview;
            // $imagePath = public_path($preview); 
        $generatedImage = $this->generateImage($coupon);
            
            // Add the image to the HTML content
        $htmlContent = '<img src="data:image/png;base64,' . base64_encode($generatedImage) . '" style="width: 100%; height: auto;">';
        
           // Generate the PDF
           $pdf = Pdf::loadHtml($htmlContent);
        
           // Set paper size and orientation
           $pdf->setPaper('legal', 'landscape');
           
        // Add a page break for each coupon except the last one
        // if ($index < count($this->booklet->coupons) - 1) {
        //     $htmlContent .= '<div style="page-break-after: always;"></div>';
        // }
        // break;

         // Create a unique file name for the current coupon's PDF
         $fileName = "coupon_{$index}.pdf";


         // Save the PDF to storage
         Storage::disk('local')->put($fileName, $pdf->output());
         
         // Put the PDF path into files array
         $files[] = Storage::disk('local')->path($fileName);
      
        }
        
        // $files[] = public_path($fileName);

        // Saving shipping info inside coupon folder
        $content = "";
        $content .= $this->booklet->user?->name;
        $content .= "\n\n";
        $content .= $this->booklet->sponsor?->shipping_address;
        $content .= "\n";
        $content .= $this->booklet->sponsor?->shipping_city;
        $content .= "\n";
        $content .= $this->booklet->sponsor?->shipping_state;
        $content .= "\n";
        $content .= country_name($this->booklet->sponsor?->shipping_country);
        $content .= "\n";
        $content .= "order is shipping if possible. - or email when tracking is here ";
        $content .= $this->booklet->user?->email;
        $content .= "\n\nCompany Name: ";
        $content .= $this->booklet->sponsor?->company_name;
        $content .= "\n\nShipEngine Shipment Label:";
        $content .= "\n";
        $content .= "PDF: <a href=\"https://34bf-39-36-43-27.ngrok-free.app/shipengine/webhook\">https://34bf-39-36-43-27.ngrok-free.app/shipengine/webhook</a>";
        $content .= "\n";
        $content .= "PNG: <a href=\"https://34bf-39-36-43-27.ngrok-free.app/shipengine/webhook\">https://34bf-39-36-43-27.ngrok-free.app/shipengine/webhook</a>";
        $content .= "\n";
        $content .= "ZPL: <a href=\"https://34bf-39-36-43-27.ngrok-free.app/shipengine/webhook\">https://34bf-39-36-43-27.ngrok-free.app/shipengine/webhook</a>";
        
        Storage::disk('local')->put($folderName . '/shipping.txt', $content);
        // Add shipping info file to files array to be zipped
        $files[] = Storage::disk('local')->path($folderName . '/shipping.txt');
        
        // Create zip file
        $zipFilePath = public_path('prints');
        $zip = Zip::create($folderName . ".zip", $files)->saveTo($zipFilePath);
        
        // File information
        $fileName = $folderName . '.zip';
        $filePath = $zipFilePath . '/' . $fileName;
        
        // Send email to admin about print booklet information with zip file
        $emails = settings('print-emails');
        $emails = !is_null($emails) ? json_decode($emails) : [];
        
        foreach ($emails as $email) {
            Notification::route('mail', $email)
            ->notify(new \App\Notifications\SendBookletForPrint($this->booklet->user->name, $filePath, $fileName));
        }
        
        // Delete folder from storage path
        Storage::disk('local')->deleteDirectory($folderName);
        
        // Delete zip file from public folder
        File::delete($filePath);
        
        // Update the status of booklet print to send
        $this->bookletPrint->update(['status' => BookletPrintStatus::SEND->value]);
        }

    public function generateImage($coupon){
        //GENERATE IMAGE
        $file = $coupon->template->file;
        $id = $coupon->template->id;
        $designerTemplate = $coupon->template;
        // $sponsor = auth()->user();
        
        $sponsor_data = Sponsor::where('user_id', $this->booklet->user_id)->first();
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
            else if($key == 'coupon_number' || $key == 'coupon_number_1'){
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
