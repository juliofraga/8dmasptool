<template>
    <div class="container">
        <breadcrumb-component
            :itens="{
                text:['Incidentes', 'Novo'],
                num: '2'
            }"
        ></breadcrumb-component>
        <orientation-component
            :sentence="{
                etapa: '1', 
                mensagem: 'Ajude-nos a entender sua situação descrevendo o problema e fornecendo todas as informações que julgar importantes.'
            }"
        ></orientation-component>
        <alert-component type="danger" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'error'"></alert-component>
        <alert-component type="success" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'success'"></alert-component>
        <div class="form-group mt-2">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <input type="date" class="form-control" id="date_deadline" name="date_deadline" placeholder="Prazo estimado para resolução do problema*" v-model="date_deadline" @blur="clearInvalidFeedback($event.target)">
                        <label class="form-label">Prazo estimado para resolução do problema*</label>
                        <div id="invalidFeedbackDateDeadline" class="invalid-feedback">
                            Informe um prazo estimado para a resolução do problema.
                        </div>
                        <div id="invalidFeedbackInvalidDate" class="invalid-feedback ">
                            A data informada é menor que a data atual, informe uma data valida.
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="visual_id" name="visual_id" placeholder="ID do Incidente" v-model="visual_id" disabled>
                        <label class="form-label">ID do Incidente</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="item_description" name="item_description" placeholder="Descrição do item que apresentou problema*" v-model="item_description"  @blur="clearInvalidFeedback($event.target)">
                        <label class="form-label">Descrição do item que apresentou problema*</label>
                        <div id="invalidFeedbackItemDescription" class="invalid-feedback">
                            Informe a descrição do item que apresentou problema.
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="category" name="category" placeholder="Categoria*" v-model="category">
                            <option value="Product">Produto</option>
                            <option value="Service">Serviço</option>
                        </select>
                        <label class="form-label">Categoria*</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="client_supplier" name="client_supplier" placeholder="Nome do cliente ou fornecedor (caso seja problema externo)" v-model="client_supplier">
                        <label class="form-label">Nome do cliente ou fornecedor (caso seja problema externo)</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="internal_code" name="internal_code" placeholder="Código interno do produto/serviço (caso seja problema interno e tenha um código)" v-model="internal_code">
                        <label class="form-label">Código interno do produto/serviço (caso seja problema interno e tenha um código)</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <input type="number" class="form-control" id="quantity_detected" name="quantity_detected" placeholder="Quantidade Detectada" v-model="quantity_detected">
                        <label class="form-label">Quantidade Detectada</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <select class="form-control" id="recidivism" name="recidivism" placeholder="Reincidência*" v-model="recidivism">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                        <label class="form-label">Reincidência*</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="batch" name="batch" placeholder="Lote (se for produto)" v-model="batch">
                        <label class="form-label">Lote (se for produto)</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="invoice" name="invoice" placeholder="Nota Fiscal" v-model="invoice">
                        <label class="form-label">Nota Fiscal</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-floating mt-3">
                        <textarea class="form-control" id="incident_description" name="incident_description" placeholder="Descrição da Não-conformidade*" rows='20' style="height: auto;" v-model="incident_description" @blur="clearInvalidFeedback($event.target)"></textarea>
                        <label class="form-label">Descrição da Não-conformidade*</label>
                        <div id="invalidFeedbackIncidentDescription" class="invalid-feedback">
                            Informe a descrição da não-conformidade.
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
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
                <div class="col-sm-2 mt-3" v-if="visual_id != ''">
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
    </div>
</template>

