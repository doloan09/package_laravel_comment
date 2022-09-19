<?php

namespace Doloan09\Comments;

use Doloan09\Comments\Events\LikesEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Likes extends Model
{
    use SoftDeletes;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'liker'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'liker_id', 'liker_type', 'liketable_id'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => LikesEvents::class,
        'deleted' => LikesEvents::class,
    ];

    /**
     * The user who posted the comment.
     */
    public function liker()
    {
        return $this->morphTo();
    }

    /**
     * The model that was commented upon.
     */
    public function liketable()
    {
        return $this->morphTo();
    }

    public function children()
    {
        return $this->hasMany(Config::get('likes.model'), 'liketable_id');
    }

    /**
     * Returns the comment to which this comment belongs to.
     */
    public function parent()
    {
        return $this->belongsTo(Config::get('likes.model'), 'liketable_id');
    }
}
