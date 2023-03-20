<?php

namespace App\Actions;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Spatie\QueueableAction\QueueableAction;
use Storage;

class MediaUploadAction
{
    use QueueableAction;

    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute(UploadedFile $file, string $collection)
    {
        $name = $file->hashName();

        $path = "$collection/$name";

        Storage::put($path, $file);

        $media = Media::create([
            'name' => "{$name}",
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'path' => $path,
            'file_hash' => md5_file($file->getRealPath()),
            'collection' => $collection,
            'size' => $file->getSize(),
        ]);

        return $media;
    }
}
