<?php

namespace App\Observers;

use App\Models\Empresas;
use App\Models\EmpresasGestionObras;
use Carbon\Carbon;
class EmpresasObserver
{

    public function updated(Empresas $empresas)
    {
        if($empresas->eliminado == 1){
            EmpresasGestionObras::where('id_empresa', $empresas->id_empresa)
            ->update([
                'eliminado' => true,
                'fecha_eliminado' => Carbon::now()
            ]);
        }

        
    }

    /**
     * Handle the Empresas "deleted" event.
     *
     * @param  \App\Models\Empresas  $empresas
     * @return void
     */
    public function deleted(Empresas $empresas)
    {
        //
    }

}
