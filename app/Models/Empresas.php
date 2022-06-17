<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Empresas extends Model
{
    use HasFactory;
      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_empresa';
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
        'id_empresa',
        'id_pais', 
        'id_empresa_erp',
        'nombre_empresa', 
        'nombre_corto',
        'eliminado',
        'fecha_creado', 
        'fecha_editado',
        'fecha_eliminado', 
    ];

    protected $table = 'wse_empresas';

    const CREATED_AT = 'fecha_creado';
    const UPDATED_AT = 'fecha_editado';
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id_empresa = (string) Uuid::generate(4);
        });
    }

    public function paises(){
        return $this->belongsTo('App\Models\Paises');
    }

    public function cecos() 
    {
        return $this->hasMany('App\Models\Cecos', 'id_empresa', 'id_empresa');
    }


}
