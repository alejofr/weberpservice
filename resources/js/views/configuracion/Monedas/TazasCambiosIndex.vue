<template>
    <div class="row row-cards">
        <div class="col-12">
            <component :is='comp' ref="TablesRef" v-bind:columns="data" :viewData="view" v-bind:accion="accion"></component>
        </div>
    </div>
</template>

<script>
const Error404 = () => import('../../../components/Error404Component.vue')
const tables = () => import(/* webpackChunkName: "TableComponent" */'../../../components/tables/TableComponent.vue');
export default {
    name: 'Monedas',

    data() {
        return {
            comp: '',
            data: {
                th: [
                    {name: 'Moneda Nacional'},
                    {name: 'Moneda Extranjera'},
                    {name: 'Monto taza'},
                    {name: 'Usuario'},
                    {name: 'Fecha Actualizado'}
                ],
                columns: [
                    {name: 'Moneda Nacional', value: 'wse_monedas.abreviatura'},
                    {name: 'Moneda Extranjera', value: 'money.abreviatura'},
                    {name: 'Monto taza', value: 'wse_monedas_cambios_tazas.monto_tc'},
                    {name: 'Fecha Actualizado', value: 'wse_monedas_cambios_tazas.fecha_editado'}
                ]
            },
            view: 'MonedasCambiosTazasDataTable',
            accion: {
               create: '',
               edit: '',
               delete: '',
               volver: ''
            },
            request: {
                url: 'tazas-cambios',
                params: {
                    limit : 8,
                    page : ( this.$route.query.hasOwnProperty("page") &&  this.$route.query.page.match(/^[0-9]+$/)) ? parseInt(this.$route.query.page) : 1,
                    orderBy : 'wse_monedas.abreviatura',
                    ascending : 1,
                    query : {
                        search : '',
                        id_cambio: ''
                    } 
                },
            },
        };
    },
    beforeCreate(){
         this.$nextTick(function () {
            const url = this.$route.params;
            if( Object.keys(url).length != 0 ){
                this.comp = tables;
                this.request.params.query.id_cambio = url.id;
                this.$store.dispatch('tableadmin/initTable', this.request);
            }else{
                this.comp = Error404;
            }
        })
    },

    methods: {
        
    },
};
</script>