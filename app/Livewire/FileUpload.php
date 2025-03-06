<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class FileUpload extends Component
{
    use WithFileUploads, \App\Traits\FileUpload;

    public $file;
    public $fileUrl = '';

    public function updatedFile()
    {
        $this->fileUrl = '';

        $this->validate([
            'file' => ['required', 'image', 'mimes:png,jpg,jpeg'],
        ]);
        $filePath = $this->fileUpload($this->file, 'uploads');
        $this->fileUrl = asset($filePath);

    }
    public function render()
    {
        return view('livewire.file-upload');
    }
}
