<?php
namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class Tag extends Model {

    protected $fillable = [];
    public function item()
    {
        return $this->belongsToMany(Post::class,'item_pajak','post_id','tag_id');
    }
}