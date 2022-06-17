<template>
    <div class="row row-cards">
        <div class="col-12" style="min-height: 60vh;">
            <component :is='componentRender' v-bind:card="card" @eventChangeMoneda="eventChangeMoneda" ref="formComponent"></component>
        </div>
    </div>
</template>
<script>
const FormOneComponent = () =>  import('../../../components/forms/FormOneComponent.vue');
const LoaderComponent = () => import('../../../components/LoaderComponent.vue');
const Error404 = () => import('../../../components/Error404Component.vue')
export default {
    name: 'TiposCambiosForm',

    data() {
        return {
            monedas: [],
            componentRender: LoaderComponent,
            card: {
                title: 'Nuevo Tipo de Cambio',
                class: 'max_width480 margin_auto_all',
                action: 'save',
                url: 'tipos-cambios',
                id: '',
                name: 'tipos-cambios',
                evento: 'eventChangeMoneda',
                row: [
                    {
                        class: 'col-xl-12 col-md-12',
                        form: [
                            {
                                nodo: 'select',
                                type: 'text',
                                validate: 'required',
                                event: 'change',
                                name: 'id_moneda_nc',
                                value: '',
                                options: [],
                                 disable: false,
                                opt:{
                                    id: 'id_moneda',
                                    name: 'nombre'
                                },
                                id: 'id_moneda_nc',
                                label: {
                                    title: 'Moneda Nacional',
                                    for: 'id_moneda_nc'
                                }
                            },
                            {
                                nodo: 'select',
                                type: 'text',
                                validate: 'required',
                                event: 'change',
                                name: 'id_moneda_divisa',
                                value: '',
                                options: [],
                                 disable: false,
                                opt:{
                                    id: 'id_moneda',
                                    name: 'nombre'
                                },
                                id: 'id_moneda_divisa',
                                label: {
                                    title: 'Monedas Extranjeras',
                                    for: 'id_moneda_divisa'
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
                                    title: 'Monto Tasa de Cambio',
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
            this.monedas_disponibles();
        })  
    },
    methods: {
        monedas_disponibles(){
            const url = this.$route.params;
            this.axios.get('monedas/all').then(response => {
                this.monedas = response.data.results;
                console.log(response.data)
                if( Object.keys(url).length != 0 ){
                    this.edit(url.id)
                }else{
                    this.init_form();
                }
            }).catch(error => {
                this.componentRender = Error404;
            });
        },
        edit(id){
            this.axios.get(`tipos-cambios/${id}/edit`).then(response => { 
                console.log(response.data)
                if( response.data.results != null ){
                    const cambio = response.data.results;
                    this.card.title = 'Editar Cambio';
                    this.card.action = 'update';
                    this.card.id = id;
                    this.card.row[0].form.splice(2);

                    this.init_form(cambio.id_moneda_nc, cambio.id_moneda_divisa);
                }else{
                    this.componentRender = Error404;
                }
            }).catch(error => {
                this.componentRender = Error404;
            });
        },
        init_form(id = '', id_divisa = ''){
            const formulario = this.card.row[0].form;
            formulario[0].options = this.monedas;
            formulario[0].value = (id == '') ? this.monedas[0].id_moneda : id;
            this.monedasCambios(formulario[0].value, formulario, false, id_divisa);
        },
         monedasCambios(id_moneda, formulario, act = false, id_divisa = ''){
            let arreglo = [];
            let monedas = this.monedas;
            for (let i = 0; i < monedas.length; i++) {
                if( monedas[i].id_moneda != id_moneda ){
                    arreglo.push(monedas[i]);
                }
            }

            formulario[1].options = arreglo;
            formulario[1].value = ( id_divisa == '' ) ? arreglo[0].id_moneda : id_divisa;

            console.log(this.card);
            this.card.row[0].form = formulario;
            this.componentRender = FormOneComponent;
            if( act )
                this.$refs.formComponent.updateCard();
            
        },
        eventChangeMoneda(resp){
            const formulario = this.card.row[0].form;

            if( resp.id_moneda_nc != formulario[0].value) {
                formulario[0].value = resp.id_moneda_nc;
                this.monedasCambios(resp.id_moneda_nc, formulario, true);
            }
           
            
        }

    },
};
</script>