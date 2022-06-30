window.Vue = require('vue').default;
import VueRouter from 'vue-router';
import axios from 'axios'
import VueAxios from 'vue-axios'
import VeeValidate, { Validator } from "vee-validate";
import es from 'vee-validate/dist/locale/es'
import Validate from "./validation"

import { routes } from './router/routes';
import App from './App.vue';
import store  from './store';

Vue.use(VueAxios, axios);
axios.defaults.withCredentials = true;
axios.defaults.baseURL = process.env.MIX_APP_API_URL;
Vue.use(VueRouter);
import vTitle from 'vuejs-title'
Vue.use(vTitle)

Vue.use(VeeValidate, {
    classes: true,
	classNames: {
		valid: "is-valid",
		invalid: "is-invalid",
	},
    mode: 'passive',
    events: 'change|blur|keyup',
});

VeeValidate.setMode('passive');

VeeValidate.Validator.extend('customAlpha', {
    getMessage: (campo, args) => {
		return "El campo " + campo + " solo debe contener letras "( args == 'true' ) ? +"y no espacios": +"";
	},
	validate: (valor, args) => {
        //return ( args == 'true' && /^[A-Z]+$/i.test(valor) ) ? true : ( args == 'false'  && /^[a-zA-Z ]+$/.test(valor) ) ? true : false;
        return true
	},
})

Validator.localize('es', es);
Validator.localize('es', Validate);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

router.beforeEach((to, from, next) => {
    document.title = process.env.MIX_APP_NAME +' - '+ to.meta.title;
    console.log(store.getters['tableadmin/getRequest'])
    const requestStoreTable =  { ...store.getters['tableadmin/getRequest'] };

    if ( requestStoreTable.url != '' && Object.keys(requestStoreTable.params).length != 0 && Object.keys(to.query).length != 0 ){
        let query = to.query;
        console.log(query);
        console.log("paso por aqui")
    
        if( query.hasOwnProperty('page') ){
            requestStoreTable.params.page = parseInt(query.page)
            delete query.page
        }else{
            requestStoreTable.params.page = 1
        }

        requestStoreTable.params.query = query;
        store.dispatch('tableadmin/initTable', requestStoreTable);
    }else if( Object.keys(to.query).length === 0 ){
        if( requestStoreTable.url != '' && Object.keys(requestStoreTable.params).length != 0 )
            store.dispatch('tableadmin/resetTable');
    }
  
    next();
})

const app = new Vue({
    el: '#app',
    router: router,
    store: store,
    render: h => h(App),
})
