import vue from "vue";
import VueResource from 'vue-resource'
import VeeValidate from 'vee-validate'
import VueMaterial from "vue-material";
import Auth from './packages/auth/Auth.js'
import Router from './route.js'

window.Vue = vue;

vue.component('app-menu', require('./components/Menu.vue'));
vue.component('login', require('./components/login/Login.vue'));

vue.use(VueResource);
vue.use(VueMaterial);
vue.use(VeeValidate);
vue.use(Auth);

// Vue.http.options.root = "http://calendar.app";
// Vue.http.headers.common['Authorization'] = 'Bearer ' + Vue.auth.getToken();
//
// Router.beforeEach(
//     (to, from, next) => {
//         if (to.matched.some(record => record.meta.forVisitors)) {
//             if (Vue.auth.isAuthenticated()) {
//                 next({
//                     path: '/calendar'
//                 })
//             } else next()
//         } else if (to.matched.some(record => record.meta.forAuth)) {
//             if (!Vue.auth.isAuthenticated()) {
//                 next({
//                     path: '/login'
//                 })
//             } else next()
//         }
//
//         else next()
//     }
// );

const calendar = new Vue({
    el: '#app',
    router: Router,
});

