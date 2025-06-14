<template>
    <div class="container">
        <breadcrumb-component
            :itens="{
                text:['Perfil', 'Minha Conta'],
                num: '2'
            }"
        ></breadcrumb-component>
        <div class="form-group">
            <input type="hidden" class="form-control" id="id" name="id" v-model="id">
            <div class="row mt-2">
                <div class="col-sm-12 mt-3">
                    <alert-component type="danger" :details="message" :title="title" v-if="status == 'erro'"></alert-component>
                    <alert-component type="success" :details="message" :title="title" v-if="status == 'sucesso'"></alert-component>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Nome Completo*" v-model="name">
                        <label class="form-label">Nome Completo*</label>
                        <div id="invalidFeedbackFullName" class="invalid-feedback">
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
                        <input type="password" class="form-control" id="password" name="password" placeholder="Senha" v-model="password">
                        <label class="form-label">Senha</label>
                        <div id="invalidFeedbackPassword" class="invalid-feedback">
                            Informe a senha.
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 mt-2">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="Repetir Senha" v-model="repeatPassword">
                        <label class="form-label">Repetir Senha</label>
                        <div id="invalidFeedbackPassword" class="invalid-feedback">
                            Esta senha não confere com a senha digitada no campo anterior ou está vazio.
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 mt-2">
                    <button type="button" class="btn btn-success texto_branco w-100" @click="update()">Atualizar</button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 mt-2">
                    <label class="form-label"><i>Primeiro acesso:</i> {{ user.first_login | formatDateTime}}</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label class="form-label"><i>Último acesso:</i> {{ user.last_login | formatDateTime }}</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label class="form-label"><i>Data de criação:</i> {{ user.created_at | formatDateTimeStamp }}</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label class="form-label"><i>Última atualização: </i> {{ user.updated_at | formatDateTimeStamp }}</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import * as utils from '../utils/functions';
    export default {
        props: ['user'],
        data() {
            return {
                name: this.user.name,
                email: this.user.email,
                id: this.user.id,
                password: '',
                repeatPassword: '',
                urlBase: utils.API_URL + '/api/v1/user',
                message: {},
                title: '',
                status: ''
            }
        },
        methods: {
            update() {
                if (this.$store.state.item.name == ''){
                    document.getElementById('fullName').classList.add('is-invalid');
                } else if (this.password != this.repeatPassword) {
                    document.getElementById('repeatPassword').classList.add('is-invalid');
                } else {
                    if (document.getElementById('fullName').classList.contains('is-invalid')) {
                        document.getElementById('fullName').classList.remove('is-invalid');
                    }
                    if (document.getElementById('repeatPassword').classList.contains('is-invalid')) {
                        document.getElementById('repeatPassword').classList.remove('is-invalid');
                    }
                    let formData = new FormData();
                    formData.append('_method', 'patch');
                    formData.append('name', this.name);
                    formData.append('email', this.email);
                    formData.append('password', this.password);

                    let config = {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                    let url = this.urlBase + '/' + this.id;
                    axios.post(url, formData, config)
                        .then(response => {
                            this.status = 'sucesso';
                            this.title = "Usuário atualizado com sucesso";
                            this.password = '';
                            this.repeatPassword = '';
                        })
                        .catch(errors => {
                            this.status = 'error';
                            this.title = "Erro ao atualizar usuário";
                            this.message = {
                                message: errors.response.data.message,
                                data: errors.response.data.errors
                            };
                        })
                }
            },
        }
    }
</script>