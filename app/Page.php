<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(CategoriesPage::class,'id_category','id');
    }
}

