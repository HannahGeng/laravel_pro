<?php

namespace App;

class Post extends Model
{
    //关联用户
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy("created_at","desc");
    }

    //一对一，一个用户对一篇文章有一个赞
    public function zan($user_id)
    {
        return $this->hasOne(\App\Zan::class)->where('user_id',$user_id);
    }

    //文章的所有赞
    public function zans()
    {
        return $this->hasMany(\App\Zan::class);
    }
}
