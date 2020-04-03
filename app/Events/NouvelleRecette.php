<?php

namespace App\Events;

use App\Recette;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NouvelleRecette
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recette;

    /**
     * Create a new event instance.
     *
     * @param Recette $recette
     */
    public function __construct(Recette $recette)
    {
        $this->recette = $recette;
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
