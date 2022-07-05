<?php

namespace Languafe\Reactions\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $fillable = [
        'reaction',
        'reactable_type',
        'reactable_id',
        'user_id',
    ];

    public function reactable()
    {
        return $this->morphTo();
    }

    // public function reactor()
    // {
    //     return $this->belongsTo(
    //         config('auth.providers.user.model')
    //     )
    // }
}
