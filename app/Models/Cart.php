<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'cart';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function seller()
    {
        return $this->belongsTo(User::class, "seller_id");
    }

    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class);
    }
}
