<?php
namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class Category extends Model {

    protected $fillable = [];
    public function Post(){
        return $this->hasOne(Post::class,'post_id','category_id');
    }
}