import Vue from 'vue';
import {appUrl} from '../config';

export default {
    users() {
        return Vue.http.get(appUrl + 'users');
    }
}