<?php

namespace App\Http\Controllers\V1;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Services\MediaService;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\CommentResource;
use App\Contracts\MediaServiceInterface;
use App\Contracts\PostServiceInterface;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    use HttpResponses;

    protected $mediaService;

    public function __construct(MediaServiceInterface $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index(Request $request)
    {
        $posts = Post::all();
        return $this->success(PostResource::collection($posts), 'Post List');
    }

    public function show(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->error(null, 'Post Not Found', 404);
        }

        return $this->success(new PostResource($post), 'Post Detail');
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        $this->mediaService->uploadMedia($request->file('media'), $post);

        return $this->success(new PostResource($post), 'Post Created', 201);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->error(null, 'Post Not Found', 404);
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        if ($request->file('media')) {
            $this->mediaService->uploadMedia($request->file('media'), $post, true);
        }

        return $this->success(new PostResource($post), 'Post Updated');
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->error(null, 'Post Not Found', 404);
        }

        $post->delete();

        return $this->success(null, 'Post Deleted');
    }

    public function comments(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->error(null, 'Post Not Found', 404);
        }

        $comments = $post->comments;

        return $this->success(CommentResource::collection($comments), 'Comment List');
    }
}
