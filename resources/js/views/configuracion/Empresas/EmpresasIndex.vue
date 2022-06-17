<template>
    <div class="row row-cards">
        <div class="col-12">
            <tables ref="TablesRef" v-bind:columns="data" :viewData="view" v-bind:accion="accion"></tables>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Empresas',

    data() {
        return {
            data: {
                th: [
                    {name: 'Id Empresa'},
                    {name: 'Nombre Empresa'},
                    {name: 'Corto Empresa'},
                    {name: 'Nombre Pais'},
                    {name: 'Corto Divisa'},
                ],
                columns: [
                    {name: 'Nombre Empresa', value: 'wse_empresas.nombre_empresa'},
                    {name: 'Corto Empresa', value: 'wse_empresas.nombre_corto'},
                    {name: 'Nombre Pais', value: 'wse_paises.nombre'},
                    {name: 'Corto Divisa', value: 'wse_monedas.abreviatura'},
                ]
            },
           
            view: 'EmpresasDataTable',
            accion: {
               create: 'EmpresasCreate',
               edit: 'EmpresasEditar',
               delete: 'empresas/delete/'
            },
            request: {
                url: 'empresas',
                params: {
                    limit : 8,
                    page : ( this.$route.query.hasOwnProperty("page") &&  this.$route.query.page.match(/^[0-9]+$/)) ? parseInt(this.$route.query.page) : 1,
                    orderBy : 'wse_empresas.nombre_empresa',
                    ascending : 1,
                    query : {
                        search : '',
                        id_pais: ''
                    } 
                },
            },
        };
    },
    beforeCreate(){
         this.$nextTick(function () {
            this.$store.dispatch('tableadmin/initTable', this.request);
        })
    },
    components: {
       tables: () => import(/* webpackChunkName: "TableComponent" */'../../../components/tables/TableComponent.vue')
    },

    methods: {
        
    },
};
</script>