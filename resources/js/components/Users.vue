<template>
    <div class="container">
        <breadcrumb-component
            :itens="{
                text:['Cadastros', 'Usuários'],
                num: '2'
            }"
        ></breadcrumb-component>
        <search-component 
            titulo="Usuários" 
            :botoes=" {
                adicionar: {
                    show: true,
                    type: 'modal',
                    modalId: '#modalAdicionarUsuario'
                },
                buscar: {
                    show: true,
                    type: 'apply',
                    fields: ['name', 'email']
                },
                limpar: {
                    show: true,
                    type: 'apply'
                }
            }" 
            placeholder="Buscar por nome ou e-mail"
            classe="user"
        ></search-component>
        <div v-if="Object.keys(usuarios.data).length > 0">
            <list-component
                :titulos="{
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
                :dados="usuarios.data"
                :status="status"
                :mensagem="mensagemFeedback"
                :titulo="tituloFeedback"
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
                    <li v-for="l, key in usuarios.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginate(l)">
                        <div v-if="l.active">
                            <a class="page-link paginate_link_activated" v-html="l.label" 
                            v-if="
                                key == usuarios.current_page || 
                                key == usuarios.current_page - 1 || 
                                key == usuarios.current_page + 1 || 
                                key == 0 ||
                                (usuarios.current_page == 1 && key == 3) ||
                                key == usuarios.last_page + 1 || 
                                (usuarios.current_page == usuarios.last_page && key == usuarios.last_page - 2)"
                        ></a>
                        </div>
                        <div v-else>
                            <a class="page-link paginate_link" 
                            v-if="
                                key == usuarios.current_page || 
                                key == usuarios.current_page - 1 || 
                                key == usuarios.current_page + 1 || 
                                key == 0 ||
                                (usuarios.current_page == 1 && key == 3) ||
                                key == usuarios.last_page + 1 || 
                                (usuarios.current_page == usuarios.last_page && key == usuarios.last_page - 2)"
                        >{{ l.label | formatNextPrevButton }}</a>
                        </div>
                        
                    </li>
                </paginate-component>
            </div>
        </div>
        <!-- Modal para adicionar usuários -->
        <modal-component id="modalAdicionarUsuario" titulo="Adicionar Usuário">
            <template v-slot:conteudo>
                <div class="form-group">
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nomeCompleto" name="nomeCompleto" placeholder="Nome Completo*" v-model="nomeCompleto">
                                <label class="form-label">Nome Completo*</label>
                                <div id="invalidFeedbackNomeCompleto" class="invalid-feedback">
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
                                <select class="form-control" id="perfil" name="perfil" placeholder="Perfil*" v-model="perfil">
                                    <option value="">Selecione...</option>
                                    <option value="superadmin">Super Administrador</option>
                                    <option value="administrator">Administrador</option>
                                    <option value="manager">Gestor</option>
                                    <option value="user">Usuário</option>
                                </select>
                                <label class="form-label">Perfil*</label>
                                <div id="invalidFeedbackPerfil" class="invalid-feedback">
                                    Informe o perfil do usuário
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha*" v-model="senha">
                                <label class="form-label">Senha*</label>
                                <div id="invalidFeedbackSenha" class="invalid-feedback">
                                    Informe a senha.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="repeteSenha" name="repeteSenha" placeholder="Repetir Senha*" v-model="repeteSenha">
                                <label class="form-label">Repetir Senha*</label>
                                <div id="invalidFeedbackSenha" class="invalid-feedback">
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
        <modal-component id="modalAtualizarUsuario" titulo="Atualizar Usuário">
            <template v-slot:conteudo>
                <div class="form-group">
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nomeCompletoUpdate" name="nomeCompletoUpdate" placeholder="Nome Completo*" v-model="$store.state.item.name">
                                <label class="form-label">Nome Completo*</label>
                                <div id="invalidFeedbackNomeCompletoUpdate" class="invalid-feedback">
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
                                <select class="form-control" id="perfilUpdate" name="perfilUpdate" placeholder="Perfil*" v-model="$store.state.item.profile">
                                    <option value="">Selecione...</option>
                                    <option value="superadmin">Super Administrador</option>
                                    <option value="administrator">Administrador</option>
                                    <option value="manager">Gestor</option>
                                    <option value="user">Usuário</option>
                                </select>
                                <label class="form-label">Perfil*</label>
                                <div id="invalidFeedbackPerfilUpdate" class="invalid-feedback">
                                    Informe o perfil do usuário
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="senhaUpdate" name="senhaUpdate" placeholder="Senha*" v-model="senhaUpdate">
                                <label class="form-label">Senha*</label>
                                <div id="invalidFeedbackSenhaUpdate" class="invalid-feedback">
                                    Informe a senha.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="repeteSenhaUpdate" name="repeteSenhaUpdate" placeholder="Repetir Senha*" v-model="repeteSenhaUpdate">
                                <label class="form-label">Repetir Senha*</label>
                                <div id="invalidFeedbackSenhaUpdate" class="invalid-feedback">
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
        <modal-component id="modalConfirmarDeletar" titulo="Você tem certeza?">
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
                usuarios: {data: {}},
                areas: {data: {}},
                urlBase: utils.API_URL + '/api/v1/user',
                urlPaginacao: '',
                urlFiltro: '',
                status: '',
                mensagemFeedback: {},
                nomeCompleto: '',
                email: '',
                senha: '',
                repeteSenha: '',
                senhaUpdate: '',
                repeteSenhaUpdate: '',
                perfil: '',
                perfilUpdate: '',
                tituloFeedback: '',
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
                        this.tituloFeedback = "Usuário ativado com sucesso";
                        utils.closeModal('modalAtualizarUser');
                        this.loadUserList();
                    })
                    .catch(errors => {
                        this.status = 'erro';
                        this.tituloFeedback = "Erro ao ativar usuário";
                        utils.closeModal('modalAtualizarUser');
                        this.mensagemFeedback = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        };
                    })
            },
            inactivate() {
                let url = this.urlBase + '/inactivate/' + this.$store.state.item.id;
                let formData = new FormData();             

                axios.post(url, formData)
                    .then(response => {
                        this.status = 'sucesso';
                        this.tituloFeedback = "Usuário inativado com sucesso";
                        utils.closeModal('modalAtualizarUser');
                        this.loadUserList();
                    })
                    .catch(errors => {
                        this.status = 'erro';
                        this.tituloFeedback = "Erro ao inativar usuário";
                        utils.closeModal('modalAtualizarUser');
                        this.mensagemFeedback = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        };
                    })
            },
            paginate(l) {
                if (l.url){
                    this.urlPaginacao = l.url.split('?')[1];
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
                        this.tituloFeedback = "Usuário deletado com sucesso";
                        utils.closeModal('modalConfirmarDeletar');
                        this.loadUserList();
                    })
                    .catch(errors => {
                        this.status = 'erro';
                        this.tituloFeedback = "Erro ao deletar usuário";
                        utils.closeModal('modalConfirmarDeletar');
                        this.mensagemFeedback = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        };
                    })
            },
            update() {
                    if (this.$store.state.item.name == ''){
                        document.getElementById('nomeCompletoUpdate').classList.add('is-invalid');
                    } else if (this.senhaUpdate != this.repeteSenhaUpdate) {
                        document.getElementById('repeteSenhaUpdate').classList.add('is-invalid');
                    } else if (this.$store.state.item.profile == '') {
                        document.getElementById('perfilUpdate').classList.add('is-invalid');
                    } else {
                        if (document.getElementById('nomeCompletoUpdate').classList.contains('is-invalid')) {
                            document.getElementById('nomeCompletoUpdate').classList.remove('is-invalid');
                        }
                        if (document.getElementById('repeteSenhaUpdate').classList.contains('is-invalid')) {
                            document.getElementById('repeteSenhaUpdate').classList.remove('is-invalid');
                        }
                        let formData = new FormData();
                        formData.append('_method', 'patch');
                        formData.append('name', this.$store.state.item.name);
                        formData.append('email', this.$store.state.item.email);
                        formData.append('password', this.senhaUpdate);
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
                                this.tituloFeedback = "Usuário atualizado com sucesso";
                                utils.closeModal('modalAtualizarUsuario');
                                this.loadUserList();
                            })
                            .catch(errors => {
                                this.status = 'erro';
                                this.tituloFeedback = "Erro ao atualizar usuário";
                                utils.closeModal('modalAtualizarUsuario');
                                this.mensagemFeedback = {
                                    mensagem: errors.response.data.message,
                                    dados: errors.response.data.errors
                                };
                            })
                    }
            },
            save() {
                if (utils.fieldsValidate(['nomeCompleto', 'email', 'perfil', 'senha', 'repeteSenha'], this)) {
                    if (this.senha != this.repeteSenha) {
                        document.getElementById('repeteSenha').classList.add('is-invalid');
                    } else {
                        if (document.getElementById('repeteSenha').classList.contains('is-invalid')) {
                            document.getElementById('repeteSenha').classList.remove('is-invalid');
                        }
                        let formData = new FormData();
                        formData.append('name', this.nomeCompleto);
                        formData.append('email', this.email);
                        formData.append('password', this.senha);
                        formData.append('profile', this.perfil);

                        let config = {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            }
                        }

                        let url = this.urlBase + '/store';
                        axios.post(url, formData, config)
                            .then(response => {
                                this.status = 'sucesso';
                                this.tituloFeedback = "Usuário adicionado com sucesso";
                                utils.closeModal('modalAdicionarUsuario');
                                this.loadUserList();
                                this.cleanAddUserFormData();
                            })
                            .catch(errors => {
                                this.status = 'erro';
                                this.tituloFeedback = "Erro ao adicionar usuário";
                                utils.closeModal('modalAdicionarUsuario');
                                this.mensagemFeedback = {
                                    mensagem: errors.response.data.message,
                                    dados: errors.response.data.errors
                                };
                            })
                    }
                }
            },
            cleanAddUserFormData() {
                this.nomeCompleto = '';
                this.email = '';
                this.senha = '';
                this.perfil= '';
                this.repeteSenha = '';
            },
            setUrlFilter(url) {
                this.urlFiltro = url;
            },
            loadUserList() {
                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro;
                axios.get(url)
                    .then(response => {
                        this.usuarios = response.data;
                        setTimeout(() => {
                            this.tituloFeedback = "";
                            this.status = '';
                            this.mensagemFeedback = {};
                        }, 10000);
                        this.loaded = true;
                    })
                    .catch(errors => {
                        if (errors.response.status == 500) {
                            this.tituloFeedback = "Erro no servidor";
                            this.status = 'erro';
                            this.mensagemFeedback = {mensagem: "Desculpe, não conseguimos processar a sua requisição, tente novamente ou entre em contato com a equipe de suporte"}
                        } else {
                            this.tituloFeedback = "Houve um erro";
                            this.status = 'erro';
                            this.mensagemFeedback = errors;
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