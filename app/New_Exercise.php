<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class New_Exercise extends Model
{
    protected $table = 'new_exercises';
    protected $primaryKey = 'id';
    public $timestamps = true;


    protected $fillable = [
        'title', 'multiplier', 'multiplicand', 'product','mark','mcq', 'material_id','user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function material()
    {
        return $this->belongsTo(Material::class);
    }


    public function new_exercise()
    {
        return $this->belongsTo(Paper::class);
    }

    









}
