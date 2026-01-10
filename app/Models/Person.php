<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable
        = [
            'name',
            'age',
        ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => 'Mr.'.$value,
            set: fn($value) => ucwords($value),
        );
    }


    protected function age(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value >= 15 ? $value
                : throw new \InvalidArgumentException('under fifteen'),
        );
    }
}
