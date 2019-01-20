<?php

namespace App\Transformers;

use App\Models\Blog;
use League\Fractal\TransformerAbstract;

class EditBlogTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */

    public function transform(Blog $blog)
    {
        return [
            'id'        => $blog->id,
            'title'     => $blog->title,
            'body'      => $blog->body,
            'image'     => $blog->image,
            'status'    => $blog->status,
            'is_public' => $blog->is_public,
            'category'  => $blog->category,
            'excerpt'   => $blog->excerpt,
            'uid'       => $blog->uid,
            'user_id'   => $blog->user_id,
            'allow_comments'    => $blog->allow_comments,
        ];
    }
}
