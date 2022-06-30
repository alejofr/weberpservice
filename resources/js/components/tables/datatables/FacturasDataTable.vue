<template>
    <tbody>
        <tr v-for="(item, index) in data" :key="index">
            <td>
                <input class="form-check-input m-0 align-middle" v-model="getId" type="radio"  name="id" aria-label="Select invoice" style="border: 1px solid rgb(1 5 12 / 34%);cursor:pointer;" :value="item.id_factura">
            </td>
            <td>
                <span class="ti ti-clipboard-list fs-2"> </span>
            </td>
            <td>
               
                <button class="btn semaforo-btn align-text-top" data-bs-toggle="dropdown" aria-expanded="false" :class="{'btn-danger': item.status == 'BORRADOR', 'btn-success': item.status == 'PUBLICADO' }" :title="item.status" v-title ></button>
               
            </td>
            <td>
                <span class="" >  </span>
            </td>
            <td>
                <span class="" > {{ item.ceco }}</span>
            </td>
            <td>
                <span class="" > {{ item.proveedor }}</span>
            </td>
            <td>
                <span class="" > {{ item.nombre_proveedor }}</span>
            </td>
            <td>
                <span class="" > {{ item.no_factura }}</span>
            </td>
             <td>
                <span class="" > {{ item.fecha_factura }}</span>
            </td>
            <td>
                <span class="" > {{ item.fecha_vencimiento }}</span>
            </td>
             <td>
                <span class="" > ${{ item.total_factura }}</span>
            </td>
             <td>
                <span class="" > ${{ item.por_pagar }}</span>
            </td>
             <td>
                <span class="" > {{ item.divisa }}</span>
            </td>
            <td>
                <span class="" > {{ item.tc }}</span>
            </td>
             <td>
                <span class="" > ${{ item.total_mn }}</span>
            </td>
             <td>
                <span class="" > {{ item.descripcion_factura }}</span>
            </td>
             <td>
                <span class="" > {{ item.contrato }}</span>
            </td>
             <td>
                <span class="" > {{ item.bolsa}}</span>
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
<style>
    .semaforo-btn{
        border-radius: 50%;
        padding: 10px;
    }
</style>