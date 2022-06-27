<template>
    <div class="row row-cards">
        <div class="col-12">
            <tables ref="TablesRef" v-bind:columns="data" v-bind:accion="accion" v-bind:json="json"></tables>
        </div>
    </div>
</template>

<script>


export default {
    name: 'SubirFacturas',

    data() {
        return {
            data: {
                th: [
                    {name: 'Id Factura'},
                    {name: 'Id Proveedor'},
                    {name: 'Id Moneda'},
                    {name: 'Id Ceco'},
                    {name: 'Fecha Factura'},
                    {name: 'Fecha Vencimiento'},
                    {name: 'Monto Factura'},
                    {name: 'Descripción Factura'}
                ],
            },
            accion: {
               create: 'facturas/load',
            },
            json: [
                {
                    name: 'Facturas',
                    data: [
                        {
                            id_factura: '',
                            id_proveedor: '',
                            id_moneda: '',
                            id_ceco: '',
                            fecha_factura: 'formato fecha ( Año-Mes-Dia )',
                            fecha_vencimiento_factura: 'formato fecha ( Año-Mes-Dia )',
                            monto_factura: '',
                            descripcion_factura: ''
                        }
                    ]
                },
            ]
        };
    },
    components: {
       tables: () => import(/* webpackChunkName: "LoadMassiveComponenet" */'../../../components/tables/LoadMassiveComponenet.vue')
    }
};
</script>