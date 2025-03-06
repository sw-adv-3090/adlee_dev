<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Sponsor;
use App\Notifications\SendCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Decoders\FilePathImageDecoder;
use Intervention\Image\Geometry\Factories\LineFactory;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Support\Facades\Storage;


class SendCouponController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        abort_if($coupon->booklet_id, 403, "You cannot send this coupon by email");
        return view('sponsor.coupons.send', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function send(Request $request, Coupon $coupon)
    {
        abort_if($coupon->booklet_id, 403, "You cannot send this coupon by email");

        $request->validate([
            'email' => ['required', 'email', 'string', 'max:255']
        ]);

        $coupon->load(['sponsor', 'template']);

        // try {
            DB::transaction(function () use ($request, $coupon) {
                $coupon->update([
                    'redeemed_by' => $request->email
                ]);
         
                //GENERATE IMAGE
                $file = $coupon->template->file;
                $id = $coupon->template->id;
                $designerTemplate = $coupon->template;
                $sponsor = auth()->user();
                $sponsor_data = Sponsor::where('user_id', $sponsor->id)->first();
                $coupon_id = (int) $sponsor_data->last_coupon;
                //getting latest record of coupon
                $coupon = Coupon::where('user_id', $sponsor->id)->latest('id')->first();
              
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


                // //GENERATE IMAGE
                // $file = $coupon->template->file;
                // $jsonData = $coupon->template->meta_data;
                // $height = $coupon->template->height;
                // $width = $coupon->template->width;
                // $manager = new ImageManager(new Driver());

                // $image = $manager->read(public_path('images/'.$file), FilePathImageDecoder::class);
                // $image->resize($width, $height);
                // $data = json_decode($jsonData, true);

                // foreach ($data as $key => $value) {
                //     if (empty($value['x']) && empty($value['y'])) {
                //         continue;
                //     }
                //     if (isset($value['src'])) {

                //         $additionalImage = $key . '.png';


                //         $additionalImageWidth = $value['width'];
                //         $additionalImageHeight = $value['height'];

                //         $correctImageWidth = $additionalImageWidth / 2;
                //         $correctImageHeight = $additionalImageHeight / 2;

                //         $additionalImage = $manager->read(public_path('images/' . $additionalImage));

                //         $additionalImage->resize($additionalImageWidth, $additionalImageHeight);

                //         $image->place($additionalImage, 'absolute', $value['x'] - $correctImageWidth, $value['y'] - $correctImageHeight);

                //     } else {
                //         $fontSize = str_replace('px', '', $value['font']); // Remove the "px" from the font size
                //         $fontSize = (float) $fontSize; // Convert the font size to a float        
                //         $image->text($value['dummyText'], $value['x'], $value['y'] + $fontSize, function ($font) use ($value, $fontSize) {
                //             if ($value['bold'] && !$value['italic']) {
                //                 $font->file(public_path('fonts/arial-font/G_ari_bd.TTF'));
                //             } else if ($value['italic'] && !$value['bold']) {
                //                 $font->file(public_path('fonts/arial-font/G_ari_i.TTF'));

                //             } else if ($value['italic'] && $value['bold']) {
                //                 $font->file(public_path('fonts/arial-font/ARIALBI.TTF'));

                //             } else {
                //                 $font->file(public_path('fonts/arial-font/arial.ttf'));
                //             }
                //             $font->size($fontSize);

                //         });
                //         if ($value['underline']) {
                //             $image->drawLine(function (LineFactory $line) use ($value, $key, $fontSize) {
                //                 $line->from($value['x'], $value['y'] + 30);
                //                 $line->to($value['x'] + strlen($value['dummyText']) * ($fontSize / 2), $value['y'] + 30); // ending point (adjusted for text width)
                //                 $line->color('black'); // color of line (corrected spelling)
                //                 $line->width(2); // line width in pixels (adjusted)
                //             });
                //         }

                //     }
                // }
                // $imageBinary = $image->encodeByExtension('png');



                Notification::route('mail', $request->email)
                    ->notify(new SendCoupon($coupon,$imageBinary));
            });

            return to_route('sponsors.coupons.index')->with('success', 'Coupon successfully send.');
        // } catch (\Exception $ex) {
        //     die('$ex');
        //     return back()->with('error', $ex->getMessage());
        // }
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
