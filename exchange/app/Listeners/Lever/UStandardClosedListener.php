<?php

namespace App\Listeners\Lever;

use App\Events\Lever\UStandardClosedEvent;
use App\Models\Lever\LeverUStandard;

class UStandardClosedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UStandardClosedEvent $event)
    {
        $lever_trades = $event->leverTrades;
        LeverUStandard::pushDeletedTrade($lever_trades);
    }
}
