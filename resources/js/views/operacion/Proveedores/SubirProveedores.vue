<template>
    <div class="row row-cards">
        <div class="col-12">
            <tables ref="TablesRef" v-bind:columns="data" v-bind:accion="accion" v-bind:json="json"></tables>
        </div>
    </div>
</template>

<script>


export default {
    name: 'CargaMasivaProveedores',

    data() {
        return {
            data: {
                th: [
                    {name: 'Id Proveedor'},
                    {name: 'Nombre Proveedor'},
                    {name: 'Nit Proveedor'},
                    {name: 'Id Condicion Proveedor'}
                ],
            },
            accion: {
               create: 'proveedores/load',
            },
            json: [
                {
                    name: 'Proveedores',
                    data: [
                        {
                            id_proveedor: '',
                            nombre_proveedor: '',
                            nit_proveedor: '',
                            id_condicion_proveedor: ''
                        }
                    ]
                },
                {
                    name: 'Condiciones de Proveedores',
                    data: []
                }
            ]
        };
    },
    beforeCreate(){
        this.$nextTick(async function () {
            await this.axios.get('condiciones-proveedores/all').then(response => {
                console.log(response.data)
                const results = response.data.results;
                let arreglo = []
                for (let i = 0; i < results.length; i++) {
                    let objt = {
                        id_cond_proveedor_erp: results[i].id_cond_proveedor_erp,
                        leyenda_condiciones: results[i].leyenda_condiciones
                    }
                    arreglo.push(objt)
                }
                this.json[1].data = arreglo;
                console.log(arreglo)
            }).catch(error => {
                console.log(error.response.data)
            });
        })
       
    },
    components: {
       tables: () => import(/* webpackChunkName: "LoadMassiveComponenet" */'../../../components/tables/LoadMassiveComponenet.vue')
    },

    methods: {
        
    },
};
</script>