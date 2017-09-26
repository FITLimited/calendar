<template>
    <div>
        <ul class="user-list">
            <li>
                <md-button @click.native="prevMonth" class="md-raised md-primary no-padding"> <</md-button>
                <md-button @click.native="nextMonth" class="md-raised md-primary no-padding"> ></md-button>
                <span style="padding: 0 10px">{{ date | moment("MMMM, YYYY") }}</span>
                <md-button class="md-icon-button md-raised md-primary" id="us" @click.native="openDialog('add_user')">
                    <md-icon>person_add</md-icon>
                </md-button>
            </li>
            <li v-for="user in users">
                <a href="#">{{ user.name }}</a>
                <md-button v-if="auth_user && auth_user.role.role == 'Admin'" class="md-accent user-remove"
                           @click.native="removeUser(user)">
                    <md-icon>indeterminate_check_box</md-icon>
                </md-button>
                <md-button v-if="auth_user && auth_user.role.role == 'Admin'" class="md-accent user-edit"
                           @click.native="editUser(user)">
                    <md-icon>create</md-icon>
                </md-button>
            </li>
        </ul>

        <md-dialog md-open-from="#us" md-close-to="#us" ref="add_user">
            <md-dialog-title>Add new user</md-dialog-title>
            <md-dialog-content>
                <form id="add_user_form" @submit.prevent="addUser()">
                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Name</label>
                                <md-input data-vv-name="name" v-validate="'required'" v-model="user.name"></md-input>
                            </md-input-container>
                        </div>
                        <div class="col-md-6">
                            <datepicker data-vv-name="birthday" v-validate="'required'" v-model="user.birthday" placeholder="Birthday"></datepicker>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Email</label>
                                <md-input data-vv-name="email" v-validate="'required|email'" type="email" v-model="user.email"></md-input>
                            </md-input-container>
                        </div>
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Password</label>
                                <md-input data-vv-name="password" v-validate="'required|min:6'" type="password" v-model="user.password"></md-input>
                            </md-input-container>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <datepicker data-vv-name="working_from" v-validate="'required'" v-model="user.working_from" placeholder="Beginning of work"></datepicker>
                        </div>
                    </div>
                    <div v-show="errors.first('name')" class="alert alert-danger">
                        {{ errors.first('name') }}
                    </div>
                    <div v-show="errors.first('birthday')" class="alert alert-danger">
                        {{ errors.first('birthday') }}
                    </div>
                    <div v-show="errors.first('email')" class="alert alert-danger">
                        {{ errors.first('email') }}
                    </div>
                    <div v-show="errors.first('password')" class="alert alert-danger">
                        {{ errors.first('password') }}
                    </div>
                </form>
            </md-dialog-content>
            <md-dialog-actions>
                <md-button class="md-primary" @click.native="closeDialog('add_user')">Cancel</md-button>
                <md-button class="md-primary" type="submit" form="add_user_form">Add</md-button>
            </md-dialog-actions>
        </md-dialog>

        <md-dialog md-open-from="#us" md-close-to="#us" ref="edit_user">
            <md-dialog-title>Edit user</md-dialog-title>
            <md-dialog-content>
                <form id="edit_user_form" @submit.prevent="saveUser()">
                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Name</label>
                                <md-input data-vv-name="name" v-validate="'required'" v-model="user.name"></md-input>
                            </md-input-container>
                        </div>
                        <div class="col-md-6">
                            <datepicker data-vv-name="birthday" v-validate="'required'" v-model="user.birthday" placeholder="Birthday"></datepicker>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Email</label>
                                <md-input data-vv-name="email" v-validate="'required|email'" type="email" v-model="user.email"></md-input>
                            </md-input-container>
                        </div>
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Password</label>
                                <md-input data-vv-name="password" type="password" v-model="user.password"></md-input>
                            </md-input-container>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <datepicker data-vv-name="working_from" v-validate="'required'" v-model="user.working_from" placeholder="Beginning of work"></datepicker>
                        </div>
                    </div>
                    <div v-show="errors.first('name')" class="alert alert-danger">
                        {{ errors.first('name') }}
                    </div>
                    <div v-show="errors.first('birthday')" class="alert alert-danger">
                        {{ errors.first('birthday') }}
                    </div>
                    <div v-show="errors.first('email')" class="alert alert-danger">
                        {{ errors.first('email') }}
                    </div>
                </form>
            </md-dialog-content>
            <md-dialog-actions>
                <md-button class="md-primary" @click.native="closeDialog('edit_user')">Cancel</md-button>
                <md-button class="md-primary" type="submit" form="edit_user_form">Save</md-button>
            </md-dialog-actions>
        </md-dialog>
    </div>
</template>

<script>
    import UserService from '../../services/UserService';

    import datepicker from 'vuejs-datepicker';

    var moment = require('moment');

    export default {
        props: {
            users: null,
            auth_user: null
        },
        data() {
            return {
                date: new Date(),
                user: {
                    id: "",
                    name: "",
                    birthday: "",
                    working_from: "",
                    email: "",
                    password: ""
                }
            }
        },

        methods: {
            openDialog(ref) {
                this.$refs[ref].open();
            },
            closeDialog(ref) {
                this.$refs[ref].close();
            },
            nextMonth() {
                this.$parent.nextMonth();
            },
            prevMonth() {
                this.$parent.prevMonth();
            },
            editUser(user) {
                this.user = user;
                this.user.birthday = user.user_birthday;
                this.user.working_from = user.user_working_from;

                this.openDialog('edit_user');
            },
            addUser() {
                this.$validator.validateAll().then(() => {

                    this.user.birthday = moment(this.user.birthday).format('YYYY-MM-DD');
                    this.user.working_from = moment(this.user.working_from).format('YYYY-MM-DD');

                    UserService.create(this.user).then(() => {

                        this.$parent.getUsers();
                        this.$parent.getEvents();

                        this.closeDialog('add_user');
                    }, error => {
                        console.log(error);
                    });
                });
            },
            saveUser() {
                this.$validator.validateAll().then(() => {

                    this.user.birthday = moment(this.user.birthday).format('YYYY-MM-DD');
                    this.user.working_from = moment(this.user.working_from).format('YYYY-MM-DD');

                    UserService.update(this.user).then(() => {

                        this.$parent.getUsers();
                        this.$parent.getEvents();

                        this.closeDialog('edit_user');
                    }, error => {
                        console.log(error);
                    });
                });
            },
            removeUser(user) {
                UserService.remove(user.id).then(() => {

                    this.$parent.getUsers();
                    this.$parent.getEvents();

                }, error => {
                    console.log(error);
                });
            }
        },
        components: {
            datepicker
        }
    }
</script>
