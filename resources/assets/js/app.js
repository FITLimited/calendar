import Vue from 'vue';
import VueResource from 'vue-resource';
import VeeValidate from 'vee-validate';
import VueMaterial from 'vue-material';
import VueMoment from 'vue-moment';
import Auth from './packages/auth/Auth.js'
import Router from './route.js'

Vue.use(VueResource);
Vue.use(VueMaterial);
Vue.use(VeeValidate);
Vue.use(VueMoment);
Vue.use(Auth);

Vue.component('calendar', require('./components/calendar/Calendar.vue'));
Vue.component('app-menu', require('./components/Menu.vue'));
Vue.component('login', require('./components/login/Login.vue'));

Vue.http.options.root = "http://calendar.app";
Vue.http.headers.common['Authorization'] = 'Bearer ' + Vue.auth.getToken();
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

