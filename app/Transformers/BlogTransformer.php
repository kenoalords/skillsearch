<?php

namespace App\Transformers;

use App\Models\Blog;
use League\Fractal\TransformerAbstract;

class BlogTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    protected $defaultIncludes = ['comments', 'profile'];

    public function transform(Blog $blog)
    {
        return [
            'id'        => $blog->id,
            'title'     => ucwords($blog->title),
            'body'      => htmlspecialchars_decode($blog->body),
            'slug'      => $blog->slug,
            'status'    => $blog->status,
            'is_public' => $blog->is_public,
            'category'  => $blog->category,
            'excerpt'   => $blog->excerpt,
            'uid'       => $blog->uid,
            'user_id'   => $blog->user_id,
            'allow_comments'    => $blog->allow_comments,
            'views'     => $blog->views()->count(),
            'likes'     => [
                'count' => $blog->likes()->count(),
                'likers'=> $blog->likes()->get(),
            ],
            'comment_count'  => $blog->comments()->count(),
            'date'      => [
                'created_human' => $blog->created_at->diffForHumans(),
                'created_at'    => $blog->created_at,
                'updated_human' => $blog->updated_at->diffForHumans(),
                'updated_at'    => $blog->updated_at,
            ],
            'subscriber'=>[
                'count' => $blog->user->subscriber()->count(),
            ],
            // 'image'     => $blog->getImage(),
        ];
    }

    public function includeComments(Blog $blog)
    {
        $comments = $blog->comments()->get();
        return $this->collection($comments, new CommentTransformer);
    }

    public function includeProfile(Blog $blog)
    {
        $user = $blog->user()->first();
        return $this->item($user, new SimpleUserTransformers);
    }
}
