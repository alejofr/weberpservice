<template>
    <div class="row row-cards">
        <div class="col-12 mb-3">
            <div class="inner-form">
                <div class="input-field first-wrap">
                    <div class="icon-wrap"><span class="ti ti-search"></span></div>
                    <input type="text" v-model="objt.search"  id="search" placeholder="Busca por Nombre de empresa y clave" >
                    <router-link :to="{ name:'EmpresasIndex', query: { id_pais: objt.id_pais } }" class="btn-close-search" v-if="objt.search != ''">
                        <i class="icon-clear ti ti-x"></i>
                    </router-link>
                </div>
                <div class="input-field second-wrap">
                    <div class="icon-wrap"><span class="ti ti-current-location"></span></div>
                    <select name="paises" v-model="objt.id_pais" id="paises">
                        <option v-for="(pais, index) in paises" :key="index" :value="pais.id_pais">{{pais.nombre}}</option>
                    </select>
                </div>
                <div class="input-field submit-wrap">
                    <router-link :to="{ name:'EmpresasIndex', query: objt }">Buscar</router-link>
                </div>
            </div>
        </div>
        <div class="col-12">
            <tables ref="TablesRef" v-bind:columns="columns" :viewData="view" v-bind:accion="accion"></tables>
        </div>
    </div>
</template>
<script>
export default {
    name: 'IndexGeolocalizacion',
    data() {
        return {
            columns: [
                {name: 'Pais', value: 'wse_paises.nombre'},
                {name: 'Empresa', value: 'empresas.nombre_comercial'},
                {name: 'Clave Empresa', value: 'empresas.clave'},
                {name: 'Cant. Obras', value: ''},
            ],
            view: 'EmpresasDataTable',
            accion: {
               create: [
                   {
                       title: 'Nueva Empresa',
                       name: 'EmpresaCreate'
                   },
                   {
                       title: 'Nueva Obra',
                       name: 'EmpresaObraCreate'
                   }
               ],
               edit: 'EmpresaEditar',
               delete: 'empresas/'
            },
            request: {
                url: 'empresas',
                params: {
                    limit : 8,
                    page : ( this.$route.query.hasOwnProperty("page") &&  this.$route.query.page.match(/^[0-9]+$/)) ? parseInt(this.$route.query.page) : 1,
                    orderBy : 'wse_paises.nombre',
                    ascending : 1,
                    query : {
                        id_pais : '',
                        search : ''
                    } 
                },
            },
            paises: []
        }
    },
    computed: {
        objt(){
            return {
                id_pais: ( this.$route.query.hasOwnProperty('id_pais') === true ) ? this.$route.query.id_pais : '',
                search: ( this.$route.query.hasOwnProperty('search') === true ) ? this.$route.query.search : ''
            }
        }
    },
    components: {
       tables: () => import(/* webpackChunkName: "TableComponent" */'../../../components/tables/TableComponent.vue')
    },
    beforeCreate() {
        this.$nextTick(function () {
            console.log('qlq')
           this.init();
        })
    },
    methods: {
        async init(){
            await this.axios.get('empresas/paises-empresas').then(response => {
                console.log(response.data);
                this.paises = response.data.results.paises;
                this.objt.id_pais = ( this.paises.length != 0 ) ? this.paises[0].id_pais : '';

               
                this.request.params.query.id_pais =  this.objt.id_pais;

                this.$store.dispatch('tableadmin/initTable', this.request);
            }).catch(error => {
                console.log(error.response)
            });
        },
    },
};
</script>