<template>
    <div>
        <md-dialog md-open-from="#us" md-close-to="#us" ref="add_user">
            <md-dialog-title>Add new user</md-dialog-title>
            <md-dialog-content>
                <form id="add_user_form" @submit.prevent="createUser('add_user')">
                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Name</label>
                                <md-input data-vv-name="name" v-validate="'required'" v-model="user.name"></md-input>
                            </md-input-container>
                        </div>
                        <div class="col-md-6">
                            <datepicker data-vv-name="birthday" v-validate="'required'" v-model="user.birthday"
                                        placeholder="Birthday"></datepicker>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Email</label>
                                <md-input data-vv-name="email" v-validate="'required|email'" type="email"
                                          v-model="user.email"></md-input>
                            </md-input-container>
                        </div>
                        <div class="col-md-6">
                            <md-input-container>
                                <label>Password</label>
                                <md-input data-vv-name="password" v-validate="'required|min:6'" type="password"
                                          v-model="user.password"></md-input>
                            </md-input-container>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <datepicker data-vv-name="working_from" v-validate="'required'" v-model="user.working_from"
                                        placeholder="Beginning of work"></datepicker>
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

        <md-button class="md-icon-button md-raised md-primary" id="us" @click.native="openDialog('add_user')">
            <md-icon>person_add</md-icon>
        </md-button>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    var moment = require('moment');
    export default {
        data(){
            return {
                user: {
                    name: "",
                    birthday: "",
                    working_from: "",
                    email: "",
                    password: ""
                }

            }
        },
        created(){
            this.$parent.refs = this.$refs;
        },
        methods: {
            openDialog(ref) {
                this.$refs[ref].open();
            },
            test(user){
                this.user.name = user.name;
            },
            closeDialog(ref) {
                this.$refs[ref].close();
            },
            createUser(ref){
                this.$validator.validateAll().then(() => {
                    var data = {
                        name: this.user.name,
                        email: this.user.email,
                        password: this.user.password,
                        working_from: moment(this.user.working_from).format('YYYY-MM-DD h:mm:ss'),
                        birthday: moment(this.user.birthday).format('YYYY-MM-DD h:mm:ss')
                    };
                    this.$http.post('api/user/create', data).then(responce => {
                        this.$parent.userList.push(responce.body);
                        var birthday = {
                            user_id: responce.body.id,
                            type: "birthday",
                            date: responce.body.birthday
                        };
                        this.$parent.birthdaysList.push(birthday);
                        this.$parent.getEvents();
                        this.$refs[ref].close();
                    });
                })
            }
        },
        components: {
            Datepicker
        }
    }
</script>