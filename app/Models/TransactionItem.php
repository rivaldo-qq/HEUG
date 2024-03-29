<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id', 'products_id', 'transactions_id','qty'
    ]; 

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'products_id');
    }
    
    public function qty()
    {
        return $this->hasOne(Product::class, 'quantity', 'qty');
    }
    
}
