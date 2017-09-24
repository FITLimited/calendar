<template>
    <div class="row">
        <div id="navigate_panel" class="col-md-12">
            <h2 class="md-title">Calendar</h2>
            <span id="login_menu">
                <span v-if="isAuth()">
                    <md-button @click.native="logout" class="md-raised no-padding"><md-icon>exit_to_app</md-icon></md-button>
                </span>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            isAuth(){
                return this.$auth.isAuthenticated();
            },
            logout(){
                this.$auth.destroyToken();
                this.$router.push('/login');
            }
        }
    }
</script>
