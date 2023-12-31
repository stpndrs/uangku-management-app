<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Savings extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function relation_transaction()
    {
        return $this->hasOne(Transactions::class, 'savings_id');
    }
}
