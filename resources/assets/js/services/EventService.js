import Vue from 'vue';
import {appUrl} from '../config';

export default {
    events(from, to) {
        return Vue.http.get(appUrl + 'events/?from=' + from + "&to=" + to);
    },
    create(event) {
        return Vue.http.post(appUrl + 'events/create', event);
    },
}