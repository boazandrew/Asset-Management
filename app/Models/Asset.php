<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'specification',
        'nrg_serial_number',
        'product_serial_number',
        'category_id',
        'vendor_id',
        'handling_type',
        'status',
        'returned_date',
        'procurement_date'
    ];

    protected $casts = [
        'procurement_date' => 'date',
        'returned_date' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function assignments()
    {
        return $this->hasMany(AssetAssignment::class);
    }

    public function currentAssignment()
    {
        return $this->hasOne(AssetAssignment::class)->latest();
    }

    public function isAssigned()
    {
        return $this->status === 'Assigned';
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
