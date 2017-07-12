<template>
    <div>
        <md-dialog md-open-from="#us" md-close-to="#us" ref="add_user">
            <md-dialog-title>Add new user</md-dialog-title>
            <md-dialog-content>
                <div class="row">
                    <div class="col-md-6">
                        <md-input-container>
                            <label>Name</label>
                            <md-input v-model="name"></md-input>
                        </md-input-container>
                    </div>
                    <div class="col-md-6">
                        <datepicker v-model="birthday" placeholder="Birthday"></datepicker>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <md-input-container>
                            <label>Email</label>
                            <md-input type="email" v-model="email"></md-input>
                        </md-input-container>
                    </div>
                    <div class="col-md-6">
                        <md-input-container>
                            <label>Password</label>
                            <md-input type="password" v-model="password"></md-input>
                        </md-input-container>
                    </div>
                </div>
            </md-dialog-content>
            <md-dialog-actions>
                <md-button class="md-primary" @click.native="closeDialog('add_user')">Cancel</md-button>
                <md-button class="md-primary" @click.native="createUser('add_user')">Add</md-button>
            </md-dialog-actions>
        </md-dialog>

        <md-button class="md-icon-button md-raised md-primary" id="us"  @click.native="openDialog('add_user')">
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
                name: "",
                birthday: "",
                email: "",
                password: ""
            }
        },
        created(){

        },
        methods: {
            openDialog(ref) {
                this.$refs[ref].open();
            },
            closeDialog(ref) {
                this.$refs[ref].close();
            },
            createUser(ref){
                var data = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    birthday: moment(this.birthday).format('YYYY-MM-DD h:mm:ss')
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

            }
        },
        components: {
            Datepicker
        }
    }
</script>