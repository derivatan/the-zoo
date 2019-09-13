<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    const GUESS = 1;
    const QUESTION = 2;

    public $timestamps = true;
}
