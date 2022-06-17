<template>
    <tbody>
        <tr v-for="(item, index) in data" :key="index">
            <td>
                <input class="form-check-input m-0 align-middle" v-model="getId" type="radio"  name="id" aria-label="Select invoice" style="border: 1px solid rgb(1 5 12 / 34%);cursor:pointer;" :value="item.id_moneda">
            </td>
            <td>
                <span class=""> {{ item.nombre_pais }}</span>
            </td>
            <td>
                <span class="" > {{ item.nombre_moneda }}</span>
            </td>
            <td>
                <span class="" > {{ item.abreviatura }}</span>
            </td>
        </tr>
    </tbody>
</template>

<script>

export default {
    name: 'MonedasTableComponent',
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