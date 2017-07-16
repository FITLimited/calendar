<template>
    <div>
        <md-dialog md-open-from="#fab" md-close-to="#fab" ref="add_event">
            <md-dialog-title>Add new event</md-dialog-title>
            <md-dialog-content>
                <form id="add_user_form" @submit.prevent="addEvent('add_event')">
                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Title Event</label>
                                <md-input data-vv-name="title" v-validate="'required'" v-model="title"></md-input>
                            </md-input-container>
                        </div>
                        <div class="col-md-6" style="padding-top: 10px">
                            <md-checkbox id="my-test2" name="my-test2" v-model="checkbox" class="md-primary">For all
                            </md-checkbox>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>User</label>
                                <md-select name="user" id="user" v-model="user_id">
                        <span v-for="user in userList">
                            <md-option :value="user.id">{{user.name}}</md-option>
                        </span>
                                </md-select>
                            </md-input-container>
                        </div>

                        <div class="col-md-6">
                            <datepicker v-model="date" placeholder="Event date"></datepicker>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Type</label>
                                <md-select name="type_event" id="type_event" v-model="type_event">
                                    <md-option value="vac">Vac</md-option>
                                    <md-option value="disease">Disease</md-option>
                                    <md-option value="performance">Performance review</md-option>
                                </md-select>
                            </md-input-container>
                        </div>
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Duration (days)</label>
                                <md-input  data-vv-name="duration" v-validate="'required|min_value:1'" v-model="duration"></md-input>
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

        <md-button class="md-fab md-fab-bottom-right" id="fab" @click.native="openDialog('add_event')">
            <md-icon>add</md-icon>
        </md-button>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    var moment = require('moment');
    export default {
        data(){
            return {
                userList: "",
                type_event: "",
                date: "",
                user_id: "",
                eventList: "",
                checkbox: "",
                title: "",
                duration: ""
            }
        },
        created(){

        },
        methods: {
            openDialog(ref) {
                this.$refs[ref].open();
                this.userList = this.$parent.userList;
            },
            closeDialog(ref) {
                this.$refs[ref].close();
            },
            addEvent(ref){

                this.$validator.validateAll().then(()=>{
                    if (this.checkbox)
                        this.user_id = 0;

                    var data = {
                        user_id: this.user_id,
                        type: this.type_event,
                        date: moment(this.date).format('YYYY-MM-DD h:mm:ss'),
                        title: this.title,
                        duration: this.duration
                    };
                    this.$http.post('api/events/create', data).then(responce => {
                        this.$parent.eventList.push(responce.body);
                        this.$parent.getEvents();
                        this.$refs[ref].close();
                        this.checkbox = false;
                    });
                })
            }
        },
        components: {
            Datepicker
        }
    }
</script>