<template>
    <div class="container">
        <h3 style="text-align: justify;"><b>Etapa {{ sentence.etapa }}:</b> {{ sentence.mensagem }}</h3>
    </div>
</template>

<script>
    export default {
        props: ['sentence'],
    }
</script>
