<?php

namespace App\Events\Tweets;

use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use Illuminate\Broadcasting\Channel;
// use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TweetWasCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    protected $tweet;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Tweet $tweet)
    {
        $this->tweet = $tweet;
    }

    public function broadcastWith()
    {
        return (new TweetResource($this->tweet))->jsonSerialize();
    }

    public function broadcastAs()
    {
        return 'TweetWasCreated';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return $this->tweet->user->followers->map(function ($user) {
            return new PrivateChannel('timeline.'. $user->id);
         })
            ->toArray();
    }
}
