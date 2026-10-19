<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Fillable(['name', 'email', 'phone', 'birth_date'])]
class Costumers extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'birth_date' => 'date:Y-m-d',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}