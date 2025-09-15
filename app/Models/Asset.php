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
        'category',
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

    protected static function boot()
{
    parent::boot();

    // Auto-generate sequential NRG serial number on create
    static::creating(function ($asset) {
        $max = Asset::max('nrg_serial_number');

        if ($max) {
            // Extract numeric part (after underscore)
            $lastNumber = (int) str_replace('NRG_', '', $max);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $asset->nrg_serial_number = 'NRG_' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    });

    static::deleted(function ($deletedAsset) {
        // Resequence in id order (stable order)
        $all = Asset::orderBy('id')->get();
        $i = 1;
        foreach ($all as $a) {
            $expected = 'NRG_' . str_pad($i, 3, '0', STR_PAD_LEFT);
            if ($a->nrg_serial_number !== $expected) {
                $a->nrg_serial_number = $expected;
                $a->saveQuietly();
            }
            $i++;
        }
    });
}


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
}
