<template>
    <div class="mt-3" v-if="(Array.isArray(dados) && dados.length === 0)">
        <alert-component tipo="warning" titulo="Não foram encontratos resultados"></alert-component>
    </div>
    <div class="mt-2" v-else>
        <alert-component tipo="danger" :detalhes="mensagem" :titulo="titulo" v-if="status == 'erro'"></alert-component>
        <alert-component tipo="success" :detalhes="mensagem" :titulo="titulo" v-if="status == 'sucesso'"></alert-component>
        <div class="row mt-3">
            <div v-for="t, key in titulos" :key="key" :class="`col-sm-${t.length}`" >
                <b v-if="t.type != 'buttonModal' && t.length != 'hidden'">{{ t.title }}</b>
            </div>
        </div>
        <hr>
        <div class="row mt-4 border-bottom resultado-consultas-row" v-for="obj, chave in filteredData" :key="chave">
            <div :class="`col-sm-${titulos[chaveValor].length}`" v-for="valor, chaveValor in obj" :key="chaveValor">
                <span 
                    v-if="
                        titulos[chaveValor].type == 'text' && 
                        titulos[chaveValor].length != 'hidden' && 
                        chaveValor != 'profile'
                    ">
                     {{ valor }}
                </span>
                <span v-if="chaveValor == 'profile'"> {{ valor | formatProfile }}</span>
                <span v-if="titulos[chaveValor].type == 'datetime' && titulos[chaveValor].length != 'hidden'"> {{ valor | formatDateTime }}</span>
                <span v-if="titulos[chaveValor].type == 'ativoInativo' && titulos[chaveValor].length != 'hidden'"> {{ valor | formatStatus }}</span>
                <button v-if="titulos[chaveValor].type == 'buttonModal' && titulos[chaveValor].length != 'hidden'" class="btn btn-outline-dark w-100" data-bs-toggle="modal" :data-bs-target="titulos[chaveValor].modalId" @click="setStore(obj)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                    </svg>
                    {{ titulos[chaveValor].title }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['titulos', 'dados', 'status', 'titulo', 'mensagem'],
        methods: {
            setStore(obj) {
                this.$store.state.item = obj;
            }
        },
        computed: {
            filteredData(){
                if (Array.isArray(this.dados)) {
                    let campos = Object.keys(this.titulos);
                    let dadosFiltrados = [];
                    this.dados.map((item, chave) => {
                        let itemFiltrado = {};
                        campos.forEach(campo => {
                            itemFiltrado[campo] = item[campo]
                        });
                        dadosFiltrados.push(itemFiltrado);
                    });
                    return dadosFiltrados;
                }
            }
        },
        mounted() {
            
        }
    }
</script>
