<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category','slug','parent_id'];

    public function children(){
        return $this->hasMany(Category::class,'parent_id')->with('children');
    }

    public function parent(){
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function getParentCategoryAttribute(){
        return $this->parent()->first() ?? '';
    }

}
