<?php

namespace Doloan09\Comments\Events;

use Illuminate\Queue\SerializesModels;
use Doloan09\Comments\Comment;

class CommentUpdated
{
    use SerializesModels;

    public $comment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
