require('./bootstrap');
var VueMaterial = require('vue-material');

window.Vue = require('vue')

import VueResource from 'vue-resource'
import VeeValidate from 'vee-validate'
import Auth from './packages/auth/Auth.js'
import Router from './route.js'

Vue.component('app-menu', require('./components/Menu.vue'))
Vue.component('login', require('./components/login/Login.vue'))

Vue.use(VueResource)
Vue.use(Auth)
Vue.use(VueMaterial)
Vue.use(VeeValidate)


//Vue.http.options.root = "https://c.fit-limited.com/public";
Vue.http.options.root = "http://localhost";
Vue.http.headers.common['Authorization'] = 'Bearer ' + Vue.auth.getToken();

Router.beforeEach(
    (to, from, next) => {
        if (to.matched.some(record => record.meta.forVisitors)) {
            if (Vue.auth.isAuthenticated()) {
                next({
                    path: '/calendar'
                })
            } else next()
        } else if (to.matched.some(record => record.meta.forAuth)) {
            if (!Vue.auth.isAuthenticated()) {
                next({
                    path: '/login'
                })
            } else next()
        }

        else next()
    }
);

const calendar = new Vue({
    el: '#app',
    router: Router,
    data: {
      isAuth: false
    },
    methods: {

    }
});

