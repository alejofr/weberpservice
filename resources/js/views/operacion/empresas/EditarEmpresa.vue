<template>
    <div class="row row-cards">
        <div class="col-12">
            <form @submit.prevent="save($event)" class="card" style="max-width: 480px;margin: auto;" v-if="empresa.id_empresa != ''">
                <div v-show="loader" class="div-loader_white"><loader></loader></div>
                <div class="card-header">
                    <h4 class="card-title">Editar {{empresa.nombre_comercial}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12" v-if="activeComponent"><component :is='activeComponent' v-bind:alert="alert"></component></div>
                        <div class="col-xl-12 col-md-12">
                            <div class="mb-3">
                                <div class="form-floating mb-3">
                                    <select class="form-select" v-model="empresa.id_pais" id="paises" aria-label="Selecciona un pais">
                                        <option v-for="(pais, index) in paises" :key="index" :value="pais.id_pais" >
                                            {{pais.nombre}}
                                        </option>
                                    </select>
                                    <label for="paises">Paises</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="nombre_comercial" v-model="empresa.nombre_comercial" class="form-control" id="nombre_comercial" >
                                    <label for="nombre_comercial">Nombre Comercial</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="nombre_comercial_corto" v-model="empresa.nombre_corto" class="form-control" id="nombre_comercial_corto" >
                                    <label for="nombre_comercial_corto">Nombre Comercial Corto</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="clave" v-model="empresa.clave" class="form-control" id="clave" >
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
                            Actualizar
                        </button>
                    </div>
                </div>
            </form>
            <component v-else :is='component404'></component>
        </div>
    </div>
</template>
<script>
import BtnVolver from '../../../components/BtnVolverComponent.vue';

const LoaderComponent = (() => import('../../../components/LoaderComponent.vue') );
const AlertMessageComponent = (() => import('../../../components/AlertMessageComponent.vue') );
const Component404 = (() => import('../../../components/Error404Component.vue'));

export default {
    name: 'EditarEmpresa',
    data() {
        return {
            paises: [],
            empresa: {
                id_empresa: '',
                id_pais: '',
                nombre_comercial: '',
                nombre_corto: '',
                clave: ''
            },
            loader: false,
            activeComponent: '',
             alert: {
                msg: '',
                clss: '' 
            },
            component404: ''
        };
    },
    beforeCreate() {
        this.$nextTick( async function () {
            await this.paisesAll();
            await this.getEmpresa();
        })
    },
    components: {
        loader: LoaderComponent,
        BtnVolver
    },

    methods: {
        async paisesAll(){
            await this.axios.get('paises/all').then(response => {
                this.paises = response.data.results;
                console.log(response.data);
            }).catch(error => {
                console.log(error.response)
            });
        },
        async getEmpresa(){
            await this.axios.get(`empresas/${this.$route.params.id}/edit`).then(response => {
                console.log(response.data.results);
                if ( response.data.results != null ){
                    this.empresa = response.data.results;
                    document.title = document.title +' : '+ this.empresa.nombre_comercial;
                }else{
                    this.component404 = Component404;
                }
            }).catch(error => {
                console.log(error.response)
            });
        },
        save(e){
            e.preventDefault();
            this.loader = true;
            this.activeComponent = AlertMessageComponent;
            this.axios.put(`empresas/${this.empresa.id_empresa}`, this.empresa).then(response => {
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