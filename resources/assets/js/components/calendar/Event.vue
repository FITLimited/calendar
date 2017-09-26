<template>
    <div>
        <div id="calendar">
            <div class="calendar-table">
                <div class="row-table date">
                    <div class="col-table" v-for="day in days" :style="{ 'width' : width + 'px' }">
                        <br>
                        {{ day.day }}<br>
                        <small>{{ day.weekDay }}</small>
                    </div>
                </div>
                <div v-for="user in users" class="row-table user-events">
                    <div class="col-table" v-for="day in days" :style="{ 'width' : width + 'px' }"
                        :class="{ 'weekend': (day.weekDay == 'Sun' || day.weekDay == 'Sat') }">
                            <span
                                    :class="event.type"
                                    v-for="event in events"
                                    v-if="event.event_date == day.date && (event.user_id == user.id || event.user_id == 0)"
                                    :style="{ 'width' : width * event.duration + 'px' }"
                            >
                                <md-icon v-if="event.type == 'birthday'">cake</md-icon>
                                <md-icon v-if="event.type == 'disease'">local_hospital</md-icon>
                                <md-icon v-if="event.type == 'performance'">content_paste</md-icon>
                                <md-icon v-if="event.type == 'vac'">beach_access</md-icon>
                                <md-tooltip md-direction="top">{{ event.title }}</md-tooltip>
                                <!--<div>-->
                                    <!--<i><a href="#">Edit</a></i>-->
                                    <!--<i><a href="#">Delete</a></i>-->
                                <!--</div>-->
                            </span>
                    </div>
                </div>
            </div>
        </div>

        <md-dialog md-open-from="#fab" md-close-to="#fab" ref="add_event">
            <md-dialog-title>Add new event</md-dialog-title>
            <md-dialog-content>
                <form id="add_user_form" @submit.prevent="addEvent()">
                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Title Event</label>
                                <md-input data-vv-name="title" v-validate="'required'" v-model="event.title"></md-input>
                            </md-input-container>
                        </div>
                        <div class="col-md-6" style="padding-top: 10px">
                            <md-checkbox name="my-test2" v-model="event.checkbox" class="md-primary">For all
                            </md-checkbox>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>User</label>
                                <md-select name="user" id="user" v-model="event.user_id">
                                    <span v-for="user in users">
                                        <md-option :value="user.id">{{user.name}}</md-option>
                                    </span>
                                </md-select>
                            </md-input-container>
                        </div>

                        <div class="col-md-6">
                            <datepicker v-model="event.date" placeholder="Event date"></datepicker>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Type</label>
                                <md-select name="type" v-model="event.type">
                                    <md-option value="vac">Vac</md-option>
                                    <md-option value="disease">Disease</md-option>
                                    <md-option value="performance">Performance review</md-option>
                                </md-select>
                            </md-input-container>
                        </div>
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Duration (days)</label>
                                <md-input data-vv-name="duration" v-validate="'required|min_value:1'"
                                          v-model="event.duration"></md-input>
                            </md-input-container>
                        </div>
                    </div>
                    <div v-show="errors.first('title')" class="alert alert-danger">
                        {{ errors.first('title') }}
                    </div>
                    <div v-show="errors.first('duration')" class="alert alert-danger">
                        {{ errors.first('duration') }}
                    </div>
                </form>
            </md-dialog-content>
            <md-dialog-actions>
                <md-button class="md-primary" @click.native="closeDialog('add_event')">Cancel</md-button>
                <md-button class="md-primary" type="submit" form="add_user_form">Create</md-button>
            </md-dialog-actions>
        </md-dialog>

        <md-dialog md-open-from="#fab" md-close-to="#fab" ref="edit_event">
            <md-dialog-title>Edit event</md-dialog-title>
            <md-dialog-content>
                <form id="edit_user_form" @submit.prevent="saveEvent()">
                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Title Event</label>
                                <md-input data-vv-name="title" v-validate="'required'" v-model="event.title"></md-input>
                            </md-input-container>
                        </div>
                        <div class="col-md-6" style="padding-top: 10px">
                            <md-checkbox name="my-test2" v-model="event.checkbox" class="md-primary">For all
                            </md-checkbox>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>User</label>
                                <md-select name="user" v-model="event.user_id">
                                    <span v-for="user in users">
                                        <md-option :value="user.id">{{user.name}}</md-option>
                                    </span>
                                </md-select>
                            </md-input-container>
                        </div>

                        <div class="col-md-6">
                            <datepicker v-model="event.date" placeholder="Event date"></datepicker>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Type</label>
                                <md-select name="type" v-model="event.type">
                                    <md-option value="vac">Vac</md-option>
                                    <md-option value="disease">Disease</md-option>
                                    <md-option value="performance">Performance review</md-option>
                                </md-select>
                            </md-input-container>
                        </div>
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Duration (days)</label>
                                <md-input data-vv-name="duration" v-validate="'required|min_value:1'"
                                          v-model="event.duration"></md-input>
                            </md-input-container>
                        </div>
                    </div>
                    <div v-show="errors.first('title')" class="alert alert-danger">
                        {{ errors.first('title') }}
                    </div>
                    <div v-show="errors.first('duration')" class="alert alert-danger">
                        {{ errors.first('duration') }}
                    </div>
                </form>
            </md-dialog-content>
            <md-dialog-actions>
                <md-button class="md-primary" @click.native="closeDialog('add_event')">Cancel</md-button>
                <md-button class="md-primary" type="submit" form="add_user_form">Save</md-button>
            </md-dialog-actions>
        </md-dialog>

        <md-button class="md-fab md-fab-bottom-right" id="fab" @click.native="openDialog('add_event')">
            <md-icon>add</md-icon>
        </md-button>
    </div>
</template>

<script>
    import EventService from '../../services/EventService';
    import datepicker from 'vuejs-datepicker';

    var moment = require('moment');

    export default {
        props: {
            users: null,
            events: null,
            days: null,
        },
        data() {
            return {
                event: {
                    id: "",
                    type: "",
                    date: "",
                    user_id: "",
                    checkbox: "",
                    title: "",
                    duration: ""
                },
                width: ((window.innerWidth * 0.8)) / 31
            }
        },

        mounted() {

        },
        methods: {
            openDialog(ref) {
                this.$refs[ref].open();
            },
            closeDialog(ref) {
                this.$refs[ref].close();
            },
            addEvent() {
                this.$validator.validateAll().then(() => {
                    if (this.checkbox)
                        this.user_id = 0;

                    this.event.date = moment(this.event.date).format('YYYY-MM-DD');

                    EventService.create(this.event).then(() => {
                        this.$parent.getEvents();
                        this.closeDialog('add_event');
                        this.checkbox = false;
                    }, error => {
                        console.log(error);
                    });
                })
            },
            editEvent(event) {
                this.event = event;
                this.openDialog('edit_event');
            },
            saveEvent() {
                this.$validator.validateAll().then(() => {
                    if (this.checkbox)
                        this.user_id = 0;

                    this.event.date = moment(this.event.date).format('YYYY-MM-DD');

                    EventService.update(this.event).then(() => {
                        this.$parent.getEvents();
                        this.closeDialog('add_event');
                        this.checkbox = false;
                    }, error => {
                        console.log(error);
                    });
                })
            }
        },
        components: {
            datepicker
        }
    }
</script>
