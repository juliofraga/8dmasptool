<template>
    <div class="container">
        <breadcrumb-component
            :itens="{
                text:['Incidentes', 'Novo'],
                num: '2'
            }"
        ></breadcrumb-component>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {

        }
    }
</script>