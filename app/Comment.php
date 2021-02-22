<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    public $timestamps = true;


    protected $fillable = [
        'body','user_id','parent_id','commentable_id','commentable_type'
    ];

    /**
     * 这个评论的所属用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
   /*  public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    } */

    

    //评论属于课件
   /*  public function material(){
        return $this->belongsTo(Material::class);
    } */
 
    /**
     * 这个评论的子评论
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    /* public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
 */


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
