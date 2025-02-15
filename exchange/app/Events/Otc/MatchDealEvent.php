<?php

namespace App\Events\Otc;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Otc\OtcDetail;

class MatchDealEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $otcDetail;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(OtcDetail $otc_detail)
    {
        $this->otcDetail = $otc_detail;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
