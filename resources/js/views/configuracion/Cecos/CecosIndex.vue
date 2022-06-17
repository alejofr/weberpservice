<template>
    <div class="row row-cards">
        <div class="col-12">
            <tables ref="TablesRef" v-bind:columns="data" :viewData="view" v-bind:accion="accion"></tables>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CecosIndex',

    data() {
        return {
            data: {
                th: [
                    {name: 'Id Cecos'},
                    {name: 'Largo Ceco'},
                    {name: 'Corto Ceco'},
                    {name: 'Corto Empresa'},
                ],
                columns: [
                    {name: 'Largo Ceco', value: 'wse_cecos.largo_ceco'},
                    {name: 'Corto Ceco', value: 'wse_cecos.corto_ceco'},
                    {name: 'Corto Empresa', value: 'wse_empresas.nombre_corto'},
                ]
            },
           
            view: 'CecosDataTable',
            accion: {
               create: 'CecosCreate',
               edit: 'CecosEditar',
               delete: 'cecos/delete/'
            },
            request: {
                url: 'cecos',
                params: {
                    limit : 8,
                    page : ( this.$route.query.hasOwnProperty("page") &&  this.$route.query.page.match(/^[0-9]+$/)) ? parseInt(this.$route.query.page) : 1,
                    orderBy : 'wse_cecos.largo_ceco',
                    ascending : 1,
                    query : {
                        search : '',
                        id_empresa: ''
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