<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactions extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function relation_savings() {
        return $this->belongsTo(Savings::class, 'savings_id');
    }
}
