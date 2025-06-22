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
        <div class="mt-2">
            <alert-component type="danger" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'error'"></alert-component>
            <alert-component type="success" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'success'"></alert-component>
        </div>
        <hr class="divisor_horizontal">
        <div class="row mt-3">
            <h3>PASSO 1: POTENCIAIS CAUSAS RAIZ - Identifique as possíveis causas raiz</h3>
        </div>
        <div class="form-group row mt-2 mb-4">
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
            <h3>PASSO 2: CAUSA MAIS PROVÁVEL - Após identificar as possíveis causas raiz, indique a causa potencial mais provável</h3>
        </div>
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="form-floating">
                    <select class="form-control" id="rootCause" name="rootCause" placeholder="Causa Raiz*" v-model="rootCause" @change="setRootCause()">
                        <option value="">Selecione...</option>
                        <option v-for="cause in rootCauses.data" :key="cause.id" :value="cause.id">
                            {{ cause.description }}
                        </option>
                    </select>
                    <label class="form-label">Causa Raiz*</label>
                    <div id="invalidFeedbackRootCause" class="invalid-feedback">
                        Informe a causa raiz mais provável
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <h3>PASSO 3: 5 PORQUÊS - E agora informe os 5 porquês</h3>
        </div>
        <div class="row">
            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input type="text" id="primeiropq" name="primeiropq" class="form-control" v-model="primeiropq" placeholder="1º Porquê">
                    <label class="form-label">1º Porquê</label>
                    <div id="invalidFeedbackPrimeiroPorque" class="invalid-feedback">
                        Informe pelo menos um porquê
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input type="text" id="segundopq" name="segundopq" class="form-control" v-model="segundopq" placeholder="2º Porquê">
                    <label class="form-label">2º Porquê</label>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input type="text" id="terceiropq" name="terceiropq" class="form-control" v-model="terceiropq" placeholder="3º Porquê">
                    <label class="form-label">3º Porquê</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input type="text" id="quartopq" name="quartopq" class="form-control" v-model="quartopq" placeholder="4º Porquê">
                    <label class="form-label">4º Porquê</label>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input type="text" id="quintopq" name="quintopq" class="form-control" v-model="quintopq" placeholder="5º Porquê">
                    <label class="form-label">5º Porquê</label>
                </div>
            </div>
            <div class="col-md-2 mt-2">
                <div class="form-floating">
                    <select class="form-control" id="step_number" name="step_number" placeholder="Selecione a causa raíz*" v-model="step_number">
                        <option value="">Selecione...</option>
                        <option value="1">1º Porquê</option>
                        <option value="2">2º Porquê</option>
                        <option value="3">3º Porquê</option>
                        <option value="4">4º Porquê</option>
                        <option value="5">5º Porquê</option>
                    </select>
                    <label class="form-label">Selecione a causa raíz*</label>
                    <div id="invalidFeedbackStepNumber" class="invalid-feedback">
                        Selecione a causa raíz
                    </div>
                </div>
            </div>
            <div class="col-md-2 mt-2">
                <button type="button" class="btn btn-info texto_branco w-100" @click="saveFiveWhys()" id="btnSave">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                        <path d="M11 2H9v3h2z"/>
                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                    </svg>
                    Salvar
                </button>
            </div>
        </div>
        <div class="mt-2">
            <alert-component type="danger" :details="feedbackMessageFiveWhy" :title="feedbackTitleFiveWhy" v-if="statusFiveWhy == 'error'"></alert-component>
            <alert-component type="success" :details="feedbackMessageFiveWhy" :title="feedbackTitleFiveWhy" v-if="statusFiveWhy == 'success'"></alert-component>
        </div>
        <hr class="divisor_horizontal">
        <div class="row mt-3">
            <h3>PASSO 4: TESTAR CAUSA IDENTIFICADA - Com a causa raiz identificada por meio dos 5 Porquês, você deve testar se ela realmente reproduz o problema. Insira abaixo os testes realizados e os resultados</h3>
        </div>
        <h5 class="mt-4">Causa raiz identificada: <b>{{ step_number_text }}</b></h5>
        <div class="mt-2">
            <alert-component type="danger" :details="feedbackMessageRootCauseStore" :title="feedbackTitleRootCauseStore" v-if="statusRootCauseStore == 'error'"></alert-component>
            <alert-component type="success" :details="feedbackMessageRootCauseStore" :title="feedbackTitleRootCauseStore" v-if="statusRootCauseStore == 'success'"></alert-component>
        </div>
        <div class="row">
            <div class="col-md-2 mt-2">
                <button class="w-100 btn btn-primary btn-md texto_branco" data-bs-toggle="modal" data-bs-target="#modalAddTest">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    Adicionar Teste
                </button>
            </div>
        </div>
        <div id="test-results-section" v-for="test in rootCauseTestList.data" :key="test.id" :value="test.id">
            <hr class="divisor_horizontal_small">
            <div class="row">
                <div class="col-md-12">
                    <b>Teste Número:</b> {{ test.id }} | <b>Causa raiz testada:</b> {{ test.five_why.why }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-1">
                    <b>Responsável pelo teste: </b> {{ test.user.name }}
                </div>
                <div class="col-md-6 mt-1">
                    <b>Resultado do teste: </b>{{ test.approved | formatTestResult }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-3">
                    <h5><b>Descrição do teste</b></h5>
                    <p style="text-align: justify;">{{ test.description }}</p>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-floating">
                        <h5><b>Resultados do teste</b></h5>
                        <p style="text-align: justify;"> {{ test.result }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-1">
                    <i><b>Criado em:</b> {{ test.created_at | formatDateTimeStamp}}</i>
                </div>
                <div class="col-md-6 mt-1">
                <i><b>Testado em:</b> {{ test.approved_at | formatDateTime }}</i>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 mt-2">
                    <button class="w-100 btn btn-secondary btn-md" data-bs-toggle="modal" data-bs-target="#modalUpdateTest" @click="setTest(test)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                        </svg>
                        Editar Teste
                    </button>
                </div>
            </div>
        </div>
        <hr class="divisor_horizontal">
        <div class="row mt-3">
            <h3>PASSO 5: PONTO DE ESCAPE - Neste passo você deve identificar por que o problema não foi detectado antes de causar impacto e informar o plano de melhoria</h3>
        </div>
        <div class="mt-2">
            <alert-component type="danger" :details="feedbackMessageEscapePoint" :title="feedbackTitleEscapePoint" v-if="statusEscapePoint == 'error'"></alert-component>
            <alert-component type="success" :details="feedbackMessageEscapePoint" :title="feedbackTitleEscapePoint" v-if="statusEscapePoint == 'success'"></alert-component>
        </div>
        <div class="row">
            <div class="col-md-3 mt-2">
                <button class="w-100 btn btn-primary btn-md texto_branco" data-bs-toggle="modal" data-bs-target="#modalAddEscapePoint">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    Adicionar Ponto de Escape
                </button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12 mt-2">
                <alert-component type="warning" title="Não foi informado nenhum ponto de escape ainda"></alert-component>
            </div>
        </div>
        <hr class="divisor_horizontal">
        <div class="row mt-3">
            <h3 v-if="identifiedRootCause.data.length === 0">CONCLUSÃO</h3>
            <h3 v-if="identifiedRootCause.data.length === 1">CONCLUSÃO - Esta é a causa raiz deste incidente</h3>
            <h3 v-if="identifiedRootCause.data.length > 1">CONCLUSÃO - Estas são as causas raizes deste incidente</h3>
        </div>
        <div id="root-cause-section" v-for="rootCause in identifiedRootCause.data" :key="rootCause.id" :value="rootCause.id">
            <alert-component type="success" :title="rootCause.description"></alert-component>
        </div>
        <div class="mt-3" v-if="identifiedRootCause.data.length === 0">
            <alert-component type="warning" title="Causa raiz ainda não foi identificada"></alert-component>
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
        <!-- Modal para adicionar Testes -->
        <modal-component id="modalAddTest" title="Adicionar Teste">
            <template v-slot:conteudo>
                <div class="form-group">
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <h4>Causa raiz: {{ step_number_text }}</h4>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <textarea class="form-control" id="testDescription" name="testDescription" rows="10" v-model="testDescription" style="height: auto;"></textarea>
                                <label class="form-label">Descrição do teste</label>
                                <div id="invalidFeedbackTestDescription" class="invalid-feedback">
                                    Informe a descrição do teste.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <textarea class="form-control" id="testResult" name="testResult" rows="10" v-model="testResult" style="height: auto;"></textarea>
                                <label class="form-label">Resultado do teste</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <select class="form-control" id="userResponsible" name="userResponsible" placeholder="Responsável pelo teste*" v-model="userResponsible">
                                    <option value="">Selecione...</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.name }}
                                    </option>
                                </select>
                                <label class="form-label">Responsável pelo teste*</label>
                                <div id="invalidFeedbackResponsible" class="invalid-feedback">
                                    Informe o responsável pelo teste.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <select class="form-control" id="testApproved" name="testApproved" placeholder="Teste Aprovado?" v-model="testApproved">
                                    <option value="2">Não testado</option>
                                    <option value="0">Reprovado</option>
                                    <option value="1">Aprovado</option>
                                </select>
                                <label class="form-label">Teste Aprovado?</label>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success texto_branco" @click="saveTest()">Salvar</button>
            </template>
        </modal-component>
        <!-- Modal para editar Testes -->
        <modal-component id="modalUpdateTest" title="Editar Teste">
            <template v-slot:conteudo>
                <div class="form-group">
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <h4>Causa raiz: {{ step_number_text }}</h4>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <textarea class="form-control" id="testDescriptionUpdate" name="testDescriptionUpdate" rows="10" v-model="testDescriptionUpdate" style="height: auto;"></textarea>
                                <label class="form-label">Descrição do teste</label>
                                <div id="invalidFeedbackTestDescriptionUpdate" class="invalid-feedback">
                                    Informe a descrição do teste.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <textarea class="form-control" id="testResultUpdate" name="testResultUpdate" rows="10" v-model="testResultUpdate" style="height: auto;"></textarea>
                                <label class="form-label">Resultado do teste</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <select class="form-control" id="userResponsibleUpdate" name="userResponsibleUpdate" placeholder="Responsável pelo teste*" v-model="userResponsibleUpdate">
                                    <option value="">Selecione...</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.name }}
                                    </option>
                                </select>
                                <label class="form-label">Responsável pelo teste*</label>
                                <div id="invalidFeedbackResponsibleUpdate" class="invalid-feedback">
                                    Informe o responsável pelo teste.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <select class="form-control" id="testApprovedUpdate" name="testApprovedUpdate" placeholder="Teste Aprovado?" v-model="testApprovedUpdate">
                                    <option value="2">Não testado</option>
                                    <option value="0">Reprovado</option>
                                    <option value="1">Aprovado</option>
                                </select>
                                <label class="form-label">Teste Aprovado?</label>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success texto_branco" @click="updateTest()">Salvar</button>
            </template>
        </modal-component>
        <!-- Modal para adicionar Testes -->
        <modal-component id="modalAddEscapePoint" title="Adicionar Ponto de Escape">
            <template v-slot:conteudo>
                <div class="form-group">
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="detectionStage" name="detectionStage" v-model="detectionStage">
                                <label class="form-label">Etapa onde o defeito deveria ter sido detectado*</label>
                                <div id="invalidFeedbackDetectionStage" class="invalid-feedback">
                                    Informe a etapa onde o defeito deveria ter sido detectado
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <textarea class="form-control" id="whyNot" name="whyNot" rows="10" v-model="whyNot" style="height: auto;"></textarea>
                                <label class="form-label">Por que não foi detectado?*</label>
                                <div id="invalidFeedbackWhyNot" class="invalid-feedback">
                                    Informe por que não foi detectado?.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 mt-2">
                            <div class="form-floating">
                                <textarea class="form-control" id="improvementPlan" name="improvementPlan" rows="10" v-model="improvementPlan" style="height: auto;"></textarea>
                                <label class="form-label">Resuma o Plano de Melhoria*</label>
                                <div id="invalidFeedbackImprovementPlan" class="invalid-feedback">
                                    Resuma o Plano de Melhoria
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success texto_branco" @click="saveEscapePoint()">Salvar</button>
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
                statusFiveWhy: '',
                feedbackTitleFiveWhy: '',
                feedbackMessageFiveWhy: '',
                statusRootCauseStore: '',
                feedbackTitleRootCauseStore: '',
                feedbackMessageRootCauseStore: '',
                urlBase: utils.API_URL + '/api/v1/incident/rootcausepotential',
                urlUser: utils.API_URL + '/api/v1/user',
                urlFiveWhy: utils.API_URL + '/api/v1/incident/fivewhy',
                urlRootCauseTest: utils.API_URL + '/api/v1/incident/rootcausetest',
                urlEscapePoint: utils.API_URL + '/api/v1/incident/escapepoint',
                environment: [],
                workforce: [],
                method: [],
                machine: [],
                measurement: [],
                material: [],
                description: '',
                category: '',
                rootCauses: {data: {}},
                rootCause: '',
                primeiropq: '',
                segundopq: '',
                terceiropq: '',
                quartopq: '',
                quintopq: '',
                step_number: '',
                step_number_text: '',
                testDescription: '',
                userResponsible: '',
                users: {data: {}},
                testApproved: '2',
                testResult: '',
                why_id: '',
                rootCauseTestList: {data: {}},
                testDescriptionUpdate: '',
                testResultUpdate: '',
                userResponsibleUpdate: '',
                testApprovedUpdate: '',
                testId: '',
                identifiedRootCause: {data: {}},
                feedbackMessageEscapePoint: '',
                feedbackTitleEscapePoint: '',
                statusEscapePoint: '',
                improvementPlan: '',
                whyNot: '',
                detectionStage: ''
            }
        },
        methods: {
            setIdentifiedRootCause() {
                let url = this.urlRootCauseTest + '/' + this.visualid + '/approved';
                axios.get(url)
                    .then(response => {
                        this.identifiedRootCause = response.data;
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
            setTest(obj) {
                this.testDescriptionUpdate = obj.description;
                this.testResultUpdate = obj.result;
                this.userResponsibleUpdate = obj.user_id;
                this.testApprovedUpdate = obj.approved;
                this.testId = obj.id;
            },
            updateTest() {
                if (utils.fieldsValidate(['testDescriptionUpdate', 'userResponsibleUpdate'], this)) {
                    let formData = new FormData();
                    formData.append('_method', 'patch');
                    formData.append('description', this.testDescriptionUpdate);
                    formData.append('result', this.testResultUpdate);
                    formData.append('user_id', this.userResponsibleUpdate);
                    formData.append('approved', this.testApprovedUpdate);
                    let config = {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                    let url = this.urlRootCauseTest + '/' + this.testId;
                    axios.post(url, formData, config)
                        .then(response => {
                            this.statusRootCauseStore = 'success';
                            this.feedbackTitleRootCauseStore = "Teste da causa raiz atualizado com sucesso!";
                            utils.closeModal('modalUpdateTest');
                            this.loadTestList();
                            this.setIdentifiedRootCause();
                        })
                        .catch(errors => {
                            this.statusRootCauseStore = 'error';
                            this.feedbackTitleRootCauseStore = "Erro ao atualizar teste da causa raíz";
                            this.feedbackMessageRootCauseStore = {
                                mensagem: errors.response.data.message,
                                dados: errors.response.data.errors
                            };
                            utils.closeModal('modalUpdateTest');
                        })
                    setTimeout(() => {
                        this.feedbackTitleRootCauseStore = "";
                        this.statusRootCauseStore = '';
                        this.feedbackMessageRootCauseStore = {};
                    }, 10000);
                }
            },
            saveEscapePoint() {
                if (utils.fieldsValidate(['improvementPlan', 'whyNot', 'detectionStage'], this)) {
                    let formData = new FormData();
                    formData.append('why_not', this.whyNot);
                    formData.append('improvement_plan', this.improvementPlan);
                    formData.append('detection_stage', this.detectionStage);
                    formData.append('incident_id', this.visualid);
                    let config = {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                    let url = this.urlEscapePoint + '/store';
                    axios.post(url, formData, config)
                        .then(response => {
                            this.statusEscapePoint = 'success';
                            this.feedbackTitleEscapePoint = "Ponto de escape adicionado com sucesso!";
                            utils.closeModal('modalAddEscapePoint');
                            this.loadTestList();
                            this.setIdentifiedRootCause();
                        })
                        .catch(errors => {
                            this.statusEscapePoint = 'error';
                            this.feedbackTitleRootCauseStore = "Erro ao adicionar ponto de escape";
                            this.feedbackTitleEscapePoint = {
                                mensagem: errors.response.data.message,
                                dados: errors.response.data.errors
                            };
                            utils.closeModal('modalAddEscapePoint');
                        })
                    setTimeout(() => {
                        this.feedbackTitleEscapePoint = "";
                        this.statusEscapePoint = '';
                        this.feedbackMessageEscapePoint = {};
                    }, 10000);
                }
            },
            saveTest() {
                if (utils.fieldsValidate(['testDescription', 'userResponsible'], this)) {
                    let formData = new FormData();
                    formData.append('description', this.testDescription);
                    formData.append('result', this.testResult);
                    formData.append('user_id', this.userResponsible);
                    formData.append('approved', this.testApproved);
                    formData.append('five_whys_id', this.why_id);
                    formData.append('incident_id', this.visualid);
                    let config = {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                    let url = this.urlRootCauseTest + '/store';
                    axios.post(url, formData, config)
                        .then(response => {
                            this.statusRootCauseStore = 'success';
                            this.feedbackTitleRootCauseStore = "Teste da causa raiz adicionado com sucesso!";
                            utils.closeModal('modalAddTest');
                            this.loadTestList();
                            this.setIdentifiedRootCause();
                        })
                        .catch(errors => {
                            this.statusRootCauseStore = 'error';
                            this.feedbackTitleRootCauseStore = "Erro ao adicionar teste da causa raíz";
                            this.feedbackMessageRootCauseStore = {
                                mensagem: errors.response.data.message,
                                dados: errors.response.data.errors
                            };
                            utils.closeModal('modalAddTest');
                        })
                    setTimeout(() => {
                        this.feedbackTitleRootCauseStore = "";
                        this.statusRootCauseStore = '';
                        this.feedbackMessageRootCauseStore = {};
                    }, 10000);
                }
            },
            saveFiveWhys() {
                if (utils.fieldsValidate(['rootCause', 'primeiropq', 'step_number'], this)) {
                    let whys = [];
                    whys.push(this.primeiropq);
                    if (this.segundopq) {
                        whys.push(this.segundopq);
                    }
                    if (this.terceiropq) {
                        whys.push(this.terceiropq);
                    }
                    if (this.quartopq) {
                        whys.push(this.quartopq);
                    }
                    if (this.quintopq) {
                        whys.push(this.quintopq);
                    }
                    let formData = new FormData();
                    formData.append('whys', whys);
                    formData.append('root_cause_potentials_id', this.rootCause);
                    formData.append('root_cause_potentials_incidents_id', this.visualid);
                    formData.append('step_number', this.step_number);
                    let config = {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                    let url = this.urlFiveWhy + '/store';
                    axios.post(url, formData, config)
                        .then(response => {
                            this.statusFiveWhy = 'success';
                            this.feedbackTitleFiveWhy = "Análise dos porquês salva com sucesso!";
                            this.loadFiveWhys();
                        })
                        .catch(errors => {
                            this.statusFiveWhy = 'error';
                            this.feedbackTitleFiveWhy = "Erro ao salvar análise dos 5 porquês";
                            this.feedbackMessageFiveWhy = {
                                mensagem: errors.response.data.message,
                                dados: errors.response.data.errors
                            };
                        })
                    setTimeout(() => {
                        this.feedbackTitleFiveWhy = "";
                        this.statusFiveWhy = '';
                        this.feedbackMessageFiveWhy = {};
                    }, 10000);
                }
            },
            setRootCause() {
                let formData = new FormData();
                formData.append('_method', 'patch');
                formData.append('incidents_id', this.visualid);
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }
                let url = this.urlBase + '/' + this.rootCause;
                axios.post(url, formData, config)
                    .then(response => {})
                    .catch(errors => {
                        this.status = 'error';
                        this.feedbackTitle = "Erro ao atualizar ação de contenção ";
                        this.feedbackMessage = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        };
                    })
                this.loadFiveWhys();
            },
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
                        this.feedbackTitle = "Erro ao definir causa raiz";
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
                        this.setRootCauseLoaded();
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
            loadTestList() {
                let url = this.urlRootCauseTest + '/' + this.visualid;
                axios.get(url)
                    .then(response => {
                        this.rootCauseTestList = response.data;
                        setTimeout(() => {
                            this.feedbackTitleRootCauseStore = "";
                            this.statusRootCauseStore = '';
                            this.feedbackMessageRootCauseStore = {};
                        }, 10000);
                    })
                    .catch(errors => {
                        if (errors.response.status == 500) {
                            this.feedbackTitleRootCauseStore = "Erro no servidor";
                            this.statusRootCauseStore = 'error';
                            this.feedbackMessageRootCauseStore = {mensagem: "Desculpe, não conseguimos processar a sua requisição, tente novamente ou entre em contato com a equipe de suporte"}
                        } else {
                            this.feedbackTitleRootCauseStore = "Houve um erro";
                            this.statusRootCauseStore = 'error';
                            this.feedbackMessageRootCauseStore = errors;
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
            loadFiveWhys() {
                let url = this.urlFiveWhy + '/' + this.visualid + '/' + this.rootCause;
                axios.get(url)
                    .then(response => {
                        const firstpq = response.data.data.find(item => item.step_number === 1);
                        const secondpq = response.data.data.find(item => item.step_number === 2);
                        const thirdpq = response.data.data.find(item => item.step_number === 3);
                        const fourthpq = response.data.data.find(item => item.step_number === 4);
                        const fifthpq = response.data.data.find(item => item.step_number === 5);
                        const stepNumber = response.data.data.find(item => item.is_root_cause === 1);
                        this.primeiropq = firstpq ? firstpq.why : '';
                        this.segundopq = secondpq ? secondpq.why : '';
                        this.terceiropq = thirdpq ? thirdpq.why : '';
                        this.quartopq = fourthpq ? fourthpq.why : '';
                        this.quintopq = fifthpq ? fifthpq.why : '';
                        if (stepNumber) {
                            this.step_number = stepNumber.step_number;
                            this.step_number_text = stepNumber.why
                            this.why_id = stepNumber.id;
                        }
                        

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
                    this.loadTestList();
            },
            setRootCauseLoaded() {
                const rootCause = this.rootCauses.data.find(item => item.is_root_cause === 1);
                if (rootCause) {
                    this.rootCause = rootCause.id;
                    this.loadFiveWhys();
                }
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
            this.loadRootCausePotentialList();
            this.loadActiveUsers();
            this.setIdentifiedRootCause();
        }
    }
</script>
