<?php

namespace Tests\Unit\Actions;

use App\Actions\Media\UploadMediaAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadMediaActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_upload_media_file()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $action = new UploadMediaAction();

        $action->execute($file, 'avatars');

        Storage::disk()->assertExists('avatars/'.$file->hashName());

        $this->assertDatabaseCount('media', 1);
    }
}
