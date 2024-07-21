<?php

namespace App\Jobs;

use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadImgLogoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $identifier;
    protected $isUserId;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath, $identifier, $isUserId = true)
    {
        Log::info(['Job Checking construct']);
        $this->filePath = $filePath;
        $this->identifier = $identifier;
        $this->isUserId = $isUserId;
    }

    public $tries = 3;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(['Job Checking handle' => $this->filePath]);

        // Check if the file exists before attempting to upload
        if (!Storage::exists($this->filePath)) {
            Log::error('File does not exist', ['filePath' => $this->filePath]);
            return;
        }

        // Upload the file to Cloudinary
        try {
            $fileRealPath = Storage::path($this->filePath);
            $uploadedFileUrl = Cloudinary::upload($fileRealPath)->getSecurePath();
            Log::info(['Job cloudinary url' => $uploadedFileUrl]);

            // Update the listing with the logo URL
            $listing = $this->isUserId
                ? Listing::where('user_id', $this->identifier)->latest()->first()
                : Listing::find($this->identifier);

            if ($listing) {
                $listing->logo = $uploadedFileUrl;
                $listing->save();
            }

            // Delete the temporary file
            Storage::delete($this->filePath);
        } catch (\Exception $e) {
            Log::error('Error uploading file to Cloudinary', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
