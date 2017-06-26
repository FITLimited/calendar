<template>
    <div class="row">
        <div id="registernp_form" class="col-md-2 col-md-offset-5">

        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                email: '',
                password: ''
            }
        },

        methods: {
            login(){
                var data = {
                    'client_id': 2,
                    'client_secret': 'PYphqCmgI1HaeludsXPpobRyY9ezgPV8Q4mQGSIj',
                    'grant_type' : 'password',
                    'username' : this.email,
                    'password': this.password
                }

                this.$http.post('/oauth/token', data)
                    .then( response => {
                        console.log(response.body.access_token);
                    });
            }
        }
    }
</script>
