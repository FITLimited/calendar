<template>
    <div>
        <md-dialog md-open-from="#us" md-close-to="#us" ref="add_user">
            <md-dialog-title>Add new user</md-dialog-title>
            <md-dialog-content>

            </md-dialog-content>
            <md-dialog-actions>
                <md-button class="md-primary" @click.native="closeDialog('add_user')">Cancel</md-button>
                <md-button class="md-primary" @click.native="closeDialog('add_user')">Add</md-button>
            </md-dialog-actions>
        </md-dialog>

        <md-button class="md-icon-button md-raised md-primary" id="us"  @click.native="openDialog('add_user')">
            <md-icon>person_add</md-icon>
        </md-button>
    </div>
</template>

<script>
    export default {
        data(){
            return {

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
            }
        },
        components: {
        }
    }
</script>