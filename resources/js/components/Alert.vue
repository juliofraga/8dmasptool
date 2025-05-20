<template>
    <div :class="style" role="alert">
        {{ title }}
        <div v-if="type =='danger'">
            <hr>
            <p>{{ details.mensagem }}</p>
            <li v-for="d, key in details.dados" :key="key">
                {{ d[0]}}
            </li>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['type', 'title', 'details'],
        computed: {
            style() {
                return 'alert alert-' + this.type;
            }
        }
    }
</script>
