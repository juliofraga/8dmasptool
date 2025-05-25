<template>
    <div class="container">
        <breadcrumb-component
            :itens="{
                text:['Incidentes', 'Consultar'],
                num: '2'
            }"
        ></breadcrumb-component>
        <search-component 
            title="Usuários" 
            :buttons=" {
                add: {
                    show: false
                },
                search: {
                    show: true,
                    type: 'apply',
                    fields: ['visual_id', 'item_description', 'incident_description']
                },
                clear: {
                    show: true,
                    type: 'apply'
                }
            }" 
            placeholder="Buscar por ID ou descrição"
            classSearch="incident"
        ></search-component>
        <div class="row mt-3" v-if="status == 'error'">
            <alert-component type="danger" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'error'"></alert-component>
        </div>
        <div v-if="Object.keys(incidents.data).length > 0">
            <list-component
                :title="{
                    visual_id: {title: 'Visual ID', length:'1', type:'text'},
                    item_description: {title: 'Item', length: '4', type:'text'},
                    date_opening: {title: 'Data de Abertura', length: '2', type:'date'},
                    date_deadline: {title: 'Prazo p/ Resposta', length: '2', type:'date'},
                    status: {title: 'Status', length: '1', type:'status-incident'},
                    view: {title: 'Visualizar', length: '2', type: 'buttonRedirected', url:'incidente'},
                }" 
                :data="incidents.data"
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
                    <li v-for="l, key in incidents.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginate(l)">
                        <div v-if="l.active">
                            <a class="page-link paginate_link_activated" v-html="l.label" 
                            v-if="
                                key == incidents.current_page || 
                                key == incidents.current_page - 1 || 
                                key == incidents.current_page + 1 || 
                                key == 0 ||
                                (incidents.current_page == 1 && key == 3) ||
                                key == incidents.last_page + 1 || 
                                (incidents.current_page == incidents.last_page && key == incidents.last_page - 2)"
                        ></a>
                        </div>
                        <div v-else>
                            <a class="page-link paginate_link" 
                            v-if="
                                key == incidents.current_page || 
                                key == incidents.current_page - 1 || 
                                key == incidents.current_page + 1 || 
                                key == 0 ||
                                (incidents.current_page == 1 && key == 3) ||
                                key == incidents.last_page + 1 || 
                                (incidents.current_page == incidents.last_page && key == incidents.last_page - 2)"
                        >{{ l.label | formatNextPrevButton }}</a>
                        </div>
                        
                    </li>
                </paginate-component>
            </div>
        </div>
    </div>
</template>

<script>
    import * as utils from '../utils/functions';
    export default {
        data() {
            return {
                incidents: {data: {}},
                urlBase: utils.API_URL + '/api/v1/incident',
                urlPaginate: '',
                urlFilter: '',
                feedbackTitle: '',
                status: '',
                feedbackMessage: '',
                loaded: false
            }
        },
        methods: {
            loadIncidentList() {
                let url = this.urlBase + '?' + this.urlPaginate + this.urlFilter;
                axios.get(url)
                    .then(response => {
                        this.incidents = response.data;
                        this.loaded = true;
                    })
                    .catch(errors => {
                        if (errors.response.status == 500) {
                            this.feedbackTitle = "Erro no servidor";
                            this.status = 'error';
                            this.feedbackMessage = {message: "Desculpe, não conseguimos processar a sua requisição, tente novamente ou entre em contato com a equipe de suporte"}
                        } else {
                            this.feedbackTitle = "Houve um erro";
                            this.status = 'error';
                            this.feedbackMessage = errors;
                        }
                    })
            }
        },
        mounted() {
            this.loadIncidentList();
        }
    }
</script>
