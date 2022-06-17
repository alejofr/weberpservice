<template>
    <div class="row row-cards">
        <div class="col-12" style="min-height: 60vh;">
            <component :is='componentRender' v-bind:card="card"></component>
        </div>
    </div>
</template>
<script>
const FormOneComponent = () =>  import('../../../components/forms/FormOneComponent.vue');
const LoaderComponent = () => import('../../../components/LoaderComponent.vue');
const Error404 = () => import('../../../components/Error404Component.vue')
export default {
    name: 'TazasCambiosForm',
    data() {
        return {
            componentRender: LoaderComponent,
            card: {
                title: 'Nueva Taza Cambiaria',
                class: 'max_width480 margin_auto_all',
                action: 'save',
                url: 'tazas-cambios',
                id: '',
                name: 'tazas-cambios',
                evento: '',
                row: [
                    {
                        class: 'col-xl-12 col-md-12',
                        form: [
                            {
                                nodo: 'select',
                                type: 'text',
                                validate: 'required',
                                event: 'change',
                                name: 'id_moneda_cambio',
                                value: '',
                                options: [],
                                disable: false,
                                opt:{
                                    id: 'id_moneda_cambio',
                                    name: 'nombre'
                                },
                                id: 'id_moneda_cambio',
                                label: {
                                    title: 'Tipos de Cambios',
                                    for: 'id_moneda_cambio'
                                }
                            },
                            {
                                nodo: 'input',
                                type: 'text',
                                validate: 'required',
                                event: 'change',
                                name: 'monto_tc',
                                value: '',
                                id: 'monto_tc',
                                label: {
                                    title: 'Monto (taza cambiaria)',
                                    for: 'monto_tc'
                                }
                            },
                        ]
                    }
                ]//fin row
            }//fin card
        };
    },
    beforeCreate(){
        this.$nextTick(function () {
            this.cambios_disponibles();
        })  
    },
    methods: {
        cambios_disponibles(){
            const url = this.$route.params;
            if( Object.keys(url).length != 0 ){
                this.axios.get('tipos-cambios/all').then(response => {
                    console.log(response.data)
                    this.edit(url.id, response.data.results)
                }).catch(error => {
                    this.componentRender = Error404;
                });
            }else{
                this.componentRender = Error404;
            }
        },
        edit(id, data){
            this.axios.get(`tazas-cambios/${id}/edit`).then(response => { 
                console.log(response.data)
                if( response.data.results != null ){
                    const cambio = response.data.results;
                    this.card.title = 'Editar Monto Taza';
                    this.card.action = 'update';
                    this.card.id = id;
                    
                    this.card.row[0].form[0].disable = true;
                    this.card.row[0].form[1].value = cambio.monto_tc;
                    this.init_form(cambio.id_moneda_cambio, data);
                    this.componentRender = FormOneComponent;
                }else{
                    this.componentRender = Error404;
                    console.log('aa')
                }
            }).catch(error => {
                this.componentRender = Error404;
            });
        },  
        init_form(id_cambio = '', data){
            const formulario = this.card.row[0].form;
            let arreglo = [];

            for (let i = 0; i < data.length; i++) {
                let objt = {
                    id_moneda_cambio : data[i].id_moneda_cambio,
                    nombre : data[i].abreviatura_nc+' - '+data[i].abreviatura_divisa 
                }
                arreglo.push(objt);
            }

            formulario[0].options = arreglo;
            formulario[0].value = (id_cambio == '') ? arreglo[0].id_moneda_cambio : id_cambio;
            this.componentRender = FormOneComponent;

        },
    },
};
</script>