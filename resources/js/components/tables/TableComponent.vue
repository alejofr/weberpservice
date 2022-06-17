<template>
    <div class="card">
        <div class="card-body border-bottom py-3 " style="border-radius: 3px 3px 0 0;position:relative;">
            <transition name="component-fade" mode="out-in">
                <keep-alive>
                    <component :is='cardBodyComponent' v-bind:alert="msgAlert" v-bind:deleteData="deleteData" @getMessageDelete="getMessageDelete"></component>
                </keep-alive>
            </transition>
            <div class="div_action_table div_flex_w ">
                <div class="div_flex_w div_flex_r div_left-flex ">
                    <div class="div_select_orderBy mb-2 me-3">
                        <div class="form-label">Ordenar por:</div>
                        <div>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" @change="filterData()" name="ascending" value="1" v-model="ascending">
                                <span class="form-check-label">ASC</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" @change="filterData()" name="ascending" v-model="ascending" value="0">
                                <span class="form-check-label">DESC</span>
                            </label>
                        </div>
                    </div>
                    <div class="div_select_column mb-2">
                        <select name="columns" v-model="orderBy" class="form-select" @change="filterData()" >
                            <option v-for="(column, index) in columns.columns" :key="index" :value="column.value" >
                                {{column.name}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="ms-auto text-muted div_right-flex">
                    <div class="btn-list btn-action-component mt-2">
                        <router-link class="btn btn-outline-primary" :to="{ name: accion.create }" v-if="accion.create != '' && !Array.isArray(accion.create)">
                            <i class="ti ti-plus me-1"></i>
                            Agregar
                        </router-link>
                        <div class="dropdown" v-if="Array.isArray(accion.create) && accion.create.length != 0">
                            <button class="btn dropdown-toggle btn-outline-primary align-text-top" data-bs-toggle="dropdown" aria-expanded="false">
                               <i class="ti ti-plus me-1"></i> Agregar
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <router-link class="dropdown-item" v-for="(link, index) in accion.create" :key="index" :to="{ name: link.name }">
                                   {{link.title}}
                                </router-link>
                            </div>
                        </div>
                        <button type="button" @click="modificar" class="btn btn-dark" v-if="accion.edit != ''">
                            <i class="ti ti-edit me-1"></i>
                            Modificar
                        </button>
                        <button type="button" class="btn btn-danger" @click="eliminar($event)" v-if="accion.delete != '' && !Array.isArray(accion.delete)">
                            <i class="ti ti-trash me-1"></i>
                            Eliminar
                        </button>
                        <div class="dropdown" v-if="Array.isArray(accion.delete) && accion.delete.length != 0">
                            <button class="btn dropdown-toggle btn-danger align-text-top" data-bs-toggle="dropdown" aria-expanded="false">
                               <i class="ti ti-trash me-1"></i> Eliminar
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <button type="button" class="dropdown-item" @click="eliminar($event)" v-for="(link, index) in accion.delete" :key="index" :value="link.title">
                                   {{link.title}}
                                </button>
                            </div>
                        </div>
                        <btn-volver-component v-if="accion.hasOwnProperty('volver')"></btn-volver-component>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th></th>
                        <th v-for="(column, index) in columns.th" :key="index">{{column.name}}</th>
                    </tr>
                </thead>
                <transition name="component-fade" mode="out-in">
                    <keep-alive>
                        <component :is='tbodyComponent' v-bind:data="dataTble" v-bind:th="columns.th" @getId="getId"></component>
                    </keep-alive>
                </transition>
            </table>
        </div>
        <transition name="component-fade" mode="out-in">
            <keep-alive>
                <component :is='paginationComponent'></component>
            </keep-alive>
        </transition>
    </div>
</template>
<script>
import BtnVolverComponent from '../BtnVolverComponent.vue';

const loaderWhite = () => import('../LoaderWhiteComponent.vue')
const skeletonTableBody  = () => import('./datatables/SkeletonDataTables.vue');
const skeletonPagination = () => import('./pagination/SkeletonPagination.vue');

const tablebody = (viewData) => { return () => import(`./datatables/${viewData}.vue`); }
const pagination = () => import('./pagination/PaginationComponent.vue');

const deleteConfirmModal = () =>import('../ConfirmDeleteModal.vue');
const alertMessage = () => import('../AlertMessageComponent.vue');

export default {
  components: { BtnVolverComponent },
    name: 'TableAdminComponent',
    props: ['viewData', 'columns', 'accion'],
    data(){
        return {
            ascending: 1,
            orderBy: this.columns.columns[0].value,
            msgAlert: {
                msg: '',
                clss: '',
            },
            deleteData: {
                url: '',
                id: '',
            },
            itemDataId: '',
        }
    },
    computed: {
        getRequest(){
            return { ...this.$store.getters['tableadmin/getRequest'] }
        },
        dataTble(){
                const data = this.$store.getters['tableadmin/getDataTable']
                if( data.length == 0 ){
                    this.msgAlert = {
                        msg: 'No se encontró resultados',
                        clss: 'error'
                    }
                    
                    this.$store.dispatch('tableadmin/alertMessage', true);
                }

            return data;
        },
        cardBodyComponent(){
            const cmpts = this.$store.getters['tableadmin/getComponents']
            return ( cmpts.cardBody == 'deleteConfirmModal' ) ? deleteConfirmModal 
                    : ( cmpts.cardBody == 'alertMessage' ) ? alertMessage : ( cmpts.cardBody == 'loaderWhite' ) ? loaderWhite : '';
        },
        tbodyComponent() {
            const cmpts = this.$store.getters['tableadmin/getComponents']
            return ( cmpts.tbody == 'tablebody') ? tablebody(this.viewData) : skeletonTableBody;
        },
        paginationComponent(){
            const cmpts = this.$store.getters['tableadmin/getComponents']
            return ( cmpts.pagination == 'pagination') ? pagination : skeletonPagination;
        }

    },
    methods: {
        getMessageDelete(response){
            this.alert = {
                msg: response.message,
                clss: (response.status == 200) ? 'updated' :'error'
            }
            this.$store.dispatch('tableadmin/alertMessage', true);

            if( response.status == 200 ){
                this.itemDataId = '';
                this.$store.dispatch('tableadmin/modalDelete', false);
                this.$store.dispatch('tableadmin/resetInit');
            }
        },
        filterData(){
            this.getRequest.params.orderBy = this.orderBy
            this.getRequest.params.ascending = parseInt(this.ascending)

            this.$store.dispatch('tableadmin/initTable', this.getRequest);
        },
        modificar(){
            if( this.validGetId('modificar') ){
                this.$router.push({ name: `${this.accion.edit}`, params: { id: this.itemDataId } });
            }
        },
        eliminar(e){
            let value = e.target.value;

            if( this.validGetId('eliminar') ){ 
                let url = ( !Array.isArray(this.accion.delete) ) ? this.accion.delete : '';
                let id = ( !Array.isArray(this.itemDataId) ) ? this.itemDataId : '';

                if( url == '' && id == '' ){
                    const arrDelete = this.accion.delete;
                    for (let i = 0; i < arrDelete.length; i++) {
                       if( arrDelete[i].title == value ){
                           
                           if ( this.itemDataId[i] != null){
                               url = arrDelete[i].value;
                               id = this.itemDataId[i];
                                break;
                           }
                          
                       }  
                    }
                }

                if( url != '' && id != '' ){
                    this.deleteData = {
                        url: url,
                        id: id
                    }
                    this.$store.dispatch('tableadmin/modalDelete', true);
                }else{
                    this.msgAlert = {
                        msg: 'Error, No hay datos que eliminar para esta accion',
                        clss: 'error'
                    }
                    
                    this.$store.dispatch('tableadmin/alertMessage', true);
                }
                
            }
        },
        getId(id){
            this.itemDataId = id;
            console.log(this.itemDataId)
        },
        validGetId(accMsg){
            if ( this.itemDataId == '' || Array.isArray(this.itemDataId)  && this.itemDataId.length == 0){
                this.msgAlert = {
                    msg: 'Error, debe seleccionar una casilla que desea '+accMsg,
                    clss: 'error'
                }
                
                this.$store.dispatch('tableadmin/alertMessage', true);
                return false;
            }

            return true
        }
    }
};
</script>
<style scoped>
    .div_flex_w, .div_flex_r{
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
    }

    .div_flex_w{
        -webkit-flex-wrap: wrap;
        -moz-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        -o-flex-wrap: wrap;
        flex-wrap: wrap;
    }

    .div_flex_r{
        -ms-align-items: center;
        align-items: center;
    }

    .div_left-flex select{
        border-radius: 0;
        border: 1px solid #b9b9b9;
        color: #b9b9b9;
    }
   
    .div_left-flex input[type="radio"]{
        border: 2px solid #b9b9b9;
    }
    .div_right-flex{
        padding-top: 3px;
    }

    .bodyt-loading{
        position: relative;
        width: 100%;
         height: 220px;
    }
    .loading-tables{
        width: 100%;
        height: 100%;
        position: absolute;
        display: flex;
        align-content: center;
        justify-content: center;
        background-color: rgb(255 255 255);
        -webkit-transition: all .4s;
        -o-transition: all .4s;
        -moz-transition: all .4s;
        transition: all .4s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }

    .component-fade-enter-active, .component-fade-leave-active {
    transition: opacity .3s ease;
    }
    .component-fade-enter, .component-fade-leave-to
    /* .component-fade-leave-active below version 2.1.8 */ {
    opacity: 0;
    }

    .btn-list.btn-action-component button.dropdown-toggle:after{
        display: none;
    }

    @media (max-width: 580px){
        .div_left-flex,.div_right-flex{width: 100%;}
    }

    @media ( max-width: 480px ){
        .btn-list.btn-action-component{
            display: block;
        }
        .btn-list.btn-action-component .btn{
            width: 100%;
            margin-bottom: 15px !important;
        }
    }

    @media (max-width: 380px){
        .div_select_column{width: 100%;}
        .div_right-flex .btn-list{
            margin-bottom: 0 !important;
            margin-right: 0;
        }

        .div_right-flex .btn-list > .btn.btn-danger{
            margin-left: auto !important;
        }
    }
</style>