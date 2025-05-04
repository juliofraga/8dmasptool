<template>
    <div class="container">
        <breadcrumb-component
            :itens="{
                text:['Cadastros', 'Áreas'],
                num: '2'
            }"
        ></breadcrumb-component>
        <buscar-component 
            titulo="Áreas" 
            :botoes=" {
                adicionar: {
                    show: true,
                    type: 'modal',
                    modalId: '#modalAdicionarArea'
                },
                buscar: {
                    show: true,
                    type: 'apply',
                    fields: ['name', 'description']
                },
                limpar: {
                    show: true,
                    type: 'apply'
                }
            }" 
            placeholder="Buscar por nome ou descrição"
            classe="area"
        ></buscar-component>
        <div v-if="Object.keys(areas.data).length > 0">
            <lista-component
                :titulos="{
                    id: {title: 'ID', length:'hidden', type:'text'},
                    name: {title: 'Nome', length: '2', type:'text'},
                    description: {title: 'Descrição', length: '6', type:'text'},
                    status: {title: 'Status', length: '2', type:'ativoInativo'},
                    editar: {title: 'Editar', length: '2', type: 'buttonModal', modalId: '#modalAtualizarArea'},
                    created_at: {title: 'Data de Criação', length: 'hidden', type: 'datetime'},
                }" 
                :dados="areas.data"
                :status="status"
                :mensagem="mensagemFeedback"
                :titulo="tituloFeedback"
            ></lista-component>
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
                    <li v-for="l, key in areas.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginate(l)">
                        <div v-if="l.active">
                            <a class="page-link paginate_link_activated" v-html="l.label" 
                            v-if="
                                key == areas.current_page || 
                                key == areas.current_page - 1 || 
                                key == areas.current_page + 1 || 
                                key == 0 ||
                                (areas.current_page == 1 && key == 3) ||
                                key == areas.last_page + 1 || 
                                (areas.current_page == areas.last_page && key == areas.last_page - 2)"
                        ></a>
                        </div>
                        <div v-else>
                            <a class="page-link paginate_link" 
                            v-if="
                                key == areas.current_page || 
                                key == areas.current_page - 1 || 
                                key == areas.current_page + 1 || 
                                key == 0 ||
                                (areas.current_page == 1 && key == 3) ||
                                key == areas.last_page + 1 || 
                                (areas.current_page == areas.last_page && key == areas.last_page - 2)"
                        >{{ l.label | formatNextPrevButton }}</a>
                        </div>
                        
                    </li>
                </paginate-component>
            </div>
        </div>
        <!-- Modal para adicionar áreas -->
        <modal-component id="modalAdicionarArea" titulo="Adicionar Área">
            <template v-slot:conteudo>
                <div class="form-group">
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome*" v-model="nome">
                                <label class="form-label">Nome*</label>
                                <div id="invalidFeedbackNome" class="invalid-feedback">
                                    Informe o nome da área.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <select class="form-control" id="membros" name="membros" placeholder="Membros da Área" v-model="membros" multiple style="height: auto;">
                                    <option value="">Selecione...</option>
                                    <option v-for="usuario in usuarios" :key="usuario.id" :value="usuario.id">
                                        {{ usuario.name }}
                                    </option>
                                </select>
                                <label class="form-label">Membros da Área</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <select class="form-control" id="manager" name="manager" placeholder="Área" v-model="managers" multiple style="height: auto;">
                                    <option value="">Selecione...</option>
                                    <option v-for="usuario in usuarios" :key="usuario.id" :value="usuario.id">
                                        {{ usuario.name }}
                                    </option>
                                </select>
                                <label class="form-label">Gestor da Área</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <textarea class="form-control" id="descricao" name="descricao" rows="10" v-model="descricao" style="height: auto;"></textarea>
                                <label class="form-label">Descrição</label>
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
        <!-- Modal para atualizar áreas -->
        <modal-component id="modalAtualizarArea" titulo="Atualizar Área">
            <template v-slot:conteudo>
                <div class="form-group">
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nomeUpdate" name="nomeUpdate" placeholder="Nome*" v-model="$store.state.item.name">
                                <label class="form-label">Nome*</label>
                                <div id="invalidFeedbackNomeUpdate" class="invalid-feedback">
                                    Informe o nome do setor.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <textarea class="form-control" id="descricaoUpdate" name="descricaoUpdate" rows="10" style="height: auto;" v-model="$store.state.item.description">{{ $store.state.item.description }}</textarea>
                                <label class="form-label">Descrição</label>
                            </div>
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
        <!-- Modal para confirmar remoção de área -->
        <modal-component id="modalConfirmarDeletar" titulo="Você tem certeza?">
            <template v-slot:conteudo>
                <div class="row">
                    <div class="col col-6">
                        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal" @click="showModal('modalAtualizarArea')">Não</button>
                    </div>
                    <div class="col col-6">
                        <button type="button" class="btn btn-danger texto_branco w-100" @click="deleteArea()">Sim</button>
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
                areas: {data: {}},
                usuarios: {data: {}},
                urlBase: utils.API_URL + '/api/v1/area',
                urlUser: utils.API_URL + '/api/v1/user',
                urlPaginacao: '',
                urlFiltro: '',
                status: '',
                mensagemFeedback: {},
                nome: '',
                nomeUpdate:'',
                descricao: '',
                descricaoUpdate: '',
                tituloFeedback: '',
                loaded: false,
                membros: [],
                managers: []
            }
        },
        methods: {
            activate() {
                let url = this.urlBase + '/activate/' + this.$store.state.item.id;
                let formData = new FormData();             

                axios.post(url, formData)
                    .then(response => {
                        this.status = 'sucesso';
                        this.tituloFeedback = "Área ativada com sucesso";
                        utils.closeModal('modalAtualizarArea');
                        this.loadAreaList();
                    })
                    .catch(errors => {
                        this.status = 'erro';
                        this.tituloFeedback = "Erro ao ativar área";
                        utils.closeModal('modalAtualizarArea');
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
                        this.tituloFeedback = "Área inativada com sucesso";
                        utils.closeModal('modalAtualizarArea');
                        this.loadAreaList();
                    })
                    .catch(errors => {
                        this.status = 'erro';
                        this.tituloFeedback = "Erro ao inativar área";
                        utils.closeModal('modalAtualizarArea');
                        this.mensagemFeedback = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        };
                    })
            },
            deleteArea() {
                let url = this.urlBase + '/' + this.$store.state.item.id;
                let formData = new FormData();
                formData.append('_method', 'delete');                

                axios.post(url, formData)
                    .then(response => {
                        this.status = 'sucesso';
                        this.tituloFeedback = "Área deletada com sucesso";
                        utils.closeModal('modalConfirmarDeletar');
                        this.loadAreaList();
                    })
                    .catch(errors => {
                        this.status = 'erro';
                        this.tituloFeedback = "Erro ao deletar área";
                        utils.closeModal('modalConfirmarDeletar');
                        this.mensagemFeedback = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        };
                    })
            },
            update() {
                    if (this.$store.state.item.name == ''){
                        document.getElementById('nomeUpdate').classList.add('is-invalid');
                    } else {
                        if (document.getElementById('nomeUpdate').classList.contains('is-invalid')) {
                            document.getElementById('nomeUpdate').classList.remove('is-invalid');
                        }
                        let formData = new FormData();
                        formData.append('_method', 'patch');
                        formData.append('name', this.$store.state.item.name);
                        formData.append('description', this.$store.state.item.description);

                        let config = {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            }
                        }
                        let url = this.urlBase + '/' + this.$store.state.item.id;
                        axios.post(url, formData, config)
                            .then(response => {
                                this.status = 'sucesso';
                                this.tituloFeedback = "Área atualizada com sucesso";
                                utils.closeModal('modalAtualizarArea');
                                this.loadAreaList();
                            })
                            .catch(errors => {
                                this.status = 'erro';
                                this.tituloFeedback = "Erro ao atualizar área";
                                utils.closeModal('modalAtualizarArea');
                                this.mensagemFeedback = {
                                    mensagem: errors.response.data.message,
                                    dados: errors.response.data.errors
                                };
                            })
                    }
            },
            paginate(l) {
                if (l.url){
                    this.urlPaginacao = l.url.split('?')[1];
                    this.loadAreaList();
                }
            },
            cleanAddAreaFormData() {
                this.nome = '';
                this.descricao = '';
                this.membros = [],
                this.managers = []
            },
            setUrlFilter(url) {
                this.urlFiltro = url;
            },
            loadAreaList() {
                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro;
                axios.get(url)
                    .then(response => {
                        this.areas = response.data;
                        setTimeout(() => {
                            this.tituloFeedback = "";
                            this.status = '';
                            this.mensagemFeedback = {};
                        }, 10000);
                        this.loadActiveUsers();
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
            loadActiveUsers() {
                let url = this.urlUser + '/all/active';
                axios.get(url)
                    .then(response => {
                        this.usuarios = response.data;
                        setTimeout(() => {
                            this.tituloFeedback = "";
                            this.status = '';
                            this.mensagemFeedback = {};
                        }, 10000);
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
            save() {
                if (utils.fieldsValidate(['nome'], this)) {
                    let formData = new FormData();
                    formData.append('name', this.nome);
                    formData.append('description', this.descricao);
                    formData.append('users', this.membros);
                    formData.append('managers', this.managers);

                    let config = {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }

                    let url = this.urlBase + '/store';
                    axios.post(url, formData, config)
                        .then(response => {
                            this.status = 'sucesso';
                            this.tituloFeedback = "Área adicionada com sucesso";
                            utils.closeModal('modalAdicionarArea');
                            this.loadAreaList();
                            this.cleanAddAreaFormData();
                        })
                        .catch(errors => {
                            console.log('error: ', errors);
                            this.status = 'erro';
                            this.tituloFeedback = "Erro ao adicionar área";
                            utils.closeModal('modalAdicionarArea');
                            this.mensagemFeedback = {
                                mensagem: errors.response.data.message,
                                dados: errors.response.data.errors
                            };
                        })
                }
            },
            showModal(modal) {
                $('#' + modal).modal('show')
            }
        },
        mounted() {
            EventBus.$on("loadAreaList", this.loadAreaList)
            EventBus.$on("setUrlFilter", this.setUrlFilter);
            this.loadAreaList();
        }
    }
</script>
