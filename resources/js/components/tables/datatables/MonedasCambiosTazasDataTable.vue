<template>
    <tbody>
        <tr v-for="(item, index) in data" :key="index">
            <td>
                <input class="form-check-input m-0 align-middle" v-model="getId" type="radio"  name="id" aria-label="Select invoice" style="border: 1px solid rgb(1 5 12 / 34%);cursor:pointer;" :value="item.id_cambio_taza">
            </td>
            <td>
                <span class=""> {{ item.nombre_nc }} - {{ item.abreviatura_nc }}</span>
            </td>
            <td>
                <span class=""> {{ item.nombre_divisa }} - {{ item.abreviatura_divisa }}</span>
            </td>
               <td>
                <span class="" > 1 {{ item.abreviatura_divisa }} = {{ item.monto_tc }} {{ item.abreviatura_nc }}</span>
            </td>
             <td>
                <span class="" ></span>
            </td>
            <td>
                <span class="" > {{ item.fecha_editado }}</span>
            </td>
        </tr>
    </tbody>
</template>

<script>

export default {
    name: 'MonedasCambiosTazasDataTable',
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