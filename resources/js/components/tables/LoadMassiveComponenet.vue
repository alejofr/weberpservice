<template>
    <div class="card">
        <div class="card-body border-bottom py-3 " style="border-radius: 3px 3px 0 0;position:relative;">
            <div class="div_action_table div_flex_w ">
                <div class="ms-auto text-muted div_right-flex">
                    <div class="btn-list btn-action-component mt-2">
                        <button class="btn btn-outline-primary" @click="openModal" type="button">
                            <i class="ti ti-plus me-1"></i>
                            Subir Excel
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-download me-1"></i>
                                Estructura de Tabla
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <button type="button" class="dropdown-item" v-for="(item, index) in json" :key="index" :id="index" @click="downloadsEstructExcel($event)">
                                   {{item.name}}
                                </button>
                            </div>
                        </div>
                        <btn-volver-component></btn-volver-component>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th v-for="(column, index) in columns.th" :key="index">{{column.name}}</th>
                        <th>Cargado</th>
                        <th>Mensaje</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in dataTable" :key="index">
                        <td v-for="(value, key, i) in json[0].data[0]" :key="i">
                            <span class=""> {{ item[key] }}</span>
                        </td>
                        <td>
                            <span class="btn badge-status cl1 hover-cl0" :class="{'bg-success': item.status == 200, 'bg-danger': item.status != 200 }">
                                <p v-if="item.status == 200">Si</p>
                                <p v-else-if="item.status != 200">No</p>
                            </span>
                        </td>
                        <td>
                            <span class=""> {{ item.message }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
         <!-- Modal Subir Excel -->
        <div class="modal modal-blur fade" :class="{'show': show == true}" id="modal-report" tabindex="-1" v-show="show" style="display:block;" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <transition name="component-fade" mode="out-in">
                        <keep-alive>
                            <component :is='compLoader'></component>
                        </keep-alive>
                    </transition>
                    <div class="modal-header">
                        <h5 class="modal-title">Subir Execel</h5>
                        <button type="button" class="btn-close" @click="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <transition name="component-fade" mode="out-in">
                            <keep-alive>
                                    <component :is='componentIsModal' v-bind:alert="alert" :componentLoader="true" :styles="styleComponent"></component>
                            </keep-alive>
                        </transition>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <div class="form-label">Carga un Archivo Excel</div>
                                    <input type="file" id="fileExcel" class="form-control" accept=".xlsx, .xls" @change="fileExcel($event)">
                                    <p class="mt-3 form-message">«archivo excel» debe seguir la estructura, propocionada en <strong>Estructura de tabla</strong>. el archivo excel debe ser con el formato «.xlsx ó .xls»</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light link-secondary" @click="closeModal" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <div class="ms-auto col-auto">
                            <div class="btn-list">
                                <button  class="btn btn-primary" @click="subir" data-bs-dismiss="modal">
                                    <i class="ti ti-plus me-1"></i>
                                    Cargar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import BtnVolverComponent from '../BtnVolverComponent.vue';

const loaderWhite = () => import('../LoaderWhiteComponent.vue')
const AlertMessageComponent = () => import(/* webpackChunkName: "AlertMessageComponent" */'../AlertMessageComponent.vue');

import exportFromJSON from 'export-from-json'
import XLSX from "xlsx";


export default {
    components: { 
        BtnVolverComponent
    },
    name: 'TableAdminComponent',
    props: ['columns', 'accion', 'json'],
    data(){
        return {
            show: false,
            file: null,
            collection: [],
            wb: null,
            defaultIndex: 0,
            data: [],
            dataTable: [],
            componentIsModal: '',
            compLoader: '',
            styleComponent: '',
               alert: {
                msg: '',
                clss: ''
            },
        }
    },
    computed: {
        
    },
    methods: {
        openModal(){
            this.show = true;
        },
        closeModal(){
            this.show = false;
        },
        async subir(){
            console.log(this.data)
            this.compLoader = loaderWhite;
            if( this.accion.create != '' ){
                if( this.data.length != 0 ){
                    await this.axios.post(this.accion.create, { load: this.data }).then(response => {
                        this.dataTable = response.data.results;
                    
                        setTimeout(() => {
                            this.show = false;
                            this.compLoader = '';
                        }, 2000);
                    }).catch(error => {
                        console.log(error.response)
                        console.log(error.response.data)
                    });
                }
            }
        },
        fileExcel(ev){
            this.alert = {
                msg: '',
                clss: ''
            }

            this.componentIsModal = '';

            if ( ev.target.files[0].name.includes(".xls") || ev.target.files[0].name.includes(".xlsx")) {
                const file = ev.target.files[0];
                const reader = new FileReader();
                reader.onload = e => {
                    let data = e.target.result;
                    this.wb = XLSX.read(data, { type: "array" });
                    var sheetNames = this.wb.SheetNames;
                    var worksheet = this.wb.Sheets[sheetNames[this.defaultIndex]]; // Aquí solo leemos la primera hoja
                    var json = XLSX.utils.sheet_to_json(worksheet);
                    this.checkJson(json, ev);
                }

                reader.readAsArrayBuffer(file);
            }else{
                ev.target.value = "";
                this.alert.msg = "Error, el archivo debe ser «.xls» ó «.xlsx»";
                this.alert.clss = "error";

                this.componentIsModal = AlertMessageComponent;
            }
        },

        checkJson(dta = [], e){
            let bol = false;
            this.alert = {
                msg: 'Hubo error en leer el archivo excel, porfavor revisar que sea la extensiones correctas.',
                clss: 'error'
            }

            if( dta.length != 0 ){
                const data = this.json[0].data[0];
                for (const campo in data) {
                    for (let i = 0; i < dta.length; i++) {
                        if( dta[0].hasOwnProperty(campo) ){
                            bol = true;
                        }else{
                            bol = false;
                            this.alert.msg = "Error, de estructura, asegurese de tener la estructura bien definida.";
                            break;
                        }
                        
                    }
                }

                if( dta.length > 500 ){
                    bol = false;
                    this.alert.msg = "Error, el archivo excel, no debe superar en datos mas de 500 filas.";
                }
            }

            if( bol ){
                this.data = this.checkDateExcel(dta);
            }else{
                e.target.value = "";
                this.componentIsModal = AlertMessageComponent;
            }
        },
        checkDateExcel(data = []){
            for (let i = 0; i < data.length; i++) {
                for (const campo in data[i]) {
                    if( campo.includes('fecha') ){
                        data[i][campo] = this.formtDate(data[i][campo])
                    }
                }
            }
            return data;
        },
        formtDate(fechaExcel){
            let date = new Date(Math.round((fechaExcel - (25568 + 1)) * 86400 * 1000));
            return date.toISOString().split('T')[0];
        },
        async downloadsEstructExcel(e){
            let json = this.json
            let id = parseInt(e.target.id);

            exportFromJSON({
                data: json[id].data,
                fileName: ''+json[id].name,
                exportType: exportFromJSON.types.xls,
            })
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