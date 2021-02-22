<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Material extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id';
    public $timestamps = true;


    protected $fillable = [
        'title', 'description', 'uploads','images'
    ];


    /**
     * 这个课件的所属用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /* public function user(){
        return $this->belongsTo('App\User');
    } */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * 一个课件有多个评论
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }


    public function paper()
    {
        return $this->hasMany(Paper::class);
    }

     /**
     * 获取这篇文章的评论以parent_id来分组
     * @return static
     */
     /* public function getComments()
    {
        return $this->comments()->with('owner')->get()->groupBy('parent_id');
    } */

}
