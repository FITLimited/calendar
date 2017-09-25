import Vue from 'vue';
import {appUrl} from '../config';

export default {
    users() {
        return Vue.http.get(appUrl + 'users');
    },

    create(user) {
        return Vue.http.post(appUrl + 'register', user);
    },

    update(user) {
        return Vue.http.post(appUrl + 'users/update', user);
    },

    remove(userId) {
        return Vue.http.get(appUrl + 'users/remove/' + userId);
    }
}