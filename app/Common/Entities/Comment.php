<?php

namespace App\Common\Entities;

use Joovlly\Reviewable\Traits\HasReviews;
use Joovlly\Commentable\Models\Comment as BaseComment;

class Comment extends BaseComment
{
    use HasReviews;
}
