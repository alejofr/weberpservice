<template>
    <div class="row row-cards">
        <div class="col-12">
            <tables ref="TablesRef" v-bind:columns="data" :viewData="view" v-bind:accion="accion"></tables>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Monedas',

    data() {
        return {
            data: {
                th: [
                    {name: 'Nombre Pais'},
                    {name: 'Monedas'},
                    {name: 'Abreviatura Moneda'}
                ],
                columns: [
                    {name: 'Nombre Pais', value: 'wse_paises.nombre'},
                    {name: 'Monedas', value: 'wse_monedas.nombre'},
                    {name: 'Abreviatura Moneda', value: 'wse_monedas.abreviatura'}
                ]
            },
            view: 'MonedasDataTable',
            accion: {
               create: 'MonedaCreate',
               edit: 'MonedaEditar',
               delete: 'monedas/delete/'
            },
            request: {
                url: 'monedas',
                params: {
                    limit : 8,
                    page : ( this.$route.query.hasOwnProperty("page") &&  this.$route.query.page.match(/^[0-9]+$/)) ? parseInt(this.$route.query.page) : 1,
                    orderBy : 'wse_paises.nombre',
                    ascending : 1,
                    query : {
                        search : ''
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