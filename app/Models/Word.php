<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Word extends Model

{

  protected $fillable = ['api_id', 'finnish', 'english', 'example'];
}
