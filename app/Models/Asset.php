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
        'procurement_date'=> 'date',
        'returned_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto-generate sequential NRG serial number on create
        static::creating(function ($asset) {
            $max = Asset::max('nrg_serial_number');
            $asset->nrg_serial_number = $max ? ((int)$max + 1) : 1;
        });

        static::deleted(function ($deletedAsset) {
            // resequence in id order (stable order)
            $all = Asset::orderBy('id')->get();
            $i = 1;
            foreach ($all as $a) {
                // only update if different to avoid unnecessary queries
                if ((int)$a->nrg_serial_number !== $i) {
                    $a->nrg_serial_number = $i;
                    $a->saveQuietly();
                }
                $i++;
            }
        });
    }

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
        return $this->status === 'Assigned';
    }
}
