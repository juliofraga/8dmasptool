<template>
    <div class="container">
        <breadcrumb-component
            :itens="{
                text:['Incidentes', 'Causa Raiz'],
                num: '2'
            }"
        ></breadcrumb-component>
        <orientation-component
            :sentence="{
                etapa: '4', 
                mensagem: 'Nessa etapa você deverá identificar por que o problema ocorreu (causa raiz) e por que não foi detectado antes de chegar ao cliente ou causar impacto.'
            }"
        ></orientation-component>
        <div class="row mb-3 mt-4">
            <div class="col-sm-2 mt-3">
                <button type="button" class="btn btn-dark texto_branco w-100" @click="previous()" id="btnPrevious">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-skip-backward" viewBox="0 0 16 16">
                        <path d="M.5 3.5A.5.5 0 0 1 1 4v3.248l6.267-3.636c.52-.302 1.233.043 1.233.696v2.94l6.267-3.636c.52-.302 1.233.043 1.233.696v7.384c0 .653-.713.998-1.233.696L8.5 8.752v2.94c0 .653-.713.998-1.233.696L1 8.752V12a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5m7 1.133L1.696 8 7.5 11.367zm7.5 0L9.196 8 15 11.367z"/>
                    </svg>
                    Anterior
                </button>
            </div>
            <div class="col-sm-2 mt-3">
                <button type="button" class="btn btn-secondary texto_branco w-100" @click="next()" id="btnNext">
                    Próximo
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-skip-forward" viewBox="0 0 16 16">
                        <path d="M15.5 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V8.752l-6.267 3.636c-.52.302-1.233-.043-1.233-.696v-2.94l-6.267 3.636C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696L7.5 7.248v-2.94c0-.653.713-.998 1.233-.696L15 7.248V4a.5.5 0 0 1 .5-.5M1 4.633v6.734L6.804 8zm7.5 0v6.734L14.304 8z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import * as utils from '../utils/functions';
    export default {
        props: ['user', 'visualid'],
        data() {
            return {
                status: '',
                feedbackTitle: '',
                feedbackMessage: '',
                urlBase: utils.API_URL + '/api/v1/incident/rootcausepotential',
                urlUser: utils.API_URL + '/api/v1/user',
            }
        },
        methods: {
            previous() {
                window.location.href = utils.API_URL + '/admin/incidente/acao-contencao/' + this.visualid
            },
            next() {
                window.location.href = utils.API_URL + '/admin/incidente/acao-corretiva-permanente/' + this.visualid
            },
        },
        mounted() {
            
        }
    }
</script>
