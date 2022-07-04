<template>
    <div>
        <div class="navbar navbar-expand-md navbar-dark d-print-none">
              <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href=".">
                        <img src="/images/icons/logo-white.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image">
                    </a>
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    <a href="#" class="nav-link px-0 hide-theme-dark" title="" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Enable dark mode">
                        <span class="ti ti-moon"></span>
                    </a>
                    <div class="nav-item dropdown d-none d-md-flex me-3">
                        <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                        <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path><path d="M9 17v1a3 3 0 0 0 6 0v-1"></path></svg>
                        <span class="badge bg-red"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
                        <div class="card">
                            <div class="card-body">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet consectetur exercitationem fugiat in ipsa ipsum, natus odio quidem quod repudiandae sapiente. Amet debitis et magni maxime necessitatibus ullam.
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                         <!--<span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>-->
                        <div class="d-none d-xl-block ps-2">
                            <div>{{user.nombre_usuario}}</div>
                            <div class="mt-1 small text-muted">Administrador</div>
                        </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <!--<a href="#" class="dropdown-item"><span class="ti ti-user-circle me-1 icon-left-user-account"></span> Perfil</a>-->
                        <div class="dropdown-divider"></div>
                            <button href="#" @click="logout" class="dropdown-item"><span class="ti ti-logout me-1 icon-left-user-account"></span> Salir</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-expand-md">
            <div class="collapse navbar-collapse header-menu" id="navbar-menu">
            <div class="navbar navbar-light">
                <div class="container-xl">
                <ul class="navbar-nav">
                    <li class="nav-item" :class="{'active': this.$route.name == 'Home' }">
                        <router-link class="nav-link" :to="{name:'Home'}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="ti ti-home-2"></i>
                            </span>
                            <span class="nav-link-title">
                                Inicio
                            </span>
                        </router-link>
                    </li>
                    <li class="nav-item dropdown" :class="{'active': this.$route.matched.length != 0 && this.$route.matched[0].name == 'Operation' }">
                        <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="ti ti-briefcase"></i>
                            </span>
                            <span class="nav-link-title">
                            Operación
                            </span>
                        </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <router-link class="dropdown-item" :class="{'active': this.$route.name == 'OpFacturasIndex' }" :to="{ name: 'OpFacturasIndex'}">Facturas</router-link>
                                   <router-link class="dropdown-item" :class="{'active': this.$route.name == 'OpProveedoresIndex' }" :to="{ name: 'OpProveedoresIndex'}">Proveedores</router-link>
                                <div class="dropend">
                                    <button class="dropdown-item dropdown-toggle" type="buton" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" :class="{'active': this.$route.matched.length > 1 && this.$route.matched[1].name == 'OpConfiguacion' }">
                                       Configuración
                                    </button>
                                    <div class="dropdown-menu">
                                        <router-link :to="{ name:'ConfigProveedoresIndex' }" class="dropdown-item" :class="{'active':this.$route.matched.length > 2 &&  this.$route.matched[2].name == 'OpConfigProveedoresIndex' }">Gestión Proveedores</router-link>
                                        <router-link :to="{ name:'ConfigFacturaCreate' }" class="dropdown-item" :class="{'active': this.$route.name == 'ConfigFacturaCreate' }">Carga Manual de Movimientos</router-link>
                                        <div class="dropend">
                                            <button class="dropdown-item dropdown-toggle" type="buton" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" :class="{'active':this.$route.matched.length > 2 && this.$route.matched[2].name == 'OpCargaMasiva' }">
                                            Carga Masiva
                                            </button>
                                            <div class="dropdown-menu">
                                                <router-link class="dropdown-item" :to="{ name: 'SubirProveedores' }" :class="{'active': this.$route.name == 'SubirProveedores' }">Proveedores</router-link>
                                                <router-link class="dropdown-item" :to="{ name: 'SubirFacturas' }" :class="{'active': this.$route.name == 'SubirFacturas' }">Facturas</router-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-archive"></i> 
                        </span>
                        <span class="nav-link-title">
                        Control
                        </span>
                    </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="ti ti-checkbox"></i> 
                            </span>
                            <span class="nav-link-title">
                            Validación
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="ti ti-report"></i> 
                            </span>
                            <span class="nav-link-title">
                            Reporting
                            </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown" :class="{'active': this.$route.matched.length != 0 && this.$route.matched[0].name == 'Configuacion' }">
                        <button class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="ti ti-settings"></i>
                            </span>
                            <span class="nav-link-title">
                                Configuración
                            </span>
                        </button>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <router-link class="dropdown-item" :to="{ name:'PaisesIndex' }"  :class="{'active':this.$route.matched.length > 1 &&  this.$route.matched[1].name == 'Paises' }">Gestión Paises</router-link>
                                    <div class="dropend">
                                        <button class="dropdown-item dropdown-toggle" type="buton" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" :class="{'active':this.$route.matched.length > 1 &&  this.$route.matched[1].name == 'Monedas' }">
                                           Gestión Monedas
                                        </button>
                                        <div class="dropdown-menu">
                                            <router-link class="dropdown-item" :to="{ name: 'MonedasIndex' }" :class="{'active':this.$route.matched.length > 1 &&  this.$route.matched[1].name == 'Monedas' && this.$route.matched[2].name != 'MonedasCambios' && this.$route.matched[2].name != 'TazasCambios' }">Monedas</router-link>
                                            <router-link class="dropdown-item" :to="{ name: 'MonedasCambiosIndex' }" :class="{'active':this.$route.matched.length > 2 && ( this.$route.matched[2].name == 'MonedasCambios' || this.$route.matched[2].name == 'TazasCambios' ) }">Tipos de Cambios</router-link>
                                        </div>
                                    </div>
                                    <router-link class="dropdown-item" :to="{ name:'EmpresasIndex' }" :class="{'active':this.$route.matched.length > 1 &&  this.$route.matched[1].name == 'Empresas' }">Gestión Empresas</router-link>
                                    <router-link class="dropdown-item" :to="{ name:'CecosIndex' }" :class="{'active':this.$route.matched.length > 1 &&  this.$route.matched[1].name == 'Cecos' }">Gestión Cecos</router-link>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                </div>
            </div>
            </div>
      </div>
    </div>
