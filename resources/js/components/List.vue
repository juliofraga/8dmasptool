<template>
    <div class="mt-3" v-if="(Array.isArray(data) && data.length === 0)">
        <alert-component type="warning" title="Não foram encontratos resultados"></alert-component>
    </div>
    <div class="mt-2" v-else>
        <alert-component type="danger" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'erro'"></alert-component>
        <alert-component type="success" :details="feedbackMessage" :title="feedbackTitle" v-if="status == 'sucesso'"></alert-component>
        <div class="row mt-3">
            <div v-for="t, key in title" :key="key" :class="`col-sm-${t.length}`" >
                <b v-if="t.type != 'buttonModal' && t.length != 'hidden'">{{ t.title }}</b>
            </div>
        </div>
        <hr>
        <div class="row mt-4 border-bottom resultado-consultas-row" v-for="obj, key in filteredData" :key="key">
            <div :class="`col-sm-${title[keyValue].length}`" v-for="value, keyValue in obj" :key="keyValue">
                <span 
                    v-if="
                        title[keyValue].type == 'text' && 
                        title[keyValue].length != 'hidden' && 
                        keyValue != 'profile'
                    "
                    style="display: block; text-align: justify;"
                    >
                     {{ value }}
                </span>
                <span v-if="keyValue == 'profile'"> {{ value | formatProfile }}</span>
                <span v-if="title[keyValue].type == 'datetime' && title[keyValue].length != 'hidden'"> {{ value | formatDateTime }}</span>
                <span v-if="title[keyValue].type == 'datetimestamp' && title[keyValue].length != 'hidden'"> {{ value | formatDateTimeStamp }}</span>
                <span v-if="title[keyValue].type == 'ativoInativo' && title[keyValue].length != 'hidden'"> {{ value | formatStatus }}</span>
                <span v-if="title[keyValue].type == 'date' && title[keyValue].length != 'hidden'"> {{ value | formatDate }}</span>
                <span v-if="title[keyValue].type == 'status-incident'"> {{ value | formatStatusIncident }}</span>
                <button v-if="title[keyValue].type == 'buttonModal' && title[keyValue].length != 'hidden'" class="btn btn-outline-dark w-100" data-bs-toggle="modal" :data-bs-target="title[keyValue].modalId" @click="setStore(obj)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                    </svg>
                    {{ title[keyValue].title }}
                </button>
                <a :href="`${urlRedirect}/${obj.visual_id}`">
                    <button v-if="title[keyValue].type == 'buttonRedirected' && title[keyValue].length != 'hidden'" class="btn btn-outline-secondary w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                        {{ title[keyValue].title }}
                    </button>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                urlRedirect: ''
            }
        },
        props: ['title', 'data', 'status', 'feedbackTitle', 'feedbackMessage'],
        methods: {
            setStore(obj) {
                this.$store.state.item = obj;
            },
            setUrlRedirect() {
                if (this.title.view) {
                    this.urlRedirect = this.title.view.url;
                }
            }
        },
        computed: {
            filteredData(){
                if (Array.isArray(this.data)) {
                    let fields = Object.keys(this.title);
                    let filteredData = [];
                    this.data.map((item, key) => {
                        let filteredItem = {};
                        fields.forEach(field => {
                            filteredItem[field] = item[field]
                        });
                        filteredData.push(filteredItem);
                    });
                    return filteredData;
                }
            }
        },
        mounted() {
            this.setUrlRedirect();
        }
    }
</script>
