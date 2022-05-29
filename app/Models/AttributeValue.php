<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $table = 'attribute_values';

    protected $fillable = [
        'attribute_id', 'value', 'price'
    ];

    protected $casts = [
        'attribute_id'  =>  'integer',
    ];

    public function attributes(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

//    public function productAttributes()
//    {
//        return $this->belongsToMany(ProductAttribute::class);
//    }

}
