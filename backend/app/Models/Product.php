<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'cost_price',
        'stock_quantity',
        'stock_in',
        'sku',
        'type',
        'status',
        'featured',
        'barcode',
        'manage_stock',
        'external_url',
        'meta_title',
        'meta_description',
        'main_image',
        'category_id',
        'brand_id',
        'min_order_qty',
        'max_order_qty',
        'sale_start_date',
        'sale_end_date',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function downloads()
    {
        return $this->hasMany(ProductDownload::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug) && !empty($model->name)) {
                $model->slug = Str::slug($model->name);
            }
        });
        static::updating(function ($model) {
            if (empty($model->slug) && !empty($model->name)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}
