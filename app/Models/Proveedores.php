<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Proveedores extends Model
{
    use HasFactory;
     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_proveedor';
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
        'id_proveedor',
        'id_cond_proveedor',
        'id_proveedor_erp',
        'nombre_proveedor',
        'nit_proveedor',
        'eliminado',
        'fecha_creado',
        'fecha_editado',
        'fecha_eliminado'
    ];

    protected $table = 'wse_op_proveedores';

    const CREATED_AT = 'fecha_creado';
    const UPDATED_AT = 'fecha_editado';
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id_proveedor = (string) Uuid::generate(4);
        });
    }

    public function condiciones_proveedores() 
    {
        return $this->belongsTo('App\Models\CondicionesProveedores');
    }

    public function facturas() 
    {
        return $this->hasMany('App\Models\Facturas', 'id_proveedor', 'id_proveedor');
    }

}