</template>
<script>
export default {
    name: 'HeaderComponent',
    data(){
        return {
            user: {
                nombre_usuario: ''
            }
        }
    },
    beforeCreate(){
        this.$nextTick(async function () {
           if( this.user.nombre_usuario == '' ){
                await this.axios.get('user').then(response => {
                    this.user = response.data.user;
                }).catch(error => {
                    console.log(error.response)
                });
           }
           console.log(this.$route);
        }) 
    },
    methods: {
        async logout(){
            await this.axios.post('logout').then(response => {
                this.$store.dispatch('auth/logout');
            }).catch(error => {
                console.log(error.response)
            });
        }
    }
};
</script>
<style>
    .navbar{
        height: 66px;
    }

    .navbar.navbar-dark .btn-list .btn{
        color: #e6e7e9;
        background-color: transparent;
        border: 1px solid rgba(255, 255, 255, 0.3);
        font-size: 15px;
        font-weight: 500;
    }

    .navbar.navbar-dark .btn-list .btn:hover{
        background-color: #FFC000;
        color: #1e293b;
        font-weight: 600;
    }

    .navbar.navbar-dark .btn-list .btn span{
        font-size: 17px;
    }

    .header-menu .navbar li.nav-item .nav-link{
        font-size: 18px;
        font-weight: 500;
        line-height: 1.4;
    }

    .header-menu .navbar li.nav-item .nav-link .nav-link-icon{
        height: auto;
        width: auto;
        opacity: 1;
        font-size: 21px;
        margin-right: 0.5rem;
    }

    .header-menu .navbar-light .nav-item.active::after{
        bottom: -0.59rem;
    }

    .icon-left-user-account{
        font-size: 16px;
        line-height: 1;
    }
    

    @media( min-width: 991px ){
        .btn-items-md-flex{display: flex !important;}
        .navbar-expand-md .navbar-toggler{display: none;}
    }
</style>