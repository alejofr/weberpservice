<template>
    <div class="row row-cards">
        <div class="col-12" style="min-height: 60vh;">
            <component :is='componentRender' v-bind:card="card" @eventChangePais="eventChangePais" ref="formComponent"></component>
        </div>
    </div>
</template>
<script>
const FormOneComponent = () =>  import('../../../components/forms/FormOneComponent.vue');
const LoaderComponent = () => import('../../../components/LoaderComponent.vue');
const Error404 = () => import('../../../components/Error404Component.vue')
export default {
    name: 'CecosForm',

    data() {
        return {
            monedas: [],
            componentRender: LoaderComponent,
            card: {
                title: 'Nuevo Ceco',
                class: 'max_width480 margin_auto_all',
                action: 'save',
                url: 'cecos',
                id: '',
                name: 'cecos',
                evento: 'eventChangePais',
                row: [
                    {
                        class: 'col-xl-12 col-md-12',
                        form: [
                            {
                                nodo: 'select',
                                validate: 'required',
                                event: 'change',
                                name: 'id_pais',
                                value: '',
                                options: [],
                                 disable: false,
                                opt:{
                                    id: 'id_pais',
                                    name: 'nombre'
                                },
                                id: 'id_pais',
                                label: {
                                    title: 'Selecciona Un Pais',
                                    for: 'id_pais'
                                }
                            },
                            {
                                nodo: 'select',
                                validate: 'required',
                                event: 'change',
                                name: 'id_empresa',
                                value: '',
                                options: [],
                                 disable: false,
                                opt:{
                                    id: 'id_empresa',
                                    name: 'nombre_empresa'
                                },
                                id: 'id_empresa',
                                label: {
                                    title: 'Selecciona la empresa',
                                    for: 'id_empresa'
                                }
                            },
                            {
                                nodo: 'input',
                                type: 'text',
                                validate: 'required',
                                event: 'change',
                                name: 'largo_ceco',
                                value: '',
                                id: 'largo_ceco',
                                label: {
                                    title: 'Largo Ceco',
                                    for: 'largo_ceco'
                                }
                            },
                            {
                                nodo: 'input',
                                type: 'text',
                                validate: 'required',
                                event: 'change',
                                name: 'corto_ceco',
                                value: '',
                                id: 'corto_ceco',
                                label: {
                                    title: 'Corto Ceco',
                                    for: 'corto_ceco'
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
            this.init();
        })  
    },
    methods: {
        init(){
            this.axios.get('paises/all').then(response => {
                console.log(response.data)
                if( response.data.results != null ){
                    this.card.row[0].form[0].options = response.data.results;
                    //this.card.row[0].form[0].value = this.card.row[0].form[0].options[0].id_pais;
                    this.init_form();
                }else{
                    compt = 'Error404';
                }
            }).catch(error => {
                rend('Error404')
            });
        },
        edit(id){
            this.axios.get(`cecos/${id}/edit`).then(response => { 
                console.log(response.data)
                if( response.data.results != null ){
                    const ceco = response.data.results;
                    this.card.title = 'Editar Ceco: '+ceco.largo_ceco;
                    this.card.action = 'update';
                    this.card.id = id;
                    this.card.row[0].form[0].value = ceco.id_pais;
                    this.card.row[0].form[1].value = ceco.id_empresa;
                    this.card.row[0].form[2].value = ceco.largo_ceco;
                    this.card.row[0].form[3].value = ceco.corto_ceco;
                    this.search_empresas(ceco.id_pais);
                    this.componentRender = FormOneComponent;
                }else{
                    this.componentRender = Error404;
                }
            }).catch(error => {
                this.componentRender = Error404;
            });
        },
        init_form(){
            const url = this.$route.params;
            if( Object.keys(url).length != 0 ){
                 this.edit(url.id);
            }else{
                this.componentRender = FormOneComponent;
            }
        },
        search_empresas(id){
            this.axios.get('empresas/all', {params : { id_pais: id }}).then(response => {
                if( response.data.results != null ){
                    this.card.row[0].form[1].options = response.data.results;
                    this.$refs.formComponent.updateCard();
                }
            }).catch(error => {
                
            });
        },
        eventChangePais(resp){
            const formulario = this.card.row[0].form;

            if( resp.id_pais != this.card.row[0].form[0].value) {
                this.card.row[0].form[0].value = resp.id_pais;
                 this.card.row[0].form[1].value = '';
                this.search_empresas(resp.id_pais);
            }
           
            
        }

    },
};
</script>