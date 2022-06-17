<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class EmpresasGestionObras extends Model
{
    use HasFactory;
     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_empresa_gestion_obra';
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
        'id_empresa_gestion_obra',
        'id_empresa', 
        'id_empresa_gestion_obra_erp',
        'nombre', 
        'clave',
        'ceco',  
        'eliminado',
        'fecha_creado', 
        'fecha_editado',
        'fecha_eliminado', 
    ];

    protected $table = 'empresas_gestion_obras';

    const CREATED_AT = 'fecha_creado';
    const UPDATED_AT = 'fecha_editado';
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id_empresa_gestion_obra = (string) Uuid::generate(4);
        });
    }

    public function empresas(){
        return $this->belongsTo('App\Models\Empresas');
    }

}
