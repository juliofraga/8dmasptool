<template>
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li v-for="i, key in itens.text" :key="key" :class="key == itens.num - 1 ? 'breadcrumb-item active' : 'breadcrumb-item'">
                    {{ i }} 
                </li>
            </ol>
        </nav>
        <hr class="divisor_horizontal">
    </div>
</template>

<script>
    export default {
        props: ['itens']
    }
</script>
