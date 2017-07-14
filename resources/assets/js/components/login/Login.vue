<template>
    <div class="row">
        <div id="login_form" class="col-md-2 col-md-offset-5">

            <md-layout md-gutter>
                <md-input-container>
                    <label>Email</label>
                    <md-input id="email" v-model="email" type="email" name="email" value="" required
                              autofocus></md-input>
                </md-input-container>

                <md-input-container>
                    <label>Password</label>
                    <md-input id="password" v-model="password" type="password" name="password" required></md-input>
                </md-input-container>

                <md-button type="button" @click.native="login" class="md-raised md-primary">Login</md-button>
            </md-layout>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                email: '',
                password: ''
            }
        },

        methods: {
            login(){
                var data = {
                    'client_id': 2,
                    'client_secret': 'PYphqCmgI1HaeludsXPpobRyY9ezgPV8Q4mQGSIj',
                    'grant_type': 'password',
                    'username': this.email,
                    'password': this.password
                }

                this.$http.post('oauth/token', data)
                    .then(response => {
                        this.$auth.setToken(response.body.access_token, response.body.expires_in + Date.now());
                        Vue.isAuth = true;
                        Vue.http.headers.common['Authorization'] = 'Bearer ' + response.body.access_token;
                        this.$router.push("/calendar");
                    });
            }
        }
    }
</script>
