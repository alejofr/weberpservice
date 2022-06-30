<template>
    <div class="row row-cards">
        <div class="col-12">
            <tables ref="TablesRef" v-bind:columns="data" :viewData="view" v-bind:accion="accion"></tables>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Proveedores',

    data() {
        return {
            data: {
                th: [
                    {name: 'Detalles'},
                    {name: 'Status'},
                    {name: 'Remesa'},
                    {name: 'Ceco'},
                    {name: 'Proveedor'},
                    {name: 'Nombre Proveedor'},
                    {name: 'No. de Factura'},
                    {name: 'Fecha Factura'},
                    {name: 'Fecha Vencimiento'},
                    {name: 'Total Factura'},
                    {name: 'Por Pagar'},
                    {name: 'Divisa'},
                    {name: 'T.C'},
                    {name: 'Total M.N'},
                    {name: 'Descripcion Factura'},
                    {name: 'Contrato'},
                    {name: 'Bolsa'}
                ],
                columns: [
                    {name: 'Proveedor', value: 'wse_op_proveedores.nit_proveedor'},
                    {name: 'Corto Ceco', value: 'wse_cecos.corto_ceco'},
                    {name: 'Moneda', value: 'wse_monedas.nombre'},
                    {name: 'Id Factura', value: 'wse_facturas.id_factura_erp'},
                    {name: 'Fecha Factura', value: 'wse_facturas.fecha_factura'},
                    {name: 'Fecha Vencimiento', value: 'wse_facturas.fecha_vencimiento'},
                    {name: 'Monto Factura', value: 'wse_facturas.monto_factura'},
                    {name: 'Descripcion Factura', value: 'wse_facturas.descripcion_factura'}
                ]
            },
            view: 'FacturasDataTable',
            accion: {
               create:'',
               edit: '',
               delete: ''
            },
            request: {
                url: 'facturas',
                params: {
                    limit : 8,
                    page : ( this.$route.query.hasOwnProperty("page") &&  this.$route.query.page.match(/^[0-9]+$/)) ? parseInt(this.$route.query.page) : 1,
                    orderBy : 'wse_facturas.fecha_factura',
                    ascending : 1,
                    query : {
                        search : '',
                    } 
                },
            },
        };
    },
    beforeCreate(){
        console.log(this.$route.name)
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