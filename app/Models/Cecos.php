<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Cecos extends Model
{
    use HasFactory;
     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_ceco';
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
        'id_ceco',
        'id_empresa',
        'id_ceco_erp',
        'largo_ceco',
        'corto_ceco',
        'eliminado',
        'fecha_creado',
        'fecha_editado',
        'fecha_eliminado'
    ];

    protected $table = 'wse_cecos';

    const CREATED_AT = 'fecha_creado';
    const UPDATED_AT = 'fecha_editado';
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id_ceco = (string) Uuid::generate(4);
        });
    }

    public function monedas(){
        return $this->belongsTo('App\Models\Empresas');
    }

    public function facturas() 
    {
        return $this->hasMany('App\Models\Facturas', 'id_ceco', 'id_ceco');
    }
}
