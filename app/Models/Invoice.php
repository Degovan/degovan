<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'project', 'status', 'amount', 'description',
    ];

    public static function boot()
    {
        parent::boot();

        // Generate random invoice code
        static::creating(function ($model) {
            do {
                $code = Str::random(6);
            } while ($model->where('code', $code)->first());

            $model->code = $code;
        });
    }
}
