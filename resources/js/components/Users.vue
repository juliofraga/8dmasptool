<template>
    <div class="container">
        <breadcrumb-component
            :itens="{
                text:['Cadastros', 'Usuários'],
                num: '2'
            }"
        ></breadcrumb-component>
        <search-component 
            title="Usuários" 
            :buttons=" {
                add: {
                    show: true,
                    type: 'modal',
                    modalId: '#modalAdicionarUsuario'
                },
                search: {
                    show: true,
                    type: 'apply',
                    fields: ['name', 'email']
                },
                clear: {
                    show: true,
                    type: 'apply'
                }
            }" 
            placeholder="Buscar por nome ou e-mail"
            classSearch="user"
        ></search-component>
        <div v-if="Object.keys(users.data).length > 0">
            <list-component
                :title="{
                    id: {title: 'ID', length:'hidden', type:'text'},
                    email: {title: 'E-mail', length: '2', type:'text'},
                    name: {title: 'Nome', length: '2', type:'text'},
                    profile: {title: 'Perfil', length: '2', type:'text'},
                    status: {title: 'Status', length: '2', type:'ativoInativo'},
                    last_login: {title: 'Último Acesso', length: '2', type:'datetime'},
                    editar: {title: 'Editar', length: '2', type: 'buttonModal', modalId: '#modalAtualizarUsuario'},
                    updated_at: {title: 'Última Atualização', length: 'hidden', type: 'datetime'},
                    created_at: {title: 'Data de Criação', length: 'hidden', type: 'datetime'},
                    first_login: {title: 'Primeiro Acesso', length: 'hidden', type: 'datetime'}
                }" 
                :data="users.data"
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
        <div class="row mt-4">
            <div class="col col-10">
                <paginate-component>
                    <li v-for="l, key in users.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginate(l)">
                        <div v-if="l.active">
                            <a class="page-link paginate_link_activated" v-html="l.label" 
                            v-if="
                                key == users.current_page || 
                                key == users.current_page - 1 || 
                                key == users.current_page + 1 || 
                                key == 0 ||
                                (users.current_page == 1 && key == 3) ||
                                key == users.last_page + 1 || 
                                (users.current_page == users.last_page && key == users.last_page - 2)"
                        ></a>
                        </div>
                        <div v-else>
                            <a class="page-link paginate_link" 
                            v-if="
                                key == users.current_page || 
                                key == users.current_page - 1 || 
                                key == users.current_page + 1 || 
                                key == 0 ||
                                (users.current_page == 1 && key == 3) ||
                                key == users.last_page + 1 || 
                                (users.current_page == users.last_page && key == users.last_page - 2)"
                        >{{ l.label | formatNextPrevButton }}</a>
                        </div>
                        
                    </li>
                </paginate-component>
            </div>
        </div>
        <!-- Modal para adicionar usuários -->
        <modal-component id="modalAdicionarUsuario" title="Adicionar Usuário">
            <template v-slot:conteudo>
                <div class="form-group">
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nome Completo*" v-model="fullname">
                                <label class="form-label">Nome Completo*</label>
                                <div id="invalidFeedbackFullname" class="invalid-feedback">
                                    Informe o nome completo.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail*" v-model="email">
                                <label class="form-label">E-mail*</label>
                                <div id="invalidFeedbackEmail" class="invalid-feedback">
                                    Insira um e-mail válido.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <select class="form-control" id="profile" name="profile" placeholder="Perfil*" v-model="profile">
                                    <option value="">Selecione...</option>
                                    <option value="superadmin">Super Administrador</option>
                                    <option value="administrator">Administrador</option>
                                    <option value="manager">Gestor</option>
                                    <option value="user">Usuário</option>
                                </select>
                                <label class="form-label">Perfil*</label>
                                <div id="invalidFeedbackProfile" class="invalid-feedback">
                                    Informe o perfil do usuário
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Senha*" v-model="password">
                                <label class="form-label">Senha*</label>
                                <div id="invalidFeedbackPassword" class="invalid-feedback">
                                    Informe a senha.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="Repetir Senha*" v-model="repeatPassword">
                                <label class="form-label">Repetir Senha*</label>
                                <div id="invalidFeedbackRepeatPassword" class="invalid-feedback">
                                    Esta senha não confere com a senha digitada no campo anterior ou está vazio.
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
        <!-- Modal para atualizar usuários -->
        <modal-component id="modalAtualizarUsuario" title="Atualizar Usuário">
            <template v-slot:conteudo>
                <div class="form-group">
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="fullnameUpdate" name="fullnameUpdate" placeholder="Nome Completo*" v-model="$store.state.item.name">
                                <label class="form-label">Nome Completo*</label>
                                <div id="invalidFeedbackFullnameUpdate" class="invalid-feedback">
                                    Informe o nome completo.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="emailUpdate" name="emailUpdate" placeholder="E-mail*" v-model="$store.state.item.email" readonly>
                                <label class="form-label">E-mail*</label>
                                <div id="invalidFeedbackEmailUpdate" class="invalid-feedback">
                                    Insira um e-mail válido.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <select class="form-control" id="profileUpdate" name="profileUpdate" placeholder="Perfil*" v-model="$store.state.item.profile">
                                    <option value="">Selecione...</option>
                                    <option value="superadmin">Super Administrador</option>
                                    <option value="administrator">Administrador</option>
                                    <option value="manager">Gestor</option>
                                    <option value="user">Usuário</option>
                                </select>
                                <label class="form-label">Perfil*</label>
                                <div id="invalidFeedbackProfileUpdate" class="invalid-feedback">
                                    Informe o perfil do usuário
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="passwordUpdate" name="passwordUpdate" placeholder="Senha*" v-model="passwordUpdate">
                                <label class="form-label">Senha*</label>
                                <div id="invalidFeedbackPasswordUpdate" class="invalid-feedback">
                                    Informe a senha.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="repeatPasswordUpdate" name="repeatPasswordUpdate" placeholder="Repetir Senha*" v-model="repeatPasswordUpdate">
                                <label class="form-label">Repetir Senha*</label>
                                <div id="invalidFeedbackRepeatPasswordUpdate" class="invalid-feedback">
                                    Esta senha não confere com a senha digitada no campo anterior ou está vazio.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <label class="form-label"><i>Primeiro acesso: {{ $store.state.item.first_login | formatDateTime}}</i></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="form-label"><i>Último acesso: {{ $store.state.item.last_login | formatDateTime}}</i></label>
                        </div>
                    </div>
                    <div class="row">
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
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal" v-if="$store.state.item.status === 1" @click="inactivate()">Inativar</button>
                <button type="button" class="btn btn-info texto_branco" data-bs-dismiss="modal" v-if="$store.state.item.status === 0" @click="activate()">Ativar</button>
                <button type="button" class="btn btn-danger texto_branco" data-bs-toggle="modal" data-bs-target="#modalConfirmarDeletar">Deletar</button> 
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>                            
            </template>
        </modal-component>
        <!-- Modal para confirmar remoção de usuário -->
        <modal-component id="modalConfirmarDeletar" title="Você tem certeza?">
            <template v-slot:conteudo>
                <div class="row">
                    <div class="col col-6">
                        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal" @click="showModal('modalAtualizarUsuario')">Não</button>
                    </div>
                    <div class="col col-6">
                        <button type="button" class="btn btn-danger texto_branco w-100" @click="deleteUser()">Sim</button>
                    </div>
                </div>
            </template>
            <template v-slot:rodape></template>
        </modal-component>
    </div>
