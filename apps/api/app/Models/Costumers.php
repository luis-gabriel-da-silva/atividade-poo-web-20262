<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Fillable(['name', 'email', 'phone'])]
class Costumers extends Model
{
    /** @use HasFactory<\Database\Factories\CostumersFactory> */
    use HasFactory;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
