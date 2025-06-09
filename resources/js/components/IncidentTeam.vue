<template>
    <div class="container">
        <breadcrumb-component
            :itens="{
                text:['Incidentes', 'Time'],
                num: '2'
            }"
        ></breadcrumb-component>
        <orientation-component
            :sentence="{
                etapa: '2', 
                mensagem: 'Nessa etapa você selecionará o time que atuará neste incidente. Você deve também informar quem atuará como o líder da equipe.'
            }"
        ></orientation-component>
        <alert-component type="danger" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'error'"></alert-component>
        <alert-component type="success" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'success'"></alert-component>
        <div class="form-group mt-2">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="leader" name="leader" placeholder="Informe o líder do time*" v-model="leader">
                            <option value="">Selecione...</option>
                            <option v-for="user in usersLeader" :key="user.id" :value="user.id">
                                {{ user.name }}
                            </option>
                        </select>
                        <label class="form-label">Informe o líder do time*</label>
                        <div id="invalidFeedbackInvalidLeader" class="invalid-feedback ">
                            O líder do time é de preenchimento obrigatório.
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="members" name="members" placeholder="Informe os membros do time" v-model="members" multiple style="height: auto;">
                            <option value=""></option>
                            <option v-for="user in usersMembers" :key="user.id" :value="user.id">
                                {{ user.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
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
                <button type="button" class="btn btn-dark texto_branco w-100" @click="backward()" id="btnBack">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-skip-backward" viewBox="0 0 16 16">
                        <path d="M.5 3.5A.5.5 0 0 1 1 4v3.248l6.267-3.636c.52-.302 1.233.043 1.233.696v2.94l6.267-3.636c.52-.302 1.233.043 1.233.696v7.384c0 .653-.713.998-1.233.696L8.5 8.752v2.94c0 .653-.713.998-1.233.696L1 8.752V12a.5.5 0 0 1-1 0V4a.5.5 0 0 1 .5-.5m7 1.133L1.696 8 7.5 11.367zm7.5 0L9.196 8 15 11.367z"/>
                    </svg>
                    Voltar
                </button>
            </div>
            <div class="col-sm-2 mt-3">
                <button type="button" class="btn btn-secondary texto_branco w-100" @click="forward()" id="btnContinue">
                    Continuar
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
                leader: '',
                members: [],
                usersLeader: {data: {}},
                usersMembers: {data: {}},
                continueForward: false
            }
        },
        methods: {
            async idExists() {
                let url = this.urlBase + '/exists/' + this.visualid;
                try {
                    const response = await axios.get(url);
                    return response.data.exists;
                } catch (errors) {
                    if (errors.response && errors.response.status === 500) {
                        this.feedbackTitle = "Erro no servidor";
                        this.status = 'error';
                        this.feedbackMessage = {
                            message: "Desculpe, não conseguimos processar a sua requisição, tente novamente ou entre em contato com a equipe de suporte"
                        };
                    } else {
                        this.feedbackTitle = "Houve um erro";
                        this.status = 'error';
                        this.feedbackMessage = errors;
                    }
                    utils.goToTop();
                    return false;
                }
            },
            loadActiveUsers() {
                let url = this.urlUser + '/all/active';
                axios.get(url)
                    .then(response => {
                        this.usersLeader = response.data;
                        this.usersMembers = response.data;
                        setTimeout(() => {
                            this.feedbackTitle = "";
                            this.status = '';
                            this.feedbackMessage = {};
                        }, 10000);
                    })
                    .catch(errors => {
                        if (errors.response.status == 500) {
                            this.feedbackTitle = "Erro no servidor";
                            this.status = 'error';
                            this.feedbackMessage = {mensagem: "Desculpe, não conseguimos processar a sua requisição, tente novamente ou entre em contato com a equipe de suporte"}
                        } else {
                            this.feedbackTitle = "Houve um erro";
                            this.status = 'error';
                            this.feedbackMessage = errors;
                        }
                    })
            },
            forward() {
                window.location.href = utils.API_URL + '/admin/incidente/acao-contencao/' + this.visualid
            },
            backward() {
                window.location.href = utils.API_URL + '/admin/incidente/' + this.visualid
            },
            cancel() {
                if (this.visualid) {
                    this.loadTeamData();
                    this.loadActiveUsers();
                }
                utils.removeInvalidFeedback(['leader']);
                utils.goToTop();
            },
            loadTeamData() {
                let url = this.urlBase + '/team/' + this.visualid;
                axios.get(url)
                    .then(response => {
                        let users = response.data.users;
                        this.members = users.
                                        filter(obj => obj.pivot && obj.pivot.leader === 0).
                                        map(obj => obj.id);

                        this.leader = users.find(obj => obj.pivot && obj.pivot.leader === 1).id;
                        setTimeout(() => {
                            this.feedbackTitle = "";
                            this.status = '';
                            this.feedbackMessage = {};
                        }, 10000);
                    })
                    .catch(errors => {
                        if (errors.response.status == 500) {
                            this.feedbackTitle = "Erro no servidor";
                            this.status = 'error';
                            this.feedbackMessage = {mensagem: "Desculpe, não conseguimos processar a sua requisição, tente novamente ou entre em contato com a equipe de suporte"}
                        } else {
                            this.feedbackTitle = "Houve um erro";
                            this.status = 'error';
                            this.feedbackMessage = errors;
                        }
                    })
            },
            save() {
                if (utils.fieldsValidate(['leader'], this)) {
                    let formData = this.generateIncidentTeamFormData('save');                    
                    let config = {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            }
                        }
                    let url = this.urlBase + '/storeteam';
                    axios.post(url, formData, config)
                        .then(response => {
                            this.status = 'success';
                            this.feedbackTitle = "Informações registradas com sucesso";
                            this.continueForward = true;
                        })
                        .catch(errors => {
                            this.status = 'error';
                            this.feedbackTitle = "Erro ao salvar informações";
                            this.feedbackMessage = {
                                mensagem: errors.response.data.message,
                                data: errors.response.data.errors
                            };
                        })
                    utils.clearFeedbackMessage(this, 10000);
                    utils.goToTop();
                }
            },
            generateIncidentTeamFormData(type) {
                let formData = new FormData();
                if (type == 'update') {
                    formData.append('_method', 'patch');
                }
                formData.append('leader', this.leader);
                formData.append('members', this.members);
                formData.append('visual_id', this.visualid);
                return formData;
            },
            saveContinue() {
                this.save();
                setTimeout(() => {
                    if (this.continueForward == true) {
                        this.forward();
                    }
                }, 2000);  
            },
        },
        async created() {
            const exists = await this.idExists();
            if (!this.user || !this.visualid || !exists) {
                window.location.replace(utils.API_URL + '/admin/incidentes');
            }
        },
        mounted() {
            this.loadActiveUsers();
            this.loadTeamData();
        }
    }
</script>