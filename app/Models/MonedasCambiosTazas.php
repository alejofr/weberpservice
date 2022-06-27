<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class MonedasCambiosTazas extends Model
{
    use HasFactory;
    use HasFactory;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_cambio_taza';
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_cambio_taza',
        'id_moneda_cambio', 
        'id_cambio_taza_erp',
        'monto_tc',
        'fecha_tc',
        'eliminado',
        'fecha_creado',
        'fecha_editado',
        'fecha_eliminado'
    ];

    protected $table = 'wse_monedas_cambios_tazas';

    const CREATED_AT = 'fecha_creado';
    const UPDATED_AT = 'fecha_editado';
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id_cambio_taza = (string) Uuid::generate(4);
        });
    }

    public function monedas(){
        return $this->belongsTo('App\Models\MonedasCambios');
    }
}
