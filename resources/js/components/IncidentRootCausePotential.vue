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
        <div class="form-group row mt-4 mb-4">
            <div class="col-md-8 mt-2">
                <div class="form-floating">
                    <input type="text" id="description" class="form-control" name="description" v-model="description" placeholder="Insira uma possível causa do problema*">
                    <label class="form-label">Insira uma possível causa do problema*</label>
                    <div id="invalidFeedbackDescription" class="invalid-feedback">
                        Informe uma possível causa do problema.
                    </div>
                </div>
            </div>
            <div class="col-md-2 mt-2">
                <div class="form-floating">
                    <select class="form-control" id="category" name="category" placeholder="Categoria*" v-model="category">
                        <option value="">Selecione...</option>
                        <option value="environment">Meio ambiente</option>
                        <option value="workforce">Mão-de-obra</option>
                        <option value="method">Método</option>
                        <option value="machine">Máquina</option>
                        <option value="measurement">Meio de medição</option>
                        <option value="material">Matéria-prima</option>
                    </select>
                    <label class="form-label">Categoria*</label>
                    <div id="invalidFeedbackCategoria" class="invalid-feedback">
                        Informe a categoria.
                    </div>
                </div>
            </div>
            <div class="col-md-2 mt-2">
                <div class="form-floating">
                    <button class="w-100 btn btn-secondary btn-lg" @click="addRootCausePotential()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>
                        Adicionar
                    </button>
                </div>
            </div>
        </div>
        <div class="mt-2">
            <alert-component type="danger" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'error'"></alert-component>
            <alert-component type="success" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'success'"></alert-component>
        </div>
        <hr class="divisor_horizontal">
        <div class="row mt-3">
            <h3>Possíveis Causas Raiz</h3>
        </div>
        <div class="mt-4 mb-2">
            <div class="row">
                <div class="col col-4">
                    <b>Meio ambiente</b>
                    <div class="d-flex flex-wrap gap-2">
                        <div
                            v-for="item in environment"
                            :key="item.id"
                            class="position-relative"
                        >
                            <span class="badge rounded-pill bg-dark text-white px-4 py-2 badge-lg">
                                {{ item.description }}
                            </span>
                            <button
                                class="btn-close-custom"
                                @click="deleteRootCausePotential(item.id)"
                                >✕
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col col-4">
                    <b>Mão-de-obra</b>
                    <div class="d-flex flex-wrap gap-2">
                        <div
                            v-for="item in workforce"
                            :key="item.id"
                            class="position-relative"
                        >
                            <span class="badge rounded-pill bg-dark text-white px-4 py-2 badge-lg">
                                {{ item.description }}
                            </span>
                            <button
                                class="btn-close-custom"
                                @click="deleteRootCausePotential(item.id)"
                                >✕
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col col-4">
                    <b>Método</b>
                    <div class="d-flex flex-wrap gap-2">
                        <div
                            v-for="item in method"
                            :key="item.id"
                            class="position-relative"
                        >
                            <span class="badge rounded-pill bg-dark text-white px-4 py-2 badge-lg">
                                {{ item.description }}
                            </span>
                            <button
                                class="btn-close-custom"
                                @click="deleteRootCausePotential(item.id)"
                                >✕
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col col-4">
                    <b>Máquina</b>
                    <div class="d-flex flex-wrap gap-2">
                        <div
                            v-for="item in machine"
                            :key="item.id"
                            class="position-relative"
                        >
                            <span class="badge rounded-pill bg-dark text-white px-4 py-2 badge-lg">
                                {{ item.description }}
                            </span>
                            <button
                                class="btn-close-custom"
                                @click="deleteRootCausePotential(item.id)"
                                >✕
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col col-4">
                    <b>Meio de medição</b>
                    <div class="d-flex flex-wrap gap-2">
                        <div
                            v-for="item in measurement"
                            :key="item.id"
                            class="position-relative"
                        >
                            <span class="badge rounded-pill bg-dark text-white px-4 py-2 badge-lg">
                                {{ item.description }}
                            </span>
                            <button
                                class="btn-close-custom"
                                @click="deleteRootCausePotential(item.id)"
                                >✕
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col col-4">
                    <b>Matéria-prima</b>
                    <div class="d-flex flex-wrap gap-2">
                        <div
                            v-for="item in material"
                            :key="item.id"
                            class="position-relative"
                        >
                            <span class="badge rounded-pill bg-dark text-white px-4 py-2 badge-lg">
                                {{ item.description }}
                            </span>
                            <button
                                class="btn-close-custom"
                                @click="deleteRootCausePotential(item.id)"
                                >✕
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="divisor_horizontal">
        <div class="row mt-3">
            <h3>Após análise, indique a mais provável causa raiz do problema</h3>
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
                environment: [],
                workforce: [],
                method: [],
                machine: [],
                measurement: [],
                material: [],
                description: '',
                category: '',
                rootCauses: {data: {}},
            }
        },
        methods: {
            deleteRootCausePotential(id) {
                let url = this.urlBase + '/' + id;
                let formData = new FormData();
                formData.append('_method', 'delete');                

                axios.post(url, formData)
                    .then(response => {
                        this.loadRootCausePotentialList();
                    })
                    .catch(errors => {
                        this.status = 'error';
                        this.feedbackTitle = "Erro ao deletar potencial causa raiz";
                        this.feedbackMessage = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        };
                    })
            },
            addRootCausePotential() {
                if (utils.fieldsValidate(['description', 'category'], this)) {
                    let formData = new FormData();
                    formData.append('description', this.description);
                    formData.append('category', this.category);
                    formData.append('incidents_id', this.visualid);

                    let config = {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }

                    let url = this.urlBase + '/store';
                    axios.post(url, formData, config)
                        .then(response => {
                            this.status = 'success';
                            this.feedbackTitle = "Potencial causa raiz adicionada com sucesso";
                            this.cleanAddRootCausaPotencial();
                            this.loadRootCausePotentialList();
                        })
                        .catch(errors => {
                            this.status = 'error';
                            this.feedbackTitle = "Erro ao adicionar potencial causa raiz";

                            this.feedbackMessage = {
                                mensagem: errors.response.data.message,
                                dados: errors.response.data.errors
                            };
                        })
                }
            },
            loadRootCausePotentialList() {
                let url = this.urlBase + '/' + this.visualid;
                axios.get(url)
                    .then(response => {
                        this.rootCauses = response.data;
                        this.splitCategories();
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
            splitCategories() {
                this.environment = [];
                this.workforce = [];
                this.method = [];
                this.machine = [];
                this.measurement = [];
                this.material = [];
                this.rootCauses.data.forEach(item => {
                switch (item.category) {
                    case 'environment':
                        this.environment.push(item);
                        break;
                    case 'workforce':
                        this.workforce.push(item);
                        break;
                    case 'measurement':
                        this.measurement.push(item);
                        break;
                    case 'method':
                        this.method.push(item);
                        break;
                    case 'machine':
                        this.machine.push(item);
                        break;
                    case 'material':
                        this.material.push(item);
                        break;
                    default:
                    console.warn('Categoria não tratada:', item.category);
                }
                });
            },
            cleanAddRootCausaPotencial() {
                this.description = '';
                this.category = '';
            },
            previous() {
                window.location.href = utils.API_URL + '/admin/incidente/acao-contencao/' + this.visualid
            },
            next() {
                window.location.href = utils.API_URL + '/admin/incidente/acao-corretiva-permanente/' + this.visualid
            },
        },
        mounted() {
            this.loadRootCausePotentialList();
        }
    }
</script>
