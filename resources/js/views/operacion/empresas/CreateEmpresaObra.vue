<template>
    <div class="row row-cards">
        <div class="col-12">
            <form @submit.prevent="save($event)" class="card" style="max-width: 480px;margin: auto;">
                <div v-show="loader" class="div-loader_white"><loader></loader></div>
                <div class="card-header">
                    <h4 class="card-title">Crear Nueva Obra</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12" v-if="activeComponent"><component :is='activeComponent' v-bind:alert="alert"></component></div>
                        <div class="col-xl-12 col-md-12">
                            <div class="mb-3">
                                <div class="form-floating mb-3">
                                    <select class="form-select" v-model="id_pais" id="paises" aria-label="Selecciona un pais" @change="eventPais">
                                        <option v-for="(pais, index) in paises" :key="index" :value="pais.id_pais" >
                                            {{pais.nombre}}
                                        </option>
                                    </select>
                                    <label for="paises">Paises</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" v-model="obra.id_empresa" id="paises" aria-label="Selecciona un pais">
                                        <option v-for="(empresa, index) in empresas" :key="index" :value="empresa.id_empresa">
                                            {{empresa.nombre_comercial}}
                                        </option>
                                    </select>
                                    <label for="paises">Empresas</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="nombre" v-model="obra.nombre" class="form-control" id="nombre" >
                                    <label for="nombre">Nombre</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="clave" v-model="obra.clave" class="form-control" id="clave" >
                                    <label for="clave">Clave</label>
                                </div>
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
        </div>
    </div>
</template>
<script>
import BtnVolver from '../../../components/BtnVolverComponent.vue';

const LoaderComponent = (() => import('../../../components/LoaderComponent.vue') );
const AlertMessageComponent = (() => import('../../../components/AlertMessageComponent.vue') );

export default {
    name: 'CreateEmpresaObra',

    data() {
        return {
            paises: [],
            id_pais: '',
            empresas: [],
            obra: {
                id_empresa: '',
                nombre: '', 
                clave: '',
            },
            loader: false,
            activeComponent: '',
             alert: {
                msg: '',
                clss: '' 
            },
        };
    },
    components: {
        loader: LoaderComponent,
        BtnVolver,
    },
    beforeCreate(){
        this.$nextTick( async function () {
            await this.getPaisesEmpresas();
        })
    },
    methods: {
        eventPais(){
            console.log(this.id_pais)
            this.getPaisesEmpresas(this.id_pais);

        },
        async getPaisesEmpresas(id = ''){
            this.loader = true;
            await this.axios.get('empresas/paises-empresas', {params : {id_pais: id}}).then(response => {
                console.log(response.data);
                this.loader = false;
                this.paises = ( response.data.results.paises.length != 0 ) ? response.data.results.paises : this.paises;
                this.id_pais = ( id != '' ) ? id : ( id == '' && this.paises.length != 0) ? this.paises[0].id_pais: '';
                this.empresas = response.data.results.empresas;
                this.obra.id_empresa = ( this.empresas.length != 0 ) ? this.empresas[0].id_empresa : '';
            }).catch(error => {
                console.log(error.response)
                this.loader = false;
            });
        },
        save(e){
            e.preventDefault();
            this.loader = true;
            this.activeComponent = AlertMessageComponent;
            this.axios.post('/empresas-obras', this.obra).then(response => {
                console.log(response.data)
                this.loader = false;
                this.alert = {
                    msg: response.data.message,
                    clss: 'updated'
                }
            }).catch(error => {
                console.log(error.response)
                this.loader = false;
                this.alert = {
                    msg: error.response.data.message,
                    clss: 'error'
                }
            });
        }
    },
};
</script>