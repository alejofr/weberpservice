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
                    {name: 'Nombre Proveedor'},
                    {name: 'Nit Proveedor'},
                    {name: 'Cond. Proveedor'}
                ],
                columns: [
                    {name: 'Nombre Proveedor', value: 'wse_op_proveedores.nombre_proveedor'},
                    {name: 'Nit Proveedor', value: 'wse_op_proveedores.nit_proveedor'},
                    {name: 'Cond. Proveedor', value: 'wse_op_conds_proveedores.leyenda_condiciones'}
                ]
            },
            view: 'ProveedoresDataTable',
            accion: {
               create: ( this.$route.name == 'ConfigProveedoresIndex' ) ? 'ProveedoresCreate': '',
               edit: ( this.$route.name == 'ConfigProveedoresIndex' ) ? 'ProveedoresEditar': '',
               delete: ( this.$route.name == 'ConfigProveedoresIndex' ) ? 'proveedores/delete/': ''
            },
            request: {
                url: 'proveedores',
                params: {
                    limit : 8,
                    page : ( this.$route.query.hasOwnProperty("page") &&  this.$route.query.page.match(/^[0-9]+$/)) ? parseInt(this.$route.query.page) : 1,
                    orderBy : 'wse_op_proveedores.nombre_proveedor',
                    ascending : 1,
                    query : {
                        search : '',
                        id_cond: ''
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