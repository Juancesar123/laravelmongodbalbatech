<?php
namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class Post extends Model {

    protected $fillable = [];
    public function tag(){
        return $this->belongsToMany(Tag::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}