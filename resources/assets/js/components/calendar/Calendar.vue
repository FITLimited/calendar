<template>
    <div class="main-content">
        <div class="row box-shadow">
            <div class="part width-20">
                <user v-bind:users="users" v-bind:auth_user="user"></user>
            </div>
            <div class="part width-80">
                <event v-bind:users="users" v-bind:events="events" v-bind:days="days"></event>
            </div>
        </div>
        <!--<add-event v-if="user && user.role.role == 'Admin'"></add-event>-->

    </div>
</template>

<script>
    import AuthService from '../../services/AuthService';
    import UserService from '../../services/UserService';
    import EventService from '../../services/EventService';

    export default {
        data(){
            return {
                user: null,
                users: [],
                events: [],
                date: new Date(),
                days: [],
                monthDayEnded: new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).getDate(),
                weekDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                months: ['January', 'February', 'March', 'April', 'May', 'June', 'July',
                    'August', 'September', 'October', 'November', 'December'],
            }
        },
        mounted() {
            this.composeDayList();
            this.userSelf();
            this.getUsers();
            this.getEvents();
        },

        methods: {
            composeDayList() {
                this.days = [];

                for (var i = 1; i <= this.monthDayEnded; i++) {
                    var dayOfWeek = (new Date(this.date.getFullYear(), this.date.getMonth(), i)).getDay();

                    var year = this.date.getFullYear();
                    var month = this.date.getMonth() + 1;

                    this.days.push({
                        'day': i,
                        'weekDay': this.weekDays[dayOfWeek],
                        'date': `${year}-${month >= 10 ? month : '0' + month}-${i >= 10 ? i : '0' + i}`
                    });
                }
            },
            userSelf() {
                AuthService.getSelf().then(response => {
                    this.user = response.body.data.user;
                }, error => {
                    console.log(error);
                });
            },
            getUsers() {
                UserService.users().then(response => {
                    this.users = response.body.data.users;
                }, error => {
                    console.log(error);
                });
            },
            nextMonth(){
                this.date = new Date(this.date.setMonth(this.date.getMonth() + 1));
                this.composeDayList();
                this.getEvents();
            },
            prevMonth() {
                this.date = new Date(this.date.setMonth(this.date.getMonth() - 1));
                this.composeDayList();
                this.getEvents();
            },
            getEvents() {
                var from = `${this.date.getFullYear()}-${this.date.getMonth() + 1}-01`;
                var to = `${this.date.getFullYear()}-${this.date.getMonth() + 1}-${this.monthDayEnded}`;

                EventService.events(from, to).then(response => {
                    this.events = response.body.data.events;
                }, error => {
                    console.log(error);
                });
            }
        }
    }
</script>
