<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityMark extends Model
{
    protected $table = 'activity_marks';
    protected $primaryKey = 'id';
    public $timestamps = true;


    protected $fillable = [
        'activity_marks', 'exercise_id','material_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
