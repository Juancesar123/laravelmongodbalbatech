<?php
namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class Tag extends Model {

    protected $fillable = [];
    protected $table = "tags";
    public function post()
    {
        return $this->belongsToMany(Post::class,'post_tag','post_id','tag_id');
    }
}