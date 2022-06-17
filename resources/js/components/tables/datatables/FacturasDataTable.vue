<template>
    <tbody>
        <tr v-for="(item, index) in data" :key="index">
            <td>
                <input class="form-check-input m-0 align-middle" v-model="getId" type="radio"  name="id" aria-label="Select invoice" style="border: 1px solid rgb(1 5 12 / 34%);cursor:pointer;" :value="item.id_factura">
            </td>
            <td>
                <span class=""> {{ item.nombre_proveedor }} - {{ item.nit_proveedor }}</span>
            </td>
            <td>
                <span class="" > {{ item.corto_ceco }}</span>
            </td>
            <td>
                <span class="" > {{ item.nombre }}</span>
            </td>
            <td>
                <span class="" > {{ item.id_factura_erp }}</span>
            </td>
            <td>
                <span class="" > {{ item.fecha_factura }}</span>
            </td>
            <td>
                <span class="" > {{ item.fecha_vencimiento }}</span>
            </td>
            <td>
                <span class="" > {{ item.monto_factura }}</span>
            </td>
             <td>
                <span class="" > {{ item.descripcion_factura }}</span>
            </td>
        </tr>
    </tbody>
</template>

<script>
export default {
    name: 'FacturasTableComponent',
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