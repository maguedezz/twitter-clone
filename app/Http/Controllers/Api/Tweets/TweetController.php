<?php

namespace App\Http\Controllers\Api\Tweets;

use App\Events\Tweets\TweetWasCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tweets\TweetStoreFormRequest;
// use Illuminate\Http\Request;

class TweetController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware(['auth:sanctum'])->only(['store']);
    // }


    public function store(TweetStoreFormRequest $request)
    {
        // validation

        $tweet = $request->user()->tweets()->create($request->only('body'));

        broadcast(new TweetWasCreated($tweet));
    }
}
