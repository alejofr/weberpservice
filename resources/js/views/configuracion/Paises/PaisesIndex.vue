<template>
    <div class="row row-cards">
        <div class="col-12">
            <tables ref="TablesRef" v-bind:columns="data" :viewData="view" v-bind:accion="accion"></tables>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PaisIndex',

    data() {
        return {
            data: {
                th: [
                    {name: 'Id Pais'},
                    {name: 'Nombre Pais'},
                    {name: 'Nacionalidad'},
                ],
                columns: [
                    {name: 'Id pais', value: 'wse_paises.id_pais_erp'},
                    {name: 'Nombre Pais', value: 'wse_paises.nombre'},
                    {name: 'Nacionalidad', value: 'wse_paises.nacionalidad_pais'},
                ]
            },
           
            view: 'PaisesDataTable',
            accion: {
               create: 'PaisesCreate',
               edit: 'PaisesEditar',
               delete: 'paises/delete/'
            },
            request: {
                url: 'paises',
                params: {
                    limit : 8,
                    page : ( this.$route.query.hasOwnProperty("page") &&  this.$route.query.page.match(/^[0-9]+$/)) ? parseInt(this.$route.query.page) : 1,
                    orderBy : 'wse_paises.id_pais_erp',
                    ascending : 1,
                    query : {
                        search : '',
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