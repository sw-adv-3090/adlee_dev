<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    use HasFactory, Uuid;

    protected $fillable = ['uuid', 'booklet_print_id', 'label_id', 'shipment_id', 'tracking_number', 'status', 'amount', 'carrier_id', 'service_code', 'ship_date', 'tracking_url', 'download_pdf', 'download_png', 'download_zpl', 'tracking_status', 'carrier_code'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'ship_date' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }


    public function bookletPrint(): BelongsTo
    {
        return $this->belongsTo(BookletPrint::class);
    }
}
