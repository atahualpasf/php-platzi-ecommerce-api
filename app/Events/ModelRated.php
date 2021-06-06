<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModelRated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Model $qualifiable;
    private Model $rateable;
    private float $score;

    /**
     * @return Model
     */
    public function getQualifiable(): Model
    {
        return $this->qualifiable;
    }

    /**
     * @return Model
     */
    public function getRateable(): Model
    {
        return $this->rateable;
    }

    /**
     * @return float
     */
    public function getScore(): float
    {
        return $this->score;
    }

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Model $qualifiable, Model $rateable, float $score)
    {
        $this->qualifiable = $qualifiable;
        $this->rateable = $rateable;
        $this->score = $score;
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
