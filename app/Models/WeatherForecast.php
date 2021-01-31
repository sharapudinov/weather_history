<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $date)
 */
class WeatherForecast extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $connection = 'mysql';
}
