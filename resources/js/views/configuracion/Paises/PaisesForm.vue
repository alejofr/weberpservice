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
    name: 'PaisesForm',

    data() {
        return {
            componentRender: LoaderComponent,
            card: {
                title: 'Nuevo Pais',
                class: 'max_width480 margin_auto_all',
                action: 'save',
                url: 'paises',
                id: '',
                name: 'paises',
                row: [
                    {
                        class: 'col-xl-12 col-md-12',
                        form: [
                            {
                                nodo: 'input',
                                type: 'text',
                                validate: 'required|max:60',
                                event: 'change',
                                name: 'id_pais_erp',
                                value: '',
                                id: 'id_pais_erp',
                                label: {
                                    title: 'Id Pais',
                                    for: 'id_pais_erp'
                                }
                            },
                            {
                                nodo: 'input',
                                type: 'text',
                                validate: 'required|customAlpha:false|max:60',
                                event: 'change',
                                name: 'nombre',
                                value: '',
                                id: 'nombre',
                                label: {
                                    title: 'Nombre Pais',
                                    for: 'nombre'
                                }
                            },
                            {
                                nodo: 'input',
                                type: 'text',
                                validate: 'required|customAlpha:true|max:36',
                                event: 'change',
                                name: 'nacionalidad_pais',
                                value: '',
                                id: 'nacionalidad_pais',
                                label: {
                                    title: 'Nacionalidad',
                                    for: 'nacionalidad_pais'
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
            if( Object.keys(url).length != 0 ){
                let id = url.id;
                await this.axios.get(`paises/${id}/edit`).then(response => {
                    console.log(response.data)
                    if( response.data.results != null ){
                        const formulario = this.card.row;
                        this.card.title = 'Editar '+response.data.results.nombre;
                        this.card.action = 'update';
                        this.card.id = response.data.results.id_pais;
                        for (const moneda in response.data.results) {
                            for (let i = 0; i< formulario.length; i++) {
                                if( formulario[i].form.length != 0 ){
                                    const form = formulario[i].form;
                                    for (let j = 0; j < form.length; j++) {
                                        if( form[j].name == `${moneda}` ){
                                            form[j].value = `${response.data.results[moneda]}`;
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

           
            
        })  
    },
    methods: {
        
    },
};
</script>