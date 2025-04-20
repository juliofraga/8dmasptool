<template>
    <div :class="style" role="alert">
        {{ titulo }}
        <div v-if="tipo =='danger'">
            <hr>
            <p>{{ detalhes.mensagem }}</p>
            <li v-for="d, key in detalhes.dados" :key="key">
                {{ d[0]}}
            </li>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['tipo', 'titulo', 'detalhes'],
        computed: {
            style() {
                return 'alert alert-' + this.tipo;
            }
        }
    }
</script>
