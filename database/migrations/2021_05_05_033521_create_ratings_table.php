<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->float('score');

            $table->morphs('rateable');
            // $table->unsignedBigInteger('rateable_id');
            // $table->string('rateable_type');
            $table->morphs('qualifiable');
            // $table->unsignedBigInteger('qualifiable_id');
            // $table->string('qualifiable_type');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
