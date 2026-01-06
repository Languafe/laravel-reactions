<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Languafe\Reactions\Models\Reaction;

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::post('/reactions', function (Request $request) {
        $reactionAttributes = $request->only([
            'reaction',
            'reactable_id',
            'reactable_type',
        ]);

        if (!class_exists($reactionAttributes['reactable_type'])) {
            abort(400);
        }

        $reactionAttributes['user_id'] = Auth::id();

        $reaction = Reaction::where([
            'reaction' => $reactionAttributes['reaction'],
            'reactable_type' => $reactionAttributes['reactable_type'],
            'reactable_id' => $reactionAttributes['reactable_id'],
            'user_id' => $reactionAttributes['user_id'],
        ]);

        // Check if current user has already added this reaction
        if ($reaction->exists()) {
            $reaction->delete();
        }
        else {
            Reaction::create($reactionAttributes);
        }

        return redirect()->back();
    })->name('reactions.store');
});

