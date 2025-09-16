<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'asset_id',
        'assigned_date',
        'assigned_by',
        'acknowledged',
        'acknowledged_at',
        'returned',
        'returned_at'
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'acknowledged' => 'boolean',
        'acknowledged_at' => 'datetime',
        'returned' => 'boolean',
        'returned_at' => 'datetime',
    ];


    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
