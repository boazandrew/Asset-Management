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
        'category',
        'vendor_id',
        'handling_type', 
        'status',
        'returned_date',
        'procurement_date'
    ];

    protected $casts = [
        'procurement_date'=> 'date',
    ];

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function assignments()
    {
        return $this->hasMany(AssetAssignment::class);
    }

    public function currentAssignment(){
        return $this->hasOne(AssetAssignment::class)->latest();
    }

    public function isAssigned()
    {
        return $this->status==='Assigned';
    }
}
