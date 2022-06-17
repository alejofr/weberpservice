<template>
    <tbody>
        <tr v-for="(item, index) in data" :key="index">
            <td>
                <input class="form-check-input m-0 align-middle" v-model="getId" type="radio"  name="id" aria-label="Select invoice" style="border: 1px solid rgb(1 5 12 / 34%);cursor:pointer;" :value="item.id_pais">
            </td>
            <td>
                <span class=""> {{ item.id_pais_erp }}</span>
            </td>
            <td>
                <span class="" > {{ item.nombre }}</span>
            </td>
            <td>
                <span class="" > {{ item.nacionalidad_pais }}</span>
            </td>
        </tr>
    </tbody>
</template>

<script>

export default {
    name: 'PaisesTableComponent',
    props: ['data'], 
    data(){
        return {
            getId: [],
        }
    },
    watch: {
        getId: function (){
            this.$emit('getId', this.getId)
        }
    }
}
</script>