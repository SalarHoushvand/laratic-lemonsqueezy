<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
class FileUpload extends Component
{
    use WithFileUploads;

    /**
     * The temporary uploaded file (Livewire file upload).
     */
    #[Validate('nullable|file|max:10240')]
    public $uploadedFile = null;

    /**
     * The public S3 URL of the successfully uploaded file.
     */
    public string $fileUrl = '';

    /**
     * Handle file upload: store to S3 and update the file URL.
     */
    public function updatedUploadedFile(): void
    {
        $this->validateOnly('uploadedFile');

        if ($this->uploadedFile === null) {
            return;
        }

        try {
            $path = $this->uploadedFile->store('uploads', 's3');
            $this->fileUrl = Storage::disk('s3')->url($path);

            $this->dispatch(
                'notify',
                variant: 'success',
                title: __('Upload successful'),
                message: __('Your file has been uploaded to S3.')
            );
        } catch (\Throwable $exception) {
            report($exception);

            $this->addError('uploadedFile', __('The file could not be uploaded. Please try again.'));

            $this->dispatch(
                'notify',
                variant: 'error',
                title: __('Upload failed'),
                message: __('The file could not be uploaded. Please try again.')
            );
        } finally {
            $this->uploadedFile = null;
        }
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.admin.file-upload');
    }
}
