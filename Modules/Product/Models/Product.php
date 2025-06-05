<?php

namespace Modules\Product\Models;

use Modules\Order\Models\Order;
use Illuminate\Support\Facades\Auth;
use Modules\Customer\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'preco',
        'foto',
        'customer_id',
        'product_category_id',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'customer_id' => 'integer',
            'product_category_id' => 'integer',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->customer_id = Auth::user()->getKey();
        });
    }

    /**
     * Get the formatted price attribute.
     */
    public function getPrecoAttribute($value): string
    {
        return number_format($value, 2, '.');
    }

    public function getFotoAttribute($value): string
    {
        return Storage::disk('public')->url($value);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')
            ->withPivot('quantity');
    }
}
