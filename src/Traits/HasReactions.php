<?php

namespace Languafe\Reactions\Traits;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Languafe\Reactions\Models\Reaction;

trait HasReactions
{
    /**
     * @return MorphMany
     */
    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    public function react(string $reaction, ?Authenticatable $user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }

        $attributes = [
            'reaction' => $reaction,
            'reactable_type' => get_class($this),
            'reactable_id' => $this->getKey(),
            'user_id' => $user->getAuthIdentifier(),
        ];

        if (Reaction::where($attributes)->exists()) {
            // User has already added this reaction, so we remove it
            Reaction::where($attributes)->delete();
            return;
        }

        $reaction = Reaction::create($attributes);

        $this->reactions()->save($reaction);
    }

    public function getReactionsWithCountsAttribute()
    {
        return $this->reactions()
            ->select('reaction', DB::raw('count(*) as count'))
            ->groupBy('reaction')
            ->get();
    }

    public function getReactionsKeyedAttribute()
    {
        // https://laravel.com/docs/9.x/collections#method-keyby
        $keyed = collect($this->reactionsWithCounts)->keyBy('reaction');

        return $keyed->all();
    }

    public function hasReaction(string $reaction)
    {
        return $this->reactions()->where('reaction', $reaction)->exists();
    }

    public function hasReactionFrom(Authenticatable $user, ?string $reaction = null)
    {
        $query = $this->reactions()->where('user_id', $user->getAuthIdentifier());

        if ($reaction) {
            $query->where('reaction', $reaction);
        }

        return $query->exists();
    }
}
