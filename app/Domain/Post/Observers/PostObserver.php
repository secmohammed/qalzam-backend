<?php

namespace App\Domain\Post\Observers;

use Illuminate\Support\Str;
use App\Domain\Post\Entities\Post;

class PostObserver
{
    /**
     * @param Post $post
     */
    public function creating(Post $post)
    {
        $post->slug = sprintf('%s-%s', Str::slug($post->title), Str::slug(uniqid('', true)));
    }
}
