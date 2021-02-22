<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';
    protected $primaryKey = 'id';
    public $timestamps = true;


    protected $fillable = [
        'title', 'exams_file',  'marks', 'material_id'
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