</template>
<script>
    import { EventBus } from "./eventBus.js";
    import * as utils from '../utils/functions';
    export default {
        data() {
            return {
                users: {data: {}},
                urlBase: utils.API_URL + '/api/v1/user',
                urlPaginate: '',
                urlFilter: '',
                status: '',
                feedbackMessage: {},
                fullname: '',
                email: '',
                password: '',
                repeatPassword: '',
                passwordUpdate: '',
                repeatPasswordUpdate: '',
                profile: '',
                profileUpdate: '',
                feedbackTitle: '',
                loaded: false
            }
        },
        methods: {
            activate() {
                let url = this.urlBase + '/activate/' + this.$store.state.item.id;
                let formData = new FormData();             

                axios.post(url, formData)
                    .then(response => {
                        this.status = 'sucesso';
                        this.feedbackTitle = "Usuário ativado com sucesso";
                        utils.closeModal('modalAtualizarUser');
                        this.loadUserList();
                    })
                    .catch(errors => {
                        this.status = 'erro';
                        this.feedbackTitle = "Erro ao ativar usuário";
                        utils.closeModal('modalAtualizarUser');
                        this.feedbackMessage = {
                            message: errors.response.data.message,
                            data: errors.response.data.errors
                        };
                    })
            },
            inactivate() {
                let url = this.urlBase + '/inactivate/' + this.$store.state.item.id;
                let formData = new FormData();             

                axios.post(url, formData)
                    .then(response => {
                        this.status = 'sucesso';
                        this.feedbackTitle = "Usuário inativado com sucesso";
                        utils.closeModal('modalAtualizarUser');
                        this.loadUserList();
                    })
                    .catch(errors => {
                        this.status = 'erro';
                        this.feedbackTitle = "Erro ao inativar usuário";
                        utils.closeModal('modalAtualizarUser');
                        this.feedbackMessage = {
                            message: errors.response.data.message,
                            data: errors.response.data.errors
                        };
                    })
            },
            paginate(l) {
                if (l.url){
                    this.urlPaginate = l.url.split('?')[1];
                    this.loadUserList();
                }
            },
            deleteUser() {
                let url = this.urlBase + '/' + this.$store.state.item.id;
                let formData = new FormData();
                formData.append('_method', 'delete');                

                axios.post(url, formData)
                    .then(response => {
                        this.status = 'sucesso';
                        this.feedbackTitle = "Usuário deletado com sucesso";
                        utils.closeModal('modalConfirmarDeletar');
                        this.loadUserList();
                    })
                    .catch(errors => {
                        this.status = 'erro';
                        this.feedbackTitle = "Erro ao deletar usuário";
                        utils.closeModal('modalConfirmarDeletar');
                        this.feedbackMessage = {
                            message: errors.response.data.message,
                            data: errors.response.data.errors
                        };
                    })
            },
            update() {
                    if (this.$store.state.item.name == ''){
                        document.getElementById('fullnameUpdate').classList.add('is-invalid');
                    } else if (this.passwordUpdate != this.repeatPasswordUpdate) {
                        document.getElementById('repeatPasswordUpdate').classList.add('is-invalid');
                    } else if (this.$store.state.item.profile == '') {
                        document.getElementById('profileUpdate').classList.add('is-invalid');
                    } else {
                        if (document.getElementById('fullnameUpdate').classList.contains('is-invalid')) {
                            document.getElementById('fullnameUpdate').classList.remove('is-invalid');
                        }
                        if (document.getElementById('repeatPasswordUpdate').classList.contains('is-invalid')) {
                            document.getElementById('repeatPasswordUpdate').classList.remove('is-invalid');
                        }
                        let formData = new FormData();
                        formData.append('_method', 'patch');
                        formData.append('name', this.$store.state.item.name);
                        formData.append('email', this.$store.state.item.email);
                        formData.append('password', this.passwordUpdate);
                        formData.append('profile', this.$store.state.item.profile);

                        let config = {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            }
                        }
                        let url = this.urlBase + '/' + this.$store.state.item.id;
                        axios.post(url, formData, config)
                            .then(response => {
                                this.status = 'sucesso';
                                this.feedbackTitle = "Usuário atualizado com sucesso";
                                utils.closeModal('modalAtualizarUsuario');
                                this.loadUserList();
                            })
                            .catch(errors => {
                                this.status = 'erro';
                                this.feedbackTitle = "Erro ao atualizar usuário";
                                utils.closeModal('modalAtualizarUsuario');
                                this.feedbackMessage = {
                                    message: errors.response.data.message,
                                    data: errors.response.data.errors
                                };
                            })
                    }
            },
            save() {
                if (utils.fieldsValidate(['fullname', 'email', 'profile', 'password', 'repeatPassword'], this)) {
                    if (this.password != this.repeatPassword) {
                        document.getElementById('repeatPassword').classList.add('is-invalid');
                    } else {
                        if (document.getElementById('repeatPassword').classList.contains('is-invalid')) {
                            document.getElementById('repeatPassword').classList.remove('is-invalid');
                        }
                        let formData = new FormData();
                        formData.append('name', this.fullname);
                        formData.append('email', this.email);
                        formData.append('password', this.password);
                        formData.append('profile', this.profile);

                        let config = {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            }
                        }

                        let url = this.urlBase + '/store';
                        axios.post(url, formData, config)
                            .then(response => {
                                this.status = 'sucesso';
                                this.feedbackTitle = "Usuário adicionado com sucesso";
                                utils.closeModal('modalAdicionarUsuario');
                                this.loadUserList();
                                this.cleanAddUserFormData();
                            })
                            .catch(errors => {
                                this.status = 'erro';
                                this.feedbackTitle = "Erro ao adicionar usuário";
                                utils.closeModal('modalAdicionarUsuario');
                                this.message = {
                                    mensagem: errors.response.data.message,
                                    data: errors.response.data.errors
                                };
                            })
                    }
                }
            },
            cleanAddUserFormData() {
                this.fullname = '';
                this.email = '';
                this.password = '';
                this.profile= '';
                this.repeatPassword = '';
            },
            setUrlFilter(url) {
                this.urlFilter = url;
            },
            loadUserList() {
                let url = this.urlBase + '?' + this.urlPaginate + this.urlFilter;
                axios.get(url)
                    .then(response => {
                        this.users = response.data;
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
                            this.status = 'erro';
                            this.feedbackMessage = {message: "Desculpe, não conseguimos processar a sua requisição, tente novamente ou entre em contato com a equipe de suporte"}
                        } else {
                            this.feedbackTitle = "Houve um erro";
                            this.status = 'erro';
                            this.feedbackMessage = errors;
                        }
                    })
                    
            },
            showModal(modal) {
                $('#' + modal).modal('show')
            }
        },
        mounted() {
            EventBus.$on("loadUserList", this.loadUserList)
            EventBus.$on("setUrlFilter", this.setUrlFilter);
            this.loadUserList();
        }
    }
</script>