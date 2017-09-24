import Vue from 'vue';
import {appUrl} from '../config';

export default {
    login(data) {
        return Vue.http.post(appUrl + 'login', data);
    },

    getSelf() {
        return Vue.http.get(appUrl + 'users/self');
    }
}