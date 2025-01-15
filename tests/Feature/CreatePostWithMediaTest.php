<?php

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a post with associated media and stores data correctly', function () {
    Storage::fake('public');

    $files = [
        UploadedFile::fake()->image('image1.jpg'),
        UploadedFile::fake()->image('image2.png'),
        UploadedFile::fake()->create('video1.mp4', 5000, 'video/mp4'),
    ];

    $response = $this->postJson('/api/v1/posts', [
        'title' => 'Test Post Title',
        'content' => 'This is the body of the test post.',
        'media' => $files,
    ]);

    $response->assertStatus(201);

    $this->assertDatabaseHas('posts', [
        'title' => 'Test Post Title',
        'content' => 'This is the body of the test post.',
    ]);

    $post = Post::where('title', 'Test Post Title')->firstOrFail();

    $this->assertCount(3, $post->media);

    foreach ($files as $index => $file) {
        $media = $post->media[$index];
        expect($media->url)->toContain("media/{$file->hashName()}");
        expect($media->type)->toBeEnums(['image', 'video']);
    }
});
