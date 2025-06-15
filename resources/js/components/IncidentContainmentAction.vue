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
        <div class="mt-2">
            <alert-component type="danger" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'error'"></alert-component>
            <alert-component type="success" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'success'"></alert-component>
        </div>
        <div v-if="Object.keys(actions.data).length > 0">
            <list-component
                :title="{
                    id: {title: 'ID', length:'hidden', type:'text'},
                    description: {title: 'Descrição', length: '7', type:'text'},
                    status: {title: 'Status', length: '1', type:'status-incident'},
                    created_at: {title: 'Data de Criação', length: '2', type: 'datetimestamp'},
                    user_name: {title: 'Responsável', length: '1', type:'text'},
                    editar: {title: 'Editar', length: '1', type: 'buttonModal', modalId: '#modalAtualizarAcaoContencao'},
                    user_id: {title: 'User ID', length: 'hidden', type:'text'},
                    updated_at: {title: 'Atualização', length: 'hidden', type:'text'}
                }" 
                :data="actions.data"
                :status="status"
                :feedbackMessage="feedbackMessage"
                :feedbackTitle="feedbackTitle"
            ></list-component>
        </div>
        <div v-else-if="loaded === true">
            <no-itens-component></no-itens-component>
        </div>
        <div v-else-if="loaded === false">
            <spinner-component></spinner-component>
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
        <!-- Modal para adicionar Ação de Contenção -->
        <modal-component id="modalAdicionarAcaoContencao" title="Adicionar Ação de Contenção">
            <template v-slot:conteudo>
                <div class="form-group">
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <textarea class="form-control" id="description" name="description" rows="10" v-model="description" style="height: auto;"></textarea>
                                <label class="form-label">Descrição</label>
                                <div id="invalidFeedbackDescription" class="invalid-feedback">
                                    Informe a descrição da ação de contenção.
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
                                    Informe o responsável por esta ação de contenção.
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
                                    Informe o status dessa ação de contenção.
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
        <!-- Modal para editar Ação de Contenção -->
        <modal-component id="modalAtualizarAcaoContencao" title="Atualizar Ação de Contenção">
            <template v-slot:conteudo>
                <div class="form-group">
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <textarea class="form-control" id="descriptionUpdate" name="descriptionUpdate" rows="10" style="height: auto;" v-model="$store.state.item.description">{{ $store.state.item.description }}</textarea>
                                <label class="form-label">Descrição</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <select class="form-control" id="userResponsibleUpdate" name="userResponsibleUpdate" placeholder="Responsável*" v-model="$store.state.item.user_id">
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.name }}
                                    </option>
                                </select>
                                <label class="form-label">Responsável*</label>
                                <div id="invalidFeedbackResponsible" class="invalid-feedback">
                                    Informe o responsável por esta ação de contenção.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <select class="form-control" id="statusActionUpdate" name="statusActionUpdate" placeholder="Status*" v-model="$store.state.item.status">
                                    <option value="Not Started">Não iniciado</option>
                                    <option value="In Progress">Em andamento</option>
                                    <option value="Canceled">Cancelado</option>
                                    <option value="On hold">Em espera</option>
                                    <option value="Finished">Concluído</option>
                                </select>
                                <label class="form-label">Status*</label>
                                <div id="invalidFeedbackStatus" class="invalid-feedback">
                                    Informe o status dessa ação de contenção.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <label class="form-label"><i>Data de criação: {{ $store.state.item.created_at | formatDateTimeStamp}}</i></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="form-label"><i>Última atualização: {{ $store.state.item.updated_at | formatDateTimeStamp}}</i></label>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-success texto_branco" @click="update()">Atualizar</button>
                <button type="button" class="btn btn-danger texto_branco" data-bs-toggle="modal" data-bs-target="#modalConfirmarDeletar">Deletar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </template>
        </modal-component>
        <!-- Modal para confirmar remoção da ação de contenção -->
        <modal-component id="modalConfirmarDeletar" title="Você tem certeza?">
            <template v-slot:conteudo>
                <div class="row">
                    <div class="col col-6">
                        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal" @click="showModal('modalAtualizarAcaoContencao')">Não</button>
                    </div>
                    <div class="col col-6">
                        <button type="button" class="btn btn-danger texto_branco w-100" @click="deleteContainmentAction()">Sim</button>
                    </div>
                </div>
            </template>
            <template v-slot:rodape></template>
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
                urlBase: utils.API_URL + '/api/v1/incident/containmentaction',
                urlUser: utils.API_URL + '/api/v1/user',
                actions: {data: {}},
                loaded: false,
                description: '',
                users: {data: {}},
                statusAction: '',
                userResponsible: '',
                descriptionUpdate: '',
                userResponsibleUpdate: '',
                statusActionUpdate: ''
            }
        },
        methods: {
            showModal(modal) {
                utils.showModal(modal);
            },
            save() {
                if (utils.fieldsValidate(['description', 'statusAction', 'userResponsible'], this)) {
                    let formData = new FormData();
                    formData.append('description', this.description);
                    formData.append('users_id', this.userResponsible);
                    formData.append('status', this.statusAction);
                    formData.append('incidents_id', this.visualid);

                    let config = {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }

                    let url = this.urlBase + '/store';
                    axios.post(url, formData, config)
                        .then(response => {
                            this.status = 'sucesso';
                            this.feedbackTitle = "Ação de contenção adicionada com sucesso";
                            utils.closeModal('modalAdicionarAcaoContencao');
                            this.loadActionList();
                            this.cleanAddAreaFormData();
                        })
                        .catch(errors => {
                            this.status = 'error';
                            this.feedbackTitle = "Erro ao adicionar ação de contenção";
                            utils.closeModal('modalAdicionarAcaoContencao');
                            this.feedbackMessage = {
                                mensagem: errors.response.data.message,
                                dados: errors.response.data.errors
                            };
                        })
                }
            },
            update() {
                    if (this.$store.state.item.description == ''){
                        document.getElementById('descriptionUpdate').classList.add('is-invalid');
                    } else {
                        if (document.getElementById('descriptionUpdate').classList.contains('is-invalid')) {
                            document.getElementById('descriptionUpdate').classList.remove('is-invalid');
                        }
                        let formData = new FormData();
                        formData.append('_method', 'patch');
                        formData.append('description', this.$store.state.item.description);
                        formData.append('users_id', this.$store.state.item.user_id);
                        formData.append('status', this.$store.state.item.status);

                        let config = {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            }
                        }
                        let url = this.urlBase + '/' + this.$store.state.item.id;
                        axios.post(url, formData, config)
                            .then(response => {
                                this.status = 'sucesso';
                                this.feedbackTitle = "Ação de contenção atualizada com sucesso";
                                utils.closeModal('modalAtualizarAcaoContencao');
                                this.loadActionList();
                            })
                            .catch(errors => {
                                this.status = 'error';
                                this.feedbackTitle = "Erro ao atualizar ação de contenção ";
                                utils.closeModal('modalAtualizarAcaoContencao');
                                this.feedbackMessage = {
                                    mensagem: errors.response.data.message,
                                    dados: errors.response.data.errors
                                };
                            })
                    }
            },
            deleteContainmentAction() {
                let url = this.urlBase + '/' + this.$store.state.item.id;
                let formData = new FormData();
                formData.append('_method', 'delete');                

                axios.post(url, formData)
                    .then(response => {
                        this.status = 'sucesso';
                        this.feedbackTitle = "Ação de contenção deletada com sucesso";
                        utils.closeModal('modalConfirmarDeletar');
                        this.loadActionList();
                    })
                    .catch(errors => {
                        this.status = 'error';
                        this.feedbackTitle = "Erro ao deletar ação de contenção";
                        utils.closeModal('modalConfirmarDeletar');
                        this.feedbackMessage = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        };
                    })
            },
            cleanAddAreaFormData() {
                this.description = '';
                this.statusAction = '';
                this.userResponsible = [];
            },
            previous() {
                window.location.href = utils.API_URL + '/admin/incidente/time/' + this.visualid
            },
            next() {
                window.location.href = utils.API_URL + '/admin/incidente/causa-raiz/' + this.visualid
            },
            loadActionList() {
                let url = this.urlBase + '/' + this.visualid;
                axios.get(url)
                    .then(response => {
                        this.actions = response.data;
                        setTimeout(() => {
                            this.feedbackTitle = "";
                            this.status = '';
                            this.feedbackMessage = {};
                        }, 10000);
                        this.loaded = true;
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
            this.loadActionList();
            
        }
    }
</script>
