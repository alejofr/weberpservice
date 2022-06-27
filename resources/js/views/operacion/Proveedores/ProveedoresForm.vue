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
    name: 'EmpresasForm',

    data() {
        return {
            componentRender: LoaderComponent,
            card: {
                title: 'Nuevo Proveedor',
                class: 'max_width480 margin_auto_all',
                action: 'save',
                url: 'proveedores',
                id: '',
                name: 'proveedores',
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
                                name: 'id_cond_proveedor',
                                value: '',
                                options: [],
                                disable: false,
                                opt:{
                                    id: 'id_cond_proveedor',
                                    name: 'leyenda_condiciones'
                                },
                                id: 'id_cond_proveedor',
                                label: {
                                    title: 'Selecciona una Condición',
                                    for: 'leyenda_condiciones'
                                }
                            },//
                            {
                                nodo: 'input',
                                type: 'text',
                                validate: 'required|max:60',
                                event: 'change',
                                name: 'id_proveedor_erp',
                                value: '',
                                id: 'id_proveedor_erp',
                                label: {
                                    title: 'Id Proveedor',
                                    for: 'id_proveedor_erp'
                                }
                            },
                            {
                                nodo: 'input',
                                type: 'text',
                                validate: 'required|max:60',
                                event: 'change',
                                name: 'nombre_proveedor',
                                value: '',
                                id: 'nombre_proveedor',
                                label: {
                                    title: 'Nombro Proveedor',
                                    for: 'nombre_proveedor'
                                }
                            },
                            {
                                nodo: 'input',
                                type: 'text',
                                validate: '',
                                event: 'change',
                                name: 'nit_proveedor',
                                value: '',
                                id: 'nit_proveedor',
                                label: {
                                    title: 'Nit Proveedor',
                                    for: 'nit_proveedor'
                                }
                            },
                        ]
                    }
                ]//fin row
            }//fin card
        };
    },
    beforeCreate(){
        this.$nextTick(async function () {
            const url = this.$route.params;
            const compt = 'FormOneComponent';
            const rend = (comp) => {
                setTimeout(() => {
                    this.componentRender = (  comp == 'FormOneComponent' ) ? FormOneComponent : Error404;
                }, 1000);
            }

            await this.axios.get('condiciones-proveedores/all').then(response => {
                console.log(response.data)
                if( response.data.results != null ){
                    this.card.row[0].form[0].options = response.data.results
                }else{
                    compt = 'Error404';
                }
            }).catch(error => {
                rend('Error404')
            });

            if( Object.keys(url).length != 0 ){
                let id = url.id;
                await this.axios.get(`proveedores/${id}/edit`).then(response => {
                    console.log(response.data)
                    if( response.data.results != null ){
                        const formulario = this.card.row;
                        this.card.title = 'Editar Proveedor: '+response.data.results.nombre_proveedor;
                        this.card.action = 'update';
                        this.card.id = id;

                        for (const proveedor in response.data.results) {
                            for (let i = 0; i< formulario.length; i++) {
                                if( formulario[i].form.length != 0 ){
                                    const form = formulario[i].form;
                                    for (let j = 0; j < form.length; j++) {
                                        if( form[j].name == `${proveedor}` ){
                                            form[j].value =  ( `${response.data.results[proveedor]}` != 'null' ) ? `${response.data.results[proveedor]}` : '';
                                        }
                                    }
                                }
                            }
                        }
                    }else{
                        compt = 'Error404';
                    }

                    rend(compt)
                 
                }).catch(error => {
                    rend('Error404')
                });
            }else{
                rend(compt)
            } 

             //rend(compt)
        })  
    },
    methods: {
        
    },
};
</script>