<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Decoders\FilePathImageDecoder;
use Intervention\Image\Geometry\Factories\LineFactory;
use setasign\Fpdi\Fpdi;
use App\Models\DesignerTemplate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use setasign\Fpdi\PdfParser\StreamReader;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ImagePreviewNotification;
use Illuminate\Support\Facades\Notification;



class FilePreviewController extends Controller
{

    /**
     * Edit the image and ready for preview
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function editImage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpg,png,gif',
            'data' => 'required',
            'height' => 'required',
            'width' => 'required',
            // 'additional_image_width' => 'required',
            // 'additional_image_height' => 'required',
            // 'additional_image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $file = $request->file('file');
        // $additional_image = $request->file('additional_image');
        $jsonData = $request->get('data');
        $height = $request->get('height');
        $width = $request->get('width');
        // $additional_image_width = $request->get('additional_image_width');
        // $additional_image_height = $request->get('additional_image_height');
        // $correct_image_width = $request->get('additional_image_width')/2;
        // $correct_image_height = $request->get('additional_image_height')/2;
        $manager = new ImageManager(new Driver());

        $image = $manager->read($file->getRealPath(), FilePathImageDecoder::class);
        $image->resize($width, $height);
        $data = json_decode($jsonData, true);

        foreach ($data as $key => $value) {
            if (empty($value['x']) && empty($value['y'])) {
                continue;
            }
            if (isset($value['src'])) {

                $additionalImage = $key . '.png';


                $additionalImageWidth = $value['width'];
                $additionalImageHeight = $value['height'];

                $correctImageWidth = $additionalImageWidth / 2;
                $correctImageHeight = $additionalImageHeight / 2;

                $additionalImage = $manager->read(public_path('images/' . $additionalImage));

                $additionalImage->resize($additionalImageWidth, $additionalImageHeight);

                $image->place($additionalImage, 'absolute', $value['x'] - $correctImageWidth, $value['y'] - $correctImageHeight);

            } else {
                $fontSize = str_replace('px', '', $value['font']); // Remove the "px" from the font size
                $fontSize = (float) $fontSize; // Convert the font size to a float        
                $image->text($value['dummyText'], $value['x'], $value['y'] + $fontSize, function ($font) use ($value, $fontSize) {
                    if (isset($value['fontFamily'])) {
                        $fontFile = $this->getFontFile($value['fontFamily'],$value['bold'], $value['italic']);  
                    } else {
                        $fontFile = $this->getFontFile('',$value['bold'], $value['italic']);
                    }           
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
                        $line->from($value['x'], $value['y'] + 30);
                        $line->to($value['x'] + strlen($value['dummyText']) * ($fontSize / 2), $value['y'] + 30); // ending point (adjusted for text width)
                        if (isset($value['color'])) {
                            $line->color($value['color']);
                        } else {
                            $line->color('#000000');
                        }// color of line (corrected spelling)
                        $line->width(2); // line width in pixels (adjusted)
                    });
                }

            }
        }

        // Save the edited image
        // $newImagePath = storage_path('images/processed/new_image.jpg');
        // $image->save($newImagePath);

        // $extension = strtolower($file->getClientOriginalExtension());
        $imageBinary = $image->encodeByExtension('png');

        // Get the binary data of the image
        // $imageBinary = $encoded->encode();

        // Send the edited image as a response
        return response()->streamDownload(function () use ($imageBinary) {
            echo $imageBinary;
        }, 'edited_image.png', [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline',
        ]);

        // return response()->json(['message' => 'Image edited successfully']);
    }

    public function saveFileData(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpg,png,gif',
            'data' => 'required',
            'height' => 'required',
            'width' => 'required',
            'type' => 'required',
            'preview' => 'required',
            'language' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        // Get request data
        $file = $request->file('file');
        $preview = $request->file('preview');
        $metaData = $request->get('data');
        $height = $request->get('height');
        $width = $request->get('width');
        $type = $request->get('type');
        $user_id = $request->get('user_id');
        $language = $request->get('language');

        // Generate a unique filename
        // $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        // $previewFilename = uniqid() . '.' . $preview->getClientOriginalExtension();
        $filename = uniqid() . '.png';
        $previewFilename = uniqid() . '.png';

        // Save the file and preview to the public directory
        $public_path = public_path('images');
        $newImagePath = $public_path . '/uploads/' . $filename;
        $newPreviewPath = $public_path . '/processed/' . $previewFilename;

        // Try to save the files, if fails, return an error
        try {
            $file->move($public_path . '/uploads', $filename);
            $preview->move($public_path . '/processed', $previewFilename);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save files'], 500);
        }


        // Create a new template
        $template = DesignerTemplate::create([
            'type' => $type,
            'file' => 'images/uploads/' . $filename,
            'preview' => 'images/processed/' . $previewFilename,
            'language' => $language,
            'height' => $height,
            'width' => $width,
            'meta_data' => $metaData,
            'created_by' => $user_id,
        ]);

        // Send an email with the saved image
        /* Mail::send('emails.image_preview', ['file' => $newImagePath], function ($message) use ($newPreviewPath) {
             $message->to('mirfanshah9@gmail.com')
                 ->subject('File Edited Successfully')
                 ->attachFromPath($newPreviewPath);
         });*/

        Notification::route('mail', 'mirfanshah9@gmail.com')
            ->notify(new ImagePreviewNotification($newImagePath, $newPreviewPath, $type));


        return response()->json(['message' => 'Image data saved successfully', 'data' => $template]);
    }

    /**
     * Edit PDF file and ready for preview
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function editPdf(Request $request)
    {
        $file = $request->file('pdf');
        $filePath = $file->getPathname();
        $outputFilePath = storage_path('images/processed/new_pdf.pdf');

        $jsonData = '{
        "sponser_name": {
        "x": 207.1,
        "y": 240.5,
        "font": 200,
        "font_family": "arial"
        },
        "person_name": {
        "x": 124.3,
        "y": 375.5,
        "font": 200,
        "font_family": "arial"
        },
        "person_title": {
        "x": 143.8,
        "y": 437.5,
        "font": 300,
        "font_family": "arial"
        }
        }';

        // Decode the JSON data
        $data = json_decode($jsonData, true);

        $pdf = new Fpdi();

        // Load the existing PDF
        $pageCount = $pdf->setSourceFile($filePath);

        for ($i = 1; $i <= $pageCount; $i++) {
            $templateId = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            // Loop through the JSON data and add text to the PDF
            foreach ($data as $key => $value) {
                $pdf->SetFont($value['font_family'], '', $value['font']); // Set the font
                $pdf->SetXY($value['x'], $value['y']); // Set the x and y coordinates
                $pdf->Cell(0, 0, $key, 0, 0, 'L'); // Add the text
            }
        }


        // Output the PDF
        $pdf->Output($outputFilePath, 'F');

        return response()->json(['message' => 'PDF edited successfully', 'file' => $outputFilePath]);
    }
    private function getFontFile(string $fontFamily, bool $bold, bool $italic): string
    {
        // Define a font mapping for supported font families;
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
