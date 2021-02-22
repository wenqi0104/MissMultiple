<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $table = 'papers';
    protected $primaryKey = 'id';
    public $timestamps = true;


    protected $fillable = [
        'title','new_exercise_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    
    public function new_exercise()
    {
        return $this->hasMany(New_Exercise::class);
    }
    
    
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

}
