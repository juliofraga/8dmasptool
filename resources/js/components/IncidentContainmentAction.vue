<template>
    <div class="container">
        <breadcrumb-component
            :itens="{
                text:['Incidentes', 'Ações de Contenção'],
                num: '2'
            }"
        ></breadcrumb-component>
        <orientation-component
            :sentence="{
                etapa: '3', 
                mensagem: 'Nessa etapa você implementará medidas temporárias e imediatas para conter o problema identificado, evitando que ele continue a afetar o cliente, o processo ou o produto até que uma solução definitiva seja implementada.'
            }"
        ></orientation-component>
        <search-component 
            title="Áreas" 
            :buttons=" {
                add: {
                    show: true,
                    type: 'modal',
                    modalId: '#modalAdicionarAcaoContencao'
                },
                search: {
                    show: false,
                    type: '',
                    fields: []
                },
                clear: {
                    show: false,
                    type: ''
                }
            }" 
            placeholder=""
            classSearch="containmentAction"
        ></search-component>
        <alert-component type="danger" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'error'"></alert-component>
        <alert-component type="success" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'success'"></alert-component>
        <div class="form-group mt-2">

        </div>
        <div class="row mb-3 mt-4">
            <div class="col-sm-2 mt-3">
                <button type="button" class="btn btn-info texto_branco w-100" @click="save()" id="btnSave">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                        <path d="M11 2H9v3h2z"/>
                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                    </svg>
                    Salvar
                </button>
            </div>
            <div class="col-sm-2 mt-3">
                <button type="button" class="btn btn-success texto_branco w-100" @click="saveContinue()" id="btnSaveContinue">
                    Salvar & Continuar
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-skip-forward" viewBox="0 0 16 16">
                        <path d="M15.5 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V8.752l-6.267 3.636c-.52.302-1.233-.043-1.233-.696v-2.94l-6.267 3.636C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696L7.5 7.248v-2.94c0-.653.713-.998 1.233-.696L15 7.248V4a.5.5 0 0 1 .5-.5M1 4.633v6.734L6.804 8zm7.5 0v6.734L14.304 8z"/>
                    </svg>
                </button>
            </div>
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
            <div class="col-sm-2 mt-3">
                <button type="button" class="btn btn-warning w-100" @click="cancel()"  id="btnCancel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                    Cancelar
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
                urlBase: utils.API_URL + '/api/v1/incident',
                urlUser: utils.API_URL + '/api/v1/user',
                continueForward: false
            }
        },
        methods: {
            saveContinue() {
                this.save();
                setTimeout(() => {
                    if (this.continueForward == true) {
                        this.next();
                    }
                }, 2000); 
            },
            save() {

            },
            previous() {
                window.location.href = utils.API_URL + '/admin/incidente/time/' + this.visualid
            },
            next() {
                window.location.href = utils.API_URL + '/admin/incidente/causa-raiz/' + this.visualid
            },
            cancel() {

            }
        },
        mounted() {

        }
    }
</script>
