<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InvalidArgumentException;

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
            get: fn ($value, array $attributes) => 'Mr.'.$value,
            set: function ($value) {
                if (mb_strlen($value) < 2 || mb_strlen($value) > 30) {
                    throw new InvalidArgumentException('name length invalid');
                }

                return ucwords($value);
            },
        );
    }

    protected function age(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value >= 15 ? $value
                : throw new InvalidArgumentException('under fifteen'),
        );
    }
}
