<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'exercises';
    protected $primaryKey = 'id';
    public $timestamps = true;


    protected $fillable = [
        'title', 'questions','correct_answers','marks','material_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function material()
    {
        return $this->belongsTo(Material::class);
    }




}
