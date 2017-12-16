<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
    protected $table = 'posts';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
