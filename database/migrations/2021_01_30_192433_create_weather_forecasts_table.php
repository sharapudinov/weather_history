<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWeatherForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'weather_forecasts',
            function (Blueprint $table) {
                $table->id()->autoIncrement();
                $table->float('temp');
                $table->date('date_at')->unique();
            }
        );
        for ($i = 180; $i >= 0; $i--) {
            $date = date("Y-m-d", strtotime("-$i days"));
            $temp = rand(-50,+50);
            DB::statement(
                "INSERT INTO weather_forecasts (temp,date_at) VALUES ('$temp','$date' ) "
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_forecasts');
    }
}
