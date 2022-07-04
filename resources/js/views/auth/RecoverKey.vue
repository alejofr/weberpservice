<template>
    <div class="w-100 h-100 img-size-0">
        <div class="container h-100" >
            <div class="page-vzlc w-100 h-100">
                <div class="auth-page">
                    <component :is='activeComponent' v-bind:alert="alert"></component>
                    <div class="forn_auth">
                        <form class="form-lg_auth" method="POST" @submit.prevent="recuperar($event)" name="formLogin">
                                <div class="form-group mb-3">
                                    <input type="email" v-model="user.email" name="email" v-validate="'required|email'" placeholder="Correo Electrónico"  class="form-control _input_style-0" :class="{'is-invalid': errors.first('email')}">
                                    <div v-if="errors.has('email')" class="invalid-feedback">{{errors.first('email')}}</div>
                                </div>
                                <div class="w-100 mb-3">
                                    <button :type="typeButton" id="btnSubmit" class="btn_style_0 fw-bold mt-3 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-loader me-2 ti-spin"></i> Recuperar Contraseña
                                    </button>
                                </div>
                                   <div class="w-100 mb-3">
                                        <router-link class="btn-light btn fw-bold mt-3 d-flex align-items-center justify-content-center" :to="{name:'Login'}">
                                            <i class="ti ti-loader me-2 ti-spin"></i> Iniciar Sessión
                                        </router-link>
                                </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'RecoverKey',
    data() {
        return {
            user: {
                email:'',
                password: '',
                remenber: false
            },
            pass: 'ti ti-eye',
            typePass: 'password',
            showAlert: false,
            alert: {
                msg: '',
                clss: '' 
            },
            activeComponent: '',
            typeButton: 'submit'
        }
    },
    components: {
        alert: () => import(/* webpackChunkName: "AlertMessageComponent" */'../../components/AlertMessageComponent.vue')    
    },
    methods: {
        recuperar(){
           // this.typeButton = 'button';
            this.$validator.validate().then(valid => {
                if (valid) {
                    
                }
            });
           
            
        },
    }
}
</script>