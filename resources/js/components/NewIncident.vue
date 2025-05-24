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
        <div class="form-group mt-2">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-floating mt-3">
                        <input type="date" class="form-control" id="date_deadline" name="date_deadline" placeholder="Prazo estimado para resolução do problema*" v-model="date_deadline">
                        <label class="form-label">Prazo estimado para resolução do problema*</label>
                        <div id="invalidFeedbackdateDeadline" class="invalid-feedback">
                            Informe um prazo estimado para a resolução do problema.
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
                        <input type="text" class="form-control" id="item_description" name="item_description" placeholder="Descrição do item que apresentou problema*" v-model="item_description">
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
                        <textarea class="form-control" id="incident_description" name="incident_description" placeholder="Descrição da Não-conformidade*" rows='20' style="height: auto;" v-model="incident_description"></textarea>
                        <label class="form-label">Descrição da Não-conformidade*</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-2 mt-3">
                    <button type="button" class="btn btn-info texto_branco w-100" @click="save()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                            <path d="M11 2H9v3h2z"/>
                            <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                        </svg>
                        Salvar
                    </button>
                </div>
                <div class="col-sm-2 mt-3">
                    <button type="button" class="btn btn-success texto_branco w-100" @click="saveContinue()">
                        Salvar & Continuar
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fast-forward" viewBox="0 0 16 16">
                            <path d="M6.804 8 1 4.633v6.734zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696z"/>
                            <path d="M14.804 8 9 4.633v6.734zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C8.713 12.69 8 12.345 8 11.692V4.308c0-.653.713-.998 1.233-.696z"/>
                        </svg>
                    </button>
                </div>
                <div class="col-sm-2 mt-3">
                    <button type="button" class="btn btn-warning w-100" @click="cancel()">
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
    export default {
        props: ['user'],
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
                date_deadline: ''
            }
        }
    }
</script>