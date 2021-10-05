<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsentForm extends Model
{
    // Store consent forms as JSON
    use \Okipa\LaravelModelJsonStorage\ModelJsonStorage;

    //TODO: change this to the new form
    public $fillable = [
        //'name',
        'email_for_map',
        //'public',
        'email_for_gift',
        'language'
    ];

}
