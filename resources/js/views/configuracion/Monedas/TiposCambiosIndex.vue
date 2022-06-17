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
                    //{name: 'Pais'},
                    {name: 'Moneda Nacional'},
                    {name: 'Moneda Extranjera'},
                    {name: 'Tasa de Cambio'},
                    {name: 'Ultima Actualizaión de Tasa'},
                    {name: ''},
                ],
                columns: [
                    //{name: 'Pais', value: 'wse_paises.nombre'},
                    {name: 'Moneda Nacional', value: 'wse_monedas.abreviatura'},
                    {name: 'Moneda Extranjera', value: 'money.abreviatura'},
                ]
            },
           
            view: 'MonedasCambiosDataTable',
            accion: {
               create: 'MonedasCambiosCreate',
               edit: 'MonedasCambiosEditar',
               delete: 'tipos-cambios/delete/'
            },
            request: {
                url: 'tipos-cambios',
                params: {
                    limit : 8,
                    page : ( this.$route.query.hasOwnProperty("page") &&  this.$route.query.page.match(/^[0-9]+$/)) ? parseInt(this.$route.query.page) : 1,
                    orderBy : 'wse_monedas.abreviatura',
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