import Vue from 'vue';
import VueRouter from 'vue-router';

import Login from './components/login/Login.vue';
import Calendar from './components/calendar/Calendar.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: Login,
            meta: {
                forVisitors: true
            }
        },
        {
            path: '/login',
            component: Login,
            meta: {
                forVisitors: true
            }
        },
        {
            path: '/calendar',
            component: Calendar,
            meta: {
                forAuth: true
            }
        }
    ]
});

export default router