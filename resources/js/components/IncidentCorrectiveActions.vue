<template>
    <div class="container">
        <breadcrumb-component
            :itens="{
                text:['Incidentes', 'Ações Corretivas Permanentes'],
                num: '2'
            }"
        ></breadcrumb-component>
        <orientation-component
            :sentence="{
                etapa: '5', 
                mensagem: 'Nessa etapa você deverá identificar, selecionar e implementar uma ou mais ações corretivas eficazes e definitivas que eliminem a causa raiz do problema, impedindo que ele volte a ocorrer.'
            }"
        ></orientation-component>
        <search-component 
            title="Ações Corretivas" 
            :buttons=" {
                add: {
                    show: true,
                    type: 'modal',
                    modalId: '#modalAdicionarAcaoCorretiva'
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
            classSearch="PermanentAction"
        ></search-component>
        <div class="mt-2">
            <alert-component type="danger" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'error'"></alert-component>
            <alert-component type="success" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'success'"></alert-component>
        </div>
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
        <!-- Modal para adicionar Ação Permanente -->
        <modal-component id="modalAdicionarAcaoCorretiva" title="Adicionar Ação de Correção Permanente">
            <template v-slot:conteudo>
                <div class="form-group">
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <select class="form-control" id="category" name="category" placeholder="Categoria*" v-model="category">
                                    <option value="">Selecione...</option>
                                    <option value="Corrective">Corretiva</option>
                                    <option value="Preventive">Preventiva</option>
                                    <option value="Improvement">Melhoria</option>
                                </select>
                                <label class="form-label">Categoria*</label>
                                <div id="invalidFeedbackCategoty" class="invalid-feedback">
                                    Informe a categoria dessa ação permanente.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <select class="form-control" id="type" name="type" placeholder="Type*" v-model="type">
                                    <option value="">Selecione...</option>
                                    <option value="Occurrence">Ocorrência</option>
                                    <option value="Not Detection">Não Detecção</option>
                                </select>
                                <label class="form-label">Type*</label>
                                <div id="invalidFeedbackType" class="invalid-feedback">
                                    Informe o tipo dessa ação permanente.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <textarea class="form-control" id="description" name="description" rows="10" v-model="description" style="height: auto;"></textarea>
                                <label class="form-label">Descrição*</label>
                                <div id="invalidFeedbackDescription" class="invalid-feedback">
                                    Informe a descrição da ação permanente.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="deadline" name="deadline" v-model="deadline" placeholder="Data Limite*">
                                <label class="form-label">Data Limite*</label>
                                <div id="invalidFeedbackDeadline" class="invalid-feedback">
                                    Informe a data limite da ação permanente.
                                </div>
                                <div id="invalidFeedbackInvalidDate" class="invalid-feedback ">
                                    A data informada é menor que a data atual, informe uma data valida.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <select class="form-control" id="userResponsible" name="userResponsible" placeholder="Responsável*" v-model="userResponsible">
                                    <option value="">Selecione...</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.name }}
                                    </option>
                                </select>
                                <label class="form-label">Responsável*</label>
                                <div id="invalidFeedbackResponsible" class="invalid-feedback">
                                    Informe o responsável por esta ação permanente.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <select class="form-control" id="statusAction" name="statusAction" placeholder="Status*" v-model="statusAction">
                                    <option value="">Selecione...</option>
                                    <option value="Not Started">Não iniciado</option>
                                    <option value="In Progress">Em andamento</option>
                                    <option value="Canceled">Cancelado</option>
                                    <option value="On hold">Em espera</option>
                                    <option value="Finished">Concluído</option>
                                </select>
                                <label class="form-label">Status*</label>
                                <div id="invalidFeedbackStatus" class="invalid-feedback">
                                    Informe o status dessa ação permanente.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success texto_branco" @click="save()">Salvar</button>
            </template>
        </modal-component>
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
                description: '',
                userResponsible: '',
                statusAction: '',
                category: '',
                type: '',
                deadline: '',
                urlBase: utils.API_URL + '/api/v1/incident/correctiveactions',
                urlUser: utils.API_URL + '/api/v1/user',
                users: {data: {}},
            }
        },
        methods: {
            save() {
                const currentDate = new Date(utils.returnCurrentDate());
                let dateDeadline = new Date(this.deadline);
                if (dateDeadline < currentDate) {
                    document.getElementById('deadline').classList.add('is-invalid');
                    document.getElementById('invalidFeedbackInvalidDate').style.display = 'block';
                    document.getElementById('invalidFeedbackDeadline').style.display = 'none';
                    return;
                } else {
                    if (document.getElementById('invalidFeedbackDeadline').classList.contains('is-invalid')) {
                        document.getElementById('invalidFeedbackDeadline').style.display = 'block';
                    }
                    document.getElementById('invalidFeedbackInvalidDate').style.display = 'none';
                }
                if (utils.fieldsValidate(['description', 'statusAction', 'userResponsible', 'category', 'type', 'deadline'], this)) {
                    let formData = new FormData();
                    formData.append('description', this.description);
                    formData.append('users_id', this.userResponsible);
                    formData.append('status', this.statusAction);
                    formData.append('incidents_id', this.visualid);
                    formData.append('type', this.type);
                    formData.append('category', this.category);
                    formData.append('deadline', this.deadline);

                    let config = {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }

                    let url = this.urlBase + '/store';
                    axios.post(url, formData, config)
                        .then(response => {
                            this.status = 'sucesso';
                            this.feedbackTitle = "Ação corretiva permanente adicionada com sucesso";
                            utils.closeModal('modalAdicionarAcaoCorretiva');
                            //this.loadActionList();
                            this.cleanAddCorrectiveActionsFormData();
                        })
                        .catch(errors => {
                            this.status = 'error';
                            this.feedbackTitle = "Erro ao adicionar ação corretiva permanente";
                            utils.closeModal('modalAdicionarAcaoCorretiva');
                            this.feedbackMessage = {
                                mensagem: errors.response.data.message,
                                dados: errors.response.data.errors
                            };
                        })
                }
            },
            cleanAddCorrectiveActionsFormData() {
                this.description = '';
                this.userResponsible = '';
                this.statusAction = '';
                this.type = '';
                this.category = '';
                this.deadline = '';
            },
            previous() {
                window.location.href = utils.API_URL + '/admin/incidente/causa-raiz/' + this.visualid
            },
            next() {
                window.location.href = utils.API_URL + '/admin/incidente/verificar-eficacia/' + this.visualid
            },
            loadActiveUsers() {
                let url = this.urlUser + '/all/active';
                axios.get(url)
                    .then(response => {
                        this.users = response.data;
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
        },
        mounted() {
            this.loadActiveUsers();
        }
    }
</script>
