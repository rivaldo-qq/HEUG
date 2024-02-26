<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'slug','stock'];

    public function galleries()
    {
        return $this->hasMany(TableGallery::class, 'tables_id', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
