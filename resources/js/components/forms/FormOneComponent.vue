<template>
    <form @submit.prevent="submit($event)" :name="card.name" class="card" :class="card.class">
        <div v-show="loader" class="div-loader_white"><loader></loader></div>
        <div class="card-header">
            <h4 class="card-title">{{card.title}}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-12 col-md-12" v-if="activeComponent"><component :is='activeComponent' v-bind:alert="alert"></component></div>
                <div v-for="(card, index) in card.row" :key="index" :class="card.class">
                    <div class="mb-3" v-for="(form, index) in card.form" :key="index">
                        <div class="form-floating mb-3" :class="{'is-invalid': errors.first(form.name)}" v-if="form.nodo == 'select'">
                            <select class="form-select" :disabled="form.disable" :name="form.name" v-validate="form.validate" :id="form.id" v-model="nodoForms[form.name]" @change="eventSelect($event)" :data-vv-validate-on="form.event">
                                <option v-for="(data, index) in form.options" :key="index" :value="data[form.opt.id]" >
                                    {{data[form.opt.name]}}
                                </option>
                            </select>
                            <label :for="form.label.for">{{ form.label.title }}</label>
                            <div v-if="errors.has(form.name)" class="invalid-feedback">{{errors.first(form.name)}}</div>
                        </div>
                        <div class="form-floating mb-3" v-if="form.nodo == 'input'">
                            <input  :key="index" :type="form.type" v-validate="form.validate" :name="form.name" class="form-control" :class="{'is-invalid': errors.first(form.name)}" :id="form.id" v-model="nodoForms[form.name]" :data-vv-validate-on="form.event">
                            <label :for="form.label.for">{{form.label.title}}</label>
                            <div v-if="errors.has(form.name)" class="invalid-feedback">{{errors.first(form.name)}}</div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <div class="d-flex">
                <btn-volver :classe="'btn-light'"></btn-volver>
                <button type="submit" class="btn btn-primary ms-auto">
                    <i class="ti ti-plus me-1"></i>
                    <span v-if="card.action == 'save'">Guardar</span>
                    <span v-else>Actualizar</span>
                </button>
            </div>
        </div>
    </form>
</template>
<script>
import BtnVolver from '../../components/BtnVolverComponent.vue';

const LoaderComponent = (() => import('../../components/LoaderComponent.vue') );
const AlertMessageComponent = (() => import('../../components/AlertMessageComponent.vue') );

export default {
    props: ['card'],
    name: 'FormOneComponent',
    data() {
        return {
            nodoForms: {},
            loader: false,
            activeComponent: '',
             alert: {
                msg: '',
                clss: '' 
            },
        };
    },
    beforeCreate(){
        this.$nextTick(async function () { 
            console.log(this.card);
            this.nodoForms = this.formModel();
            let prueba = this.nodoForms;
            console.log(this.nodoForms);
            console.log(`${prueba}.${this.card.row[0].form[0].name}`);
            
        })
    },
    components: {
        loader: LoaderComponent,
        BtnVolver,
    },
    methods: {
        formModel(){
            const formulario = this.card.row;

            let arreglo = [];
            for (let i = 0; i< formulario.length; i++) {
                if( formulario[i].form.length != 0 ){
                    const cardForm = formulario[i].form;
                    for (let j = 0; j < cardForm.length; j++) {
                        arreglo[cardForm[j].name] = cardForm[j].value;
                    }
                }
            }

            return Object.assign({}, arreglo);
        },
        async submit(e){
            e.preventDefault();
            //const formName = e.target.name;
            console.log(this.nodoForms);

            this.$validator.validate().then(valid => {
                if( valid ){
                    this.loader = true;

                    const request = ( this.card.action == 'save' ) ? this.axios.post(this.getUrl(this.card.action), this.nodoForms) : this.axios.put(this.getUrl(this.card.action), this.nodoForms);
                    request.then(response => {
                        console.log(response.data)
                        resp(response.data)
                    }).catch(error => {
                        console.log(error.response)
                        console.log(error.response.data)
                        let status = error.response.status;
                        let message = error.response.data.message;

                        if( status == 500 ){
                            message = 'Error inesperado. por favor intentar más tarde.';
                        }

                        resp({
                            status: status,
                            message: message
                        })
                    });
                    
                    const resp = (resp) => {
                        setTimeout(() => {
                            this.loader = false;
                            this.respAlert(resp.status, resp.message);
                        }, 2000);

                        if( resp.status == 200 ){
                            setTimeout(() => {
                                this.$router.go(-1)
                            }, 4000)
                        }
                    }
                }
            });
        },
        getUrl(typeRequest){
            return ( typeRequest == 'save' ) ? `${this.card.url}` : `${this.card.url}/${this.card.id}`;
        },
        respAlert(status, msg = ''){
            this.alert = {
                msg: msg,
                clss: ( status == 200 ) ? 'updated' : 'error'
            }

            this.activeComponent = AlertMessageComponent;
        },
        eventSelect(e){
            console.log(e);
            if( this.card.evento != '' ){
                this.$emit(this.card.evento, this.nodoForms);
            }
            
        },
        updateCard(){
            console.log('aqui se actualizo');
            this.nodoForms = this.formModel();
        }
    },
};
</script>
<style>
    .max_width480{
        max-width: 480px;
    }
    .margin_auto_all{
        margin: auto;
    }
    .div-loader_white{
        margin: 0;
    }
</style>