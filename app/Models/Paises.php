<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Paises extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_pais';
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
        'id_pais', 
        'id_pais_erp',
        'nombre', 
        'nacionalidad_pais', 
        'eliminado',
        'fecha_creado', 
        'fecha_editado',
        'fecha_eliminado'  
    ];

    protected $table = 'wse_paises';

    const CREATED_AT = 'fecha_creado';
    const UPDATED_AT = 'fecha_editado';
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id_pais = (string) Uuid::generate(4);
        });
    }

    public function monedas() 
    {
        return $this->hasMany('App\Models\Monedas', 'id_pais', 'id_pais');
    }

    public function empresas() 
    {
        return $this->hasMany('App\Models\Empresas', 'id_pais', 'id_pais');
    }

}
