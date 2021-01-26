<?php

namespace App\Domain\Post\Events\Http;

use App\Domain\Post\Entities\Post;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class PostCreated
{
    use SerializesModels, Dispatchable;

    /**
     * @var mixed
     */
    public $post;

    /**
     * @param $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
