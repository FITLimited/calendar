<template>
    <div class="row">
        <div id="login_form" class="col-md-2 col-md-offset-5">

            <form v-on:submit.prevent="login">
                <md-layout>
                    <md-input-container>
                        <label>Email</label>
                        <md-input v-model="data.email" type="email" name="email" required autofocus></md-input>
                    </md-input-container>

                    <md-input-container>
                        <label>Password</label>
                        <md-input v-model="data.password" type="password" name="password" required></md-input>
                    </md-input-container>

                    <md-button type="submit" class="md-raised md-primary">Login</md-button>
                </md-layout>
            </form>
        </div>
    </div>
</template>

<script>
    import AuthService from '../../services/AuthService';

    export default {
        data(){
            return {
                data: {
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            login(){
                AuthService.login(this.data).then(response => {
                    if (response.body.success == true) {
                        this.$auth.setToken(response.body.data.token.access_token);
                        this.$router.push("/calendar");
                    } else {
                        console.log('Authorisation fail');
                    }
                }, error => {
                    console.log(error);
                });
            }
        }
    }
</script>
