<template>
    <div class="wrapper">
        <header>
            <transition name="component-fade" mode="out-in">
                <keep-alive>
                      <component :is='headerIs'></component>
                </keep-alive>
            </transition>
        </header>
        <div class="page-wrapper">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
const HeaderComponent =  () => import(/* webpackChunkName: "HeaderComponent" */'./components/HeaderComponent.vue');

export default {
    name: 'WeberpserviceApp',
    computed: {
        headerIs(){
            return HeaderComponent
        }
    },
    methods: {
        
    },
};
</script>
<style>
.component-fade-enter-active, .component-fade-leave-active {
    transition: opacity .3s ease;
}
.component-fade-enter, .component-fade-leave-to{
    opacity: 0;
}
</style>