<script>
    import * as utils from '../utils/functions';
    export default {
        props: ['user', 'visualid'],
        data() {
            return {
                item_description: '',
                category: 'Product',
                client_supplier: '',
                internal_code: '',
                quantity_detected: '',
                recidivism: 0,
                batch: '',
                invoice: '',
                incident_description: '',
                visual_id: '',
                date_deadline: '',
                urlBase: utils.API_URL + '/api/v1/incident',
                status: '',
                feedbackTitle: '',
                feedbackMessage: '',
                continueForward: false,
            }
        },
        methods: {
            cancel() {
                if (this.visualid) {
                    this.loadIncidentData();
                } else {
                    this.clearFields();
                }
                utils.removeInvalidFeedback(['item_description', 'date_deadline', 'incident_description']);
                utils.goToTop();
            },
            clearFields() {
                this.item_description = '';
                this.category = 'Product';
                this.client_supplier = '';
                this.internal_code = '';
                this.quantity_detected = '';
                this.recidivism = 0;
                this.batch = '';
                this.invoice = '';
                this.incident_description = '';
                this.visual_id = '';
                this.date_deadline = '';
                this.status = '';
                this.feedbackTitle = '';
                this.feedbackMessage = '';
            },
            clearInvalidFeedback(input){
                utils.clearInvalidFeedback(input.id, input.value);
            },
            update() {
                let formData = this.generateIncidentFormData('update');                    
                let config = {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                let url = this.urlBase + '/' + this.visual_id;
                axios.post(url, formData, config)
                    .then(response => {
                        this.status = 'success';
                        this.feedbackTitle = "Informações atualizadas com sucesso";
                        this.continueForward = true;
                    })
                    .catch(errors => {
                        this.status = 'error';
                        this.feedbackTitle = "Erro ao atualizar informações";
                        this.feedbackMessage = {
                            mensagem: errors.response.data.message,
                            data: errors.response.data.errors
                        };
                    })
                utils.clearFeedbackMessage(this, 10000);
                utils.goToTop();
            },
            save() {
                const currentDate = new Date(utils.returnCurrentDate());
                let dateDeadline = new Date(this.date_deadline);
                if (dateDeadline < currentDate) {
                    document.getElementById('date_deadline').classList.add('is-invalid');
                    document.getElementById('invalidFeedbackInvalidDate').style.display = 'block';
                    document.getElementById('invalidFeedbackDateDeadline').style.display = 'none';
                    return;
                } else {
                    if (document.getElementById('invalidFeedbackDateDeadline').classList.contains('is-invalid')) {
                        document.getElementById('invalidFeedbackDateDeadline').style.display = 'block';
                    }
                    document.getElementById('invalidFeedbackInvalidDate').style.display = 'none';
                }
                if (utils.fieldsValidate(['item_description', 'date_deadline', 'incident_description'], this)) {
                    if (this.visualid) {
                        this.update();
                        return;
                    }
                    let formData = this.generateIncidentFormData('save');                    
                    let config = {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            }
                        }
                    let url = this.urlBase + '/store';
                    axios.post(url, formData, config)
                        .then(response => {
                            this.status = 'success';
                            this.feedbackTitle = "Informações registradas com sucesso";
                            this.visual_id = response.data.visual_id;
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
            saveContinue() {
                this.save();
                setTimeout(() => {
                    if (this.continueForward == true) {
                        this.next();
                    }
                }, 2000);  
            },
            next() {
                window.location.href = utils.API_URL + '/admin/incidente/time/' + this.visual_id
            },
            generateIncidentFormData(type) {
                let formData = new FormData();
                if (type == 'update') {
                    formData.append('_method', 'patch');
                }
                formData.append('item_description', this.item_description);
                formData.append('category', this.category);
                formData.append('client_supplier', this.client_supplier);
                formData.append('internal_code', this.internal_code);
                formData.append('quantity_detected', this.quantity_detected);
                formData.append('recidivism', this.recidivism);
                formData.append('batch', this.batch);
                formData.append('invoice', this.invoice);
                formData.append('incident_description', this.incident_description);
                formData.append('date_deadline', this.date_deadline);
                formData.append('date_opening', utils.returnCurrentDate());
                formData.append('status', 'Not Started');
                formData.append('mode', 'Classic');
                return formData;
            },
            loadIncidentData() {
                let url = this.urlBase + '/' + this.visualid;
                axios.get(url)
                    .then(response => {
                        this.setIncidentData(response.data);
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
                        this.visual_id = this.visualid;
                        utils.makeFieldsDisabled(['item_description', 'category', 'client_supplier', 'internal_code', 'quantity_detected', 'recidivism', 'batch', 'invoice', 'incident_description', 'date_deadline', 'btnSave', 'btnSaveContinue', 'btnCancel']);
                        utils.goToTop();
                    })
            },
            setIncidentData(data) {
                this.item_description = data.item_description;
                this.category = data.category;
                this.client_supplier = data.client_supplier;
                this.internal_code = data.internal_code;
                this.quantity_detected = data.quantity_detected;
                this.recidivism = data.recidivism;
                this.batch = data.batch;
                this.invoice = data.invoice;
                this.incident_description = data.incident_description;
                this.visual_id = this.visualid;
                this.date_deadline = data.date_deadline;
                this.status = data.status;
            }
        },
        mounted() {
            const [navEntry] = performance.getEntriesByType("navigation");
            const isReload = navEntry && navEntry.type === "reload";
            const isOnIncidenteNovo = window.location.pathname.includes("/incidente/novo");
            const savedVisualId = sessionStorage.getItem('saved_visual_id');
            if (isOnIncidenteNovo && !isReload) {
                sessionStorage.removeItem('saved_visual_id');
            }
            if (isReload && isOnIncidenteNovo && savedVisualId) {
                window.location.href = utils.API_URL + '/admin/incidente/' + savedVisualId;
            }
            if (this.visualid) {
                this.loadIncidentData();
            }
        },
        watch: {
            visual_id(newVal) {
                sessionStorage.setItem('saved_visual_id', newVal);
            }
        }
    }
</script>