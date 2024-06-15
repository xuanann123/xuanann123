<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'catalogue_id',
        'name',
        'slug',
        'sku',
        'thumbnail',
        'price_regular',
        'price_sale',
        'description',
        'content',
        'material',
        'user_manual',
        'views',
        'is_active',
        'is_hot_deal',
        'is_good_deal',
        'is_new',
        'is_show_home',
    ];
    protected $cats = [
        'is_active' => 'boolean',
        'is_hot_deal' => 'boolean',
        'is_good_deal' => 'boolean',
        'is_new' => 'boolean',
        'is_show_home' => 'boolean',
    ];
    //sản phẩm này nằm trong danh mục nào
    public function catalogue() {
        return $this->belongsTo(Catalogue::class);
    }
    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
