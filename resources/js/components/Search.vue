<template>
    <div>
        <div class="row mt-4">
            <div class="col-sm-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="buscar" name="buscar" :placeholder="placeholder" v-model="searchFilter">
                    <label class="form-label">{{ placeholder }}</label>
                </div>
            </div>

            <!-- BOTÃO BUSCAR  -->
            <div v-if="buttons.search.show"  class="col-sm-2 mt-1">
                <!-- Se botão for do tipo apply -->
                <button class="w-100 btn btn-lg background-color-8dmasptool-btn" @click="search()" v-if="buttons.search.type=='apply'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                    Buscar
                </button>
                <!-- Se botão for do tipo redirectNewTab -->
                <a class="w-100 btn btn-primary btn-lg background-color-8dmasptool-btn" href="#" v-if="buttons.search.type=='redirectNewTab'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                    Buscar
                </a>
                <!-- Se botão for do tipo redirectOpenNewTab -->
                <a class="w-100 btn btn-primary btn-lg background-color-8dmasptool-btn" href="#" target="_blank" v-if="buttons.search.type=='redirectOpenNewTab'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                    Buscar
                </a>
                <!-- Se botão for do tipo modal -- PRECISA IMPLEMENTAR AINDA  -->
                <button class="w-100 btn btn-primary btn-lg background-color-8dmasptool-btn" @click="add()" v-if="buttons.search.type=='modal'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                    Buscar
                </button>
            </div>

            <!-- BOTÃO LIMPAR  -->
            <div v-if="buttons.clear.show" class="col-sm-2 mt-1">
                <!-- Se botão for do tipo apply -->
                <button class="w-100 btn btn-warning btn-lg" @click="clear()" v-if="buttons.clear.type=='apply'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                    Limpar
                </button>
                <!-- Se botão for do tipo redirectNewTab -->
                <a class="w-100 btn btn-warning btn-lg" href="#" v-if="buttons.clear.type=='redirectNewTab'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                    Limpar
                </a>
                <!-- Se botão for do tipo redirectOpenNewTab -->
                <a class="w-100 btn btn-warning btn-lg" href="#" target="_blank" v-if="buttons.clear.type=='redirectOpenNewTab'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                    Limpar
                </a>
                <!-- Se botão for do tipo modal -- PRECISA IMPLEMENTAR AINDA  -->
                <button class="w-100 btn btn-warning btn-lg" @click="add()" v-if="buttons.clear.type=='modal'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                    Limpar
                </button>
            </div>

            <!-- BOTÃO ADICIONAR  -->
            <div v-if="buttons.add.show" class="col-sm-2 mt-1">
                <!-- Se botão for do tipo apply -->
                <button class="w-100 btn btn-secondary btn-lg" @click="add()" v-if="buttons.add.type=='apply'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                    Adicionar
                </button>
                <!-- Se botão for do tipo redirectNewTab -->
                <a class="w-100 btn btn-secondary btn-lg" href="#" v-if="buttons.add.type=='redirectNewTab'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                    Adicionar
                </a>
                <!-- Se botão for do tipo redirectOpenNewTab -->
                <a class="w-100 btn btn-secondary btn-lg" href="#" target="_blank" v-if="buttons.add.type=='redirectOpenNewTab'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                    Adicionar
                </a>
                <!-- Se botão for do tipo modal -->
                <button class="w-100 btn btn-secondary btn-lg" data-bs-toggle="modal" :data-bs-target="buttons.add.modalId" v-if="buttons.add.type=='modal'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                    Adicionar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import { EventBus } from "./eventBus.js";
    export default {
        data() {
            return {
                searchFilter: ''
            }
        },
        methods: {
            add() {
                
            },
            search() {
                let filter = '';
                let fields = this.buttons.search.fields;
                let paginate = '';
                let urlFilter = '';
                fields.forEach((field, key) => {
                    if (filter != ''){
                        filter += ';';
                    }
                    filter += field + ':like:%' + this.searchFilter+ '%'
                });
                if (filter) {
                    paginate = 'page=1';
                    urlFilter = `&filter=${encodeURIComponent(filter)}`;
                    EventBus.$emit("setUrlFilter", urlFilter);
                } else {
                    urlFilter = '';
                }
                if (this.classSearch === 'user') {
                    EventBus.$emit("loadUserList");
                } else if (this.classSearch === 'area') {
                    EventBus.$emit("loadAreaList");
                }
            },
            clear() {
                EventBus.$emit("setUrlFilter", '');
                if (this.classSearch === 'user') {
                    EventBus.$emit("loadUserList");
                } else if (this.classSearch === 'area') {
                    EventBus.$emit("loadAreaList");
                }
                this.searchFilter = '';
            },
        },
        props: ['title', 'buttons', 'placeholder', 'classSearch'],
    }
</script>
