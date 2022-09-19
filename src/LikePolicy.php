<?php

namespace Doloan09\Comments;

use Doloan09\Comments\Comment;

class LikePolicy
{
    /**
     * Can user create the comment
     *
     * @param $user
     * @return bool
     */
    public function create($user) : bool
    {
        return true;
    }

    /**
     * Can user delete the comment
     *
     * @param $user
     * @param Comment $comment
     * @return bool
     */
    public function delete($user, Likes $likes) : bool
    {
        return $user->getKey() == $likes->liker_id;
    }
}

