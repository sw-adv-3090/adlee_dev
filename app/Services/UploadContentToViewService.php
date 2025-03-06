<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * Class UploadContentToViewService.
 */
class UploadContentToViewService
{
    private $view;

    function __construct(string $view)
    {
        $this->view = $view;
    }

    /**
     * Upload content to view.
     *
     * @return boolean
     */
    public function upload($filePath, $template)
    {
        // separate content and styling from uploaded file
        $fileContent = file_get_contents(Storage::path($filePath));
        $styling = Str::between($fileContent, "<style>", "</style>");
        $styling = "<style>";
        $styling .= Str::between($fileContent, "<style>", "</style>");
        $styling .= "</style>";
        $content = Str::between($fileContent, "<main>", "</main>");

        // create new view blade file inside resorces>view directory
        $viewContent = "@extends('layouts.template')";
        $viewContent .= "\r\n";
        $viewContent .= "\r\n";
        $viewContent .= "@push('styles')";
        $viewContent .= "\r\n";
        $viewContent .= $styling;
        $viewContent .= "\r\n";
        $viewContent .= "@endpush";
        $viewContent .= "\r\n";
        $viewContent .= "\r\n";
        $viewContent .= "@section('content')";
        $viewContent .= "\r\n";
        $viewContent .= $content;
        $viewContent .= "\r\n";
        $viewContent .= "@endsection";

        Storage::disk('disk_path')->put('/resources/views/' . $this->view . '.blade.php', $viewContent);

        // updating content and stying to template database
        $template->update(['styling' => $styling, 'content' => $content]);

        return true;
    }
}
