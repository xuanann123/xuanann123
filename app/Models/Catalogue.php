<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catalogue extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'thumbnail',
        'is_active',
        'parent_id'
    ];
    protected $cats = [
        "is_active" => 'boolean',
    ];
    //Tự động chuyển về 0-1 vào database và tự động convert từ 0-1 thành false hoặc true
    function children() {
        return $this->hasMany(Catalogue::class, "parent_id");
    }
    //Đệ quy đến thằng con bé nhất
    function childrenRecursive() {
        return $this->children()->with('childrenRecursive');
    }
    //Một danh mục sản phẩm chứa nhiều sản phẩm
    public function products(){
        return $this->hasMany(Product::class);
    }
}
