<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Monedas extends Model
{
    use HasFactory;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_moneda';
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
        'id_moneda',
        'id_pais', 
        'id_moneda_erp',
        'nombre', 
        'abreviatura', 
        'eliminado',
        'fecha_creado', 
        'fecha_editado',
        'fecha_eliminado' 
    ];

    protected $table = 'wse_monedas';

    const CREATED_AT = 'fecha_creado';
    const UPDATED_AT = 'fecha_editado';
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id_moneda = (string) Uuid::generate(4);
        });
    }

    public function monedas_cambios() 
    {
        return $this->hasMany('App\Models\MonedasCambios', 'id_moneda_divisa', 'id_moneda');
    }

    public function facturas() 
    {
        return $this->hasMany('App\Models\Facturas', 'id_moneda', 'id_moneda');
    }

    public function paises(){
        return $this->belongsTo('App\Models\Paises');
    }

   
}
