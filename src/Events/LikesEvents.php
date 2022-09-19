<?php

namespace Doloan09\Comments\Events;

use Doloan09\Comments\Likes;
use Illuminate\Queue\SerializesModels;

class LikesEvents
{
    use SerializesModels;

    public $like;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Likes $like)
    {
        $this->like = $like;
    }
}
