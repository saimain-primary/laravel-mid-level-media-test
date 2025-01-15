<?php

namespace App\Http\Controllers\V1;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Contracts\MediaServiceInterface;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    use HttpResponses;

    protected $mediaService;

    public function __construct(MediaServiceInterface $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function show(Request $request, $id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return $this->error(null, 'Comment Not Found', 404);
        }

        return $this->success(new CommentResource($comment), 'Comment Detail');
    }

    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create([
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);

        $this->mediaService->uploadMedia($request->file('media'), $comment);

        return $this->success(new CommentResource($comment), 'Comment Created');
    }

    public function update(UpdateCommentRequest $request, $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return $this->error(null, 'Comment Not Found', 404);
        }

        $comment->update([
            'content' => $request->content,
        ]);

        if ($request->file('media')) {
            $this->mediaService->uploadMedia($request->file('media'), $comment, true);
        }

        return $this->success(new CommentResource($comment), 'Comment Updated');
    }

    public function destroy(Request $request, $id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return $this->error(null, 'Comment Not Found', 404);
        }

        $comment->delete();

        return $this->success(null, 'Comment Deleted');
    }
}
