<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModelUnrated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Model $qualifiable;
    private Model $rateable;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Model $qualifiable, Model $rateable)
    {
        //
        $this->qualifiable = $qualifiable;
        $this->rateable = $rateable;
    }

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
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
