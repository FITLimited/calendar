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
Vue.component('user', require('./components/calendar/User.vue'));
Vue.component('event', require('./components/calendar/Event.vue'));

Vue.http.options.root = "http://calendar.app";
Vue.http.headers.common['Authorization'] = 'Bearer ' + Vue.auth.getToken();

const calendar = new Vue({
    el: '#app',
    router: Router,
});

