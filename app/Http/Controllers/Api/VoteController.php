<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Vote for a website.
     *
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function vote(Website $website)
    {
        $user = Auth::user();

        // Check if user has already voted for this website
        if ($user->hasVotedFor($website)) {
            return response()->json(['error' => 'User has already voted for this website.'], 400);
        }

        // Vote for the website
        $user->voteFor($website);

        return response()->json(['message' => 'Voted successfully.']);
    }

    /**
     * Unvote a website.
     *
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function unvote(Website $website)
    {
        $user = Auth::user();

        // Check if user has voted for this website
        if (!$user->hasVotedFor($website)) {
            return response()->json(['error' => 'User has not voted for this website.'], 400);
        }

        // Unvote the website
        $user->unvoteFor($website);

        return response()->json(['message' => 'Unvoted successfully.']);
    }
}
