<template>
      <form  @submit.prevent="submit($event)" name="factura" class="card">
         <div v-show="loader" class="div-loader_white"><loader></loader></div>
            <div class="card-header">
                <h4 class="card-title">Crear Nueva Factura</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12" v-if="activeComponent"><component :is='activeComponent' v-bind:alert="alert"></component></div>
                    <div class="col-xl-6 col-md-6">
                        <div class="mb-3">
                            <label class="form-label"> Agregar el NIT del Proveedor</label>
                            <div class="form-floating">
                                <input type="text"   class="form-control dropdown-toggle" data-bs-toggle="dropdown" v-model="factura.proveedor" value="" id="proveedor" name="C" @keyup="inputSearch($event)" aria-expanded="false" v-validate="'required'" data-vv-validate-on="change" :class="{'is-invalid': errors.first('proveedor')}">
                                <label for="proveedor">Buscar Proveedor por Nombre ó Nit</label>
                                <ul class="dropdown-menu input-result-search" id="proveedor">
                                    <li v-for="(proveedor, index) in proveedores" :key="index" >
                                        <label class="form-check" :for="index">
                                            <input type="radio"  class="form-check-input" :value="proveedor.id_proveedor"  :id="index" @click="clickRadioCheck($event)">
                                            <span class="form-check-label">{{proveedor.nombre_proveedor}} -  {{proveedor.nit_proveedor}}</span>  
                                        </label>
                                    </li>
                                </ul>
                                <div v-if="errors.has('proveedor')" class="invalid-feedback">{{errors.first('proveedor')}}</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"> Agregar CECO</label>
                            <div class="form-floating">
                                <input type="text"  class="form-control dropdown-toggle" data-bs-toggle="dropdown" v-model="factura.ceco" value="" id="ceco" name="ceco" @keyup="inputSearch($event)" aria-expanded="false" v-validate="'required'" data-vv-validate-on="change" :class="{'is-invalid': errors.first('ceco')}">
                                <label for="ceco">Buscar CECO por nombre largo ó corto</label>
                                <ul class="dropdown-menu input-result-search" id="ceco">
                                    <li v-for="(ceco, index) in cecos" :key="index" >
                                        <label class="form-check" :for="index">
                                            <input type="radio"  class="form-check-input" :value="ceco.id_ceco"   :id="index" @click="clickRadioCheck($event)">
                                            <span class="form-check-label">{{ceco.largo_ceco}} -  {{ceco.corto_ceco}}</span>  
                                        </label>
                                    </li>
                                </ul>
                                <div v-if="errors.has('ceco')" class="invalid-feedback">{{errors.first('ceco')}}</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"> Agregar Moneda</label>
                            <div class="form-floating">
                              <select class="form-select" v-model="factura.id_moneda" id="moneda" name="id_moneda" v-validate="'required'" data-vv-validate-on="change" :class="{'is-invalid': errors.first('id_moneda')}">
                                <option v-for="(moneda, index) in monedas" :key="index" :value="moneda.id_moneda">{{moneda.nombre}}</option>
                              </select>
                              <label for="monedat">Selecciona una moneda</label>
                            </div>
                            <div v-if="errors.has('id_moneda')" class="invalid-feedback">{{errors.first('id_moneda')}}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"> Agregar ID factura</label>
                            <div class="form-floating">
                              <input type="text"  class="form-control" v-model="factura.id_factura_erp" value="" id="id_factura_erp" name="id_factura_erp" v-validate="'required'" data-vv-validate-on="change" :class="{'is-invalid': errors.first('id_factura_erp')}">
                                <label for="id_factura_erp">Ingresa el ID de la fatura</label>
                            </div>
                            <div v-if="errors.has('id_factura_erp')" class="invalid-feedback">{{errors.first('id_factura_erp')}}</div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Fecha Factura</label>
                            <div class="form-floating">
                              <input type="date"  class="form-control" v-model="factura.fecha_factura" value="" id="fecha_factura" name="fecha_factura"  data-vv-validate-on="change" v-validate="'required'" :class="{'is-invalid': errors.first('fecha_factura')}">
                                <label for="fecha_factura">Selección Fecha Factura</label>
                            </div>
                            <div v-if="errors.has('fecha_factura')" class="invalid-feedback">{{errors.first('fecha_factura')}}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha Vencimiento</label>
                            <div class="form-floating">
                              <input type="date"  class="form-control" v-model="factura.fecha_vencimiento" value="" id="fecha_vencimiento" name="fecha_vencimiento" data-vv-validate-on="change"  v-validate="'required'" :class="{'is-invalid': errors.first('fecha_vencimiento')}">
                                <label for="fecha_vencimiento">Selección Fecha Vencimiento</label>
                            </div>
                            <div v-if="errors.has('fecha_vencimiento')" class="invalid-feedback">{{errors.first('fecha_vencimiento')}}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Monto Factura</label>
                            <div class="form-floating">
                              <input type="text"  class="form-control" v-model="factura.monto_factura" value="" id="monto_factura" name="monto_factura" data-vv-validate-on="change"  v-validate="'required'" :class="{'is-invalid': errors.first('monto_factura')}">
                                <label for="monto_factura">Ingresa un monto</label>
                            </div>
                            <div v-if="errors.has('monto_factura')" class="invalid-feedback">{{errors.first('monto_factura')}}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción Factura</label>
                            <textarea class="form-control" v-model="factura.descripcion_factura" name="descripcion_factura" rows="3" data-vv-validate-on="change"  v-validate="'required'" :class="{'is-invalid': errors.first('descripcion_factura')}"></textarea>
                            <div v-if="errors.has('descripcion_factura')" class="invalid-feedback">{{errors.first('descripcion_factura')}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="d-flex">
                    <btn-volver :classe="'btn-light'"></btn-volver>
                    <button type="submit" class="btn btn-primary ms-auto">
                        <i class="ti ti-plus me-1"></i>
                        Guardar
                    </button>
                </div>
            </div>
        </form>
</template>
<script>
import BtnVolver from '../../../components/BtnVolverComponent.vue';

const LoaderComponent = (() => import('../../../components/LoaderComponent.vue') );
const AlertMessageComponent = (() => import('../../../components/AlertMessageComponent.vue') );
export default {
    name: 'FacturasForm',

    data() {
        return {
            loader: false,
            activeComponent: '',
             alert: {
                msg: '',
                clss: '' 
            },
            factura: {
                proveedor: '',
                ceco: '',
                id_moneda: '',
                id_factura_erp: '',
                fecha_factura: '',
                fecha_vencimiento: '',
                monto_factura: '',
                descripcion_factura: ''
            },
            search:{
                proveedor: ''
            },
            proveedores: [],
            cecos: [],
            monedas: []
        };
    },
     components: {
        loader: LoaderComponent,
        BtnVolver,
    },
    beforeCreate(){
        this.$nextTick(function () {
            this.axios.get('monedas/all').then(response => {
                this.monedas = response.data.results;
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data);
            });
        })  
    },
    methods: {
        clickRadioCheck(e){
            const parent = e.target.parentNode.parentNode.parentNode;
            const id = parent.getAttribute("id");
            const value = e.target.value;
            let arreglo = [];

           

            if( id == 'proveedor' )
                arreglo = this.proveedores;
            else if( id == 'ceco' )
                arreglo = this.cecos;
            

            if(  arreglo.length != 0 ){
                for (let i = 0; i < arreglo.length; i++) {
                    if( id == 'proveedor' && value == arreglo[i].id_proveedor ){
                        this.factura.proveedor = arreglo[i].nit_proveedor;
                        break;
                    }else if( id == 'ceco' &&  value  == arreglo[i].id_ceco ){
                        this.factura.ceco = arreglo[i].corto_ceco;
                        break;
                    }
                }
            }
           
            

            parent.classList.remove('show-search');
            if( id == 'proveedor' )
                this.proveedores = [];
            else if( id == 'ceco' )
                this.cecos = [];

        },
        async inputSearch(e){
            console.log(e)
            const id = e.target.id;
            const parent = e.target.offsetParent;
            let search = '';
            let url = '';
            if( id == 'proveedor' ){
                search = this.factura.proveedor;
                url = 'proveedores/all';
            }else if(id == 'ceco'){
                search = this.factura.ceco;
                url = 'cecos/all'
            }

            await this.axios.get(url, {params : { query: search }}).then(response => {
                console.log(response.data)
                if( id == 'proveedor' ){
                    this.proveedores = response.data.results;
                }else if( id == 'ceco' ){
                    this.cecos = response.data.results;
                }

                parent.querySelector('.dropdown-menu').classList.add('show-search');
            }).catch(error => {
               console.log(error.response.data);
            });
        },
        async submit(e){   
            e.preventDefault();
            console.log(this.factura);

            this.$validator.validate().then(valid => {
                if( valid ){
                    this.loader = true;
                    this.loader = true;

                    const request = this.axios.post('facturas', this.factura);
                    request.then(response => {
                        console.log(response.data)
                        resp(response.data)
                    }).catch(error => {
                        console.log(error.response)
                        console.log(error.response.data)
                        let status = error.response.status;
                        let message = error.response.data.message;

                        if( status == 500 ){
                            message = 'Error inesperado. por favor intentar más tarde.';
                        }

                        resp({
                            status: status,
                            message: message
                        })
                    });
                    
                    const resp = (resp) => {
                        setTimeout(() => {
                            this.loader = false;
                            this.respAlert(resp.status, resp.message);
                        }, 2000);
                    }
                }
            });
        },
        respAlert(status, msg = ''){
            this.alert = {
                msg: msg,
                clss: ( status == 200 ) ? 'updated' : 'error'
            }

            this.activeComponent = AlertMessageComponent;
        },
    },
    
};
</script>
<style>
    .dropdown-menu.input-result-search.show{
        display: none;
    }

    .dropdown-menu.input-result-search.show.show-search{
        inset: auto !important;
        transform: none !important;
        width:100%;
        padding: 10px 15px;
    }
    .input-result-search.show.show-search{
        display: block;
    }
    .invalid-feedback{
        display: block;
    }
     .div-loader_white{
        margin: 0;
    }
</style>