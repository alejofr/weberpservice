<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Facturas extends Model
{
    use HasFactory;
     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_factura';
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
        'id_factura',
        'id_proveedor',
        'id_ceco',
        'id_moneda',
        'id_factura_erp',
        'fecha_factura',
        'fecha_vencimiento',
        'monto_factura',
        'descripcion_factura',
        'eliminado',
        'status',
        'fecha_creado', 
        'fecha_editado',
        'fecha_eliminado' 
    ];

    protected $table = 'wse_facturas';

    const CREATED_AT = 'fecha_creado';
    const UPDATED_AT = 'fecha_editado';
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id_factura = (string) Uuid::generate(4);
        });
    }


    public function proveedores(){
        return $this->belongsTo('App\Models\Proveedores');
    }

    public function cecos(){
        return $this->belongsTo('App\Models\Cecos');
    }

    public function monedas(){
        return $this->belongsTo('App\Models\Monedas');
    }
}
