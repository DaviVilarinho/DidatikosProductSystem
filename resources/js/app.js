/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        cities: [],
        citiesById: {},
        citiesIdByNome: {},
        API_ROUTE: '',
        PRODUCT_API_ROUTE: '',
        CIDADE_API_ROUTE: '',
    },
    mounted() {
        this.API_ROUTE = '/api';
        this.PRODUCT_API_ROUTE = this.API_ROUTE + '/products';
        this.CIDADE_API_ROUTE = this.API_ROUTE + '/cidade';

        if (localStorage.getItem('cities')) {
            this.cities = JSON.parse(localStorage.getItem('cities'));
        } else {
            this.cities = [{ id: '1', nome: 'São Paulo' }];

            localStorage.setItem('cities', JSON.stringify(this.cities));
        }

        if (localStorage.getItem('citiesById')) {
            this.citiesById = JSON.parse(localStorage.getItem('citiesById'));
        } else {
            this.citiesById = this.cities.reduce((obj, city) => {
                obj[city.id] = city.nome;
                return obj;
            }, {});

            localStorage.setItem('citiesById', JSON.stringify(this.citiesById));
        }

        if (localStorage.getItem('citiesIdByNome')) {
            this.citiesIdByNome = JSON.parse(localStorage.getItem('citiesIdByNome'));
        } else {
            this.citiesIdByNome = this.cities.reduce((obj, city) => {
                obj[city.nome] = city.id;
                return obj;
            }, {});

            localStorage.setItem('citiesIdByNome', JSON.stringify(this.citiesIdByNome));
        }
    }
});
