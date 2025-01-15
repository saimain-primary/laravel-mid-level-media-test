<?php

use App\Models\Comment;
use App\Models\Post;
use App\Services\MediaService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class MediaServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_uploads_media_and_associates_it_with_a_post()
    {
        Storage::fake('public');

        $mediaService = app(MediaService::class);

        $post = Post::factory()->create();

        $files = [
            UploadedFile::fake()->image('image1.jpg'),
            UploadedFile::fake()->image('image2.png'),
            UploadedFile::fake()->create('video1.mp4', 5000, 'video/mp4'),
        ];

        $mediaService->uploadMedia($files, $post);

        foreach ($files as $file) {
            Storage::disk('public')->assertExists("media/{$file->hashName()}");
        }

        $this->assertCount(3, $post->media);

        foreach ($files as $index => $file) {
            $media = $post->media[$index];
            expect($media->url)->toContain("media/{$file->hashName()}");
            expect($media->type)->toBeEnums(['image', 'video']);
        }
    }

    public function test_it_uploads_media_and_associates_it_with_a_comment()
    {
        Storage::fake('public');

        $mediaService = app(MediaService::class);

        $post = Post::factory()->create();

        $comment = Comment::factory()->create(['post_id' => $post->id]);

        $files = [
            UploadedFile::fake()->image('image1.jpg'),
            UploadedFile::fake()->image('image2.png'),
            UploadedFile::fake()->create('video1.mp4', 5000, 'video/mp4'),
        ];

        $mediaService->uploadMedia($files, $comment);

        foreach ($files as $file) {
            Storage::disk('public')->assertExists("media/{$file->hashName()}");
        }

        $this->assertCount(3, $comment->media);

        foreach ($files as $index => $file) {
            $media = $comment->media[$index];
            expect($media->url)->toContain("media/{$file->hashName()}");
            expect($media->type)->toBeEnums(['image', 'video']);
        }
    }
}
