/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vuex from 'Vuex';
Vue.use(Vuex);
const store = new Vuex.Store({
    state: {
        item: {}
    }
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/Login.vue').default);
Vue.component('search-component', require('./components/Search.vue').default);
Vue.component('list-component', require('./components/List.vue').default);
Vue.component('users-component', require('./components/Users.vue').default);
Vue.component('alert-component', require('./components/Alert.vue').default);
Vue.component('modal-component', require('./components/Modal.vue').default);
Vue.component('paginate-component', require('./components/Paginate.vue').default);
Vue.component('breadcrumb-component', require('./components/Breadcrumb.vue').default);
Vue.component('areas-component', require('./components/Areas.vue').default);
Vue.component('no-itens-component', require('./components/NoItens.vue').default);
Vue.component('spinner-component', require('./components/Spinner.vue').default);
Vue.component('profile-component', require('./components/Profile.vue').default);
Vue.component('new-incident-component', require('./components/IncidentNew.vue').default);
Vue.component('orientation-component', require('./components/Orientation.vue').default);
Vue.component('incidents-component', require('./components/Incidents.vue').default);
Vue.component('incident-team-component', require('./components/IncidentTeam.vue').default);
Vue.component('incident-containment-action-component', require('./components/IncidentContainmentAction.vue').default);
Vue.component('root-cause-potential-component', require('./components/IncidentRootCausePotential.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.filter('formatDateTime', function(valor){
    if (!valor) {
        return '-';
    }
    valor = valor.split(' ');
    let data;
    let dataFormatada;

    data = valor[0];
    data = data.split('-');
    dataFormatada = data[2] + '/' + data[1] + '/' + data[0];

    return dataFormatada + ' - ' + valor[1];
})

Vue.filter('formatDateTimeStamp', function(valor){
    if (!valor) {
        return '-';
    }
    valor = valor.split('T');
    
    let data = valor[0];
    let hora = valor[1];
    let dataFormatada;

    // Formatando data
    data = data.split('-');
    dataFormatada = data[2] + '/' + data[1] + '/' + data[0];

    // Formatando hora
    hora = hora.split('.')[0];
    
    return dataFormatada + ' - ' + hora;
})

Vue.filter('formatDate', function(valor){
    if (!valor) {
        return '-';
    }
    valor = valor.split('-');
    let dataFormatada;
    dataFormatada = valor[2] + '/' + valor[1] + '/' + valor[0];

    return dataFormatada;
})

Vue.filter('formatStatus', function(valor) {
    let status= {
        '0': 'Inativo',
        '1': 'Ativo',
        '2': 'Bloqueado'
    };
    return status[valor];
});

Vue.filter('formatStatusIncident', function(valor) {
    let status= {
        'Not Started': 'Não iniciado',
        'In Progress': 'Em andamento',
        'Canceled': 'Cancelado',
        'On hold': 'Em espera',
        'Finished': 'Concluído'
    };
    return status[valor];
});

Vue.filter('formatProfile', function(valor) {
    let profile = {
        'superadmin': 'Super Administrador',
        'administrator': 'Administrador',
        'manager': 'Gestor',
        'user': 'Usuário'
    };
    return profile[valor];
});

Vue.filter('formatNextPrevButton', function(valor) {
    if (valor === '&laquo; Previous') {
        return '<< Anterior';
    } else if (valor === 'Next &raquo;') {
        return 'Próximo >>';
    }
    return valor;
});

const app = new Vue({
    el: '#app',
    store
});
