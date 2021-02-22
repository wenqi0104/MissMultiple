<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    protected $primaryKey = 'id';
    public $timestamps = true;


    protected $fillable = [
        'title', 'answers'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    
   
}
