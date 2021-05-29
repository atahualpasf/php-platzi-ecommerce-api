<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Rating extends MorphPivot
{
    public $incrementing = true;

    protected $table = 'ratings';

    public function rateable()
    {
        return $this->morphTo();
    }

    public function qualifiable()
    {
        return $this->morphTo();
    }
}
