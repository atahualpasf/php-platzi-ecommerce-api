<?php

namespace App\Utils;

use App\Events\ModelRated;
use Illuminate\Database\Eloquent\Model;


trait CanRate
{
    public function ratings($model = null)
    {
        $modelClass = $model ? (new $model)->getMorphClass() : $this->getMorphClass();

        $morphToMany = $this->morphToMany(
            $modelClass, // clase con quien quiero relacionarme
            'qualifiable', // nombre de mi relación
            'ratings', // nombre de la tabla
            'qualifiable_id', // columna con la cual hago la relación
            'rateable_id' // columna con quien quiero relacionarme
        );

        $morphToMany
            ->as('rating')
            ->withTimestamps()
            ->withPivot('score', 'rateable_type')
            ->wherePivot('rateable_type', $modelClass)
            ->wherePivot('qualifiable_type', $this->getMorphClass());

        return $morphToMany;
    }

    public function rate(Model $model, float $score): bool
    {
        if ($this->hasRated($model)) {
            return false;
        }

        $this->ratings($model)->attach($model->getKey(), [
            'score' => $score,
            'rateable_type' => get_class($model)
        ]);

        event(new ModelRated($this, $model, $score));

        return true;
    }

    public function unrate(Mode $model): bool
    {
        if (!$this->hasRated($model)) {
            return false;
        }

        $this->ratings($model->getMorphClass())->detach($model->getKey());

        return true;
    }

    public function hasRated(Model $model): bool
    {
        return !is_null($this->ratings($model->getMorphClass())->find($model->getKey()));
    }
}
