<template>
    <div class="main-content">
        <div class="row box-shadow">
            <div class="part width-20">
                <ul class="user-list">
                    <li>
                        <md-button @click.native="prevMonth" class="md-raised md-primary no-padding"> <</md-button>
                        <md-button @click.native="nextMonth" class="md-raised md-primary no-padding"> ></md-button>
                        <span style="padding: 0 10px">{{ date | moment("MMMM, YYYY") }}</span>
                        <!--<div class="add-user-wr">-->
                            <!--<add-user v-if="user.role=='admin'"></add-user>-->
                        <!--</div>-->
                    </li>
                    <li v-for="user in users">
                        <a href="#">{{ user.name }}</a>
                        <md-button v-if="user.role.role == 'Admin'" class="md-accent user-remove" @click.native="removeUser(user)"><md-icon>indeterminate_check_box</md-icon></md-button>
                        <md-button v-if="user.role.role == 'Admin'" class="md-accent user-edit" @click.native="editUser(user)"><md-icon>create</md-icon></md-button>
                    </li>
                </ul>
            </div>
            <div class="part width-80">
                <div id="calendar">
                    <div class="calendar-table">
                        <div class="row-table date">
                            <div class="col-table" v-for="day in dayList" :style="{ 'width' : width + 'px' }">
                                <br>
                                {{ day.day }}<br>
                                <small>{{ day.weekDay }}</small>
                            </div>
                        </div>
                        <div v-for="user in users" class="row-table user-events">
                            <div class="col-table" v-for="day in dayList" :style="{ 'width' : width + 'px' }"
                                  :class="{ 'weekend': (day.weekDay == 'Sun' || day.weekDay == 'Sat') }">
                                    <span :class="event.type" v-for="event in events" :style="{ 'width' : width + 'px' }">
                                        <md-icon v-if="event.type == 'birthday'">cake</md-icon>
                                        <md-icon v-if="event.type == 'disease'">local_hospital</md-icon>
                                        <md-icon v-if="event.type == 'performance'">content_paste</md-icon>
                                        <md-icon v-if="event.type == 'vac'">beach_access</md-icon>
                                        <md-tooltip md-direction="top">{{ event.title }}</md-tooltip>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <add-event v-if="user && user.role.role == 'Admin'"></add-event>

        <!--<md-dialog-confirm :md-title="confirm.title" :md-content-html="confirm.contentHtml" :md-ok-text="confirm.ok"-->
                <!--:md-cancel-text="confirm.cancel" ref="delete_dialog">-->
        <!--</md-dialog-confirm>-->
    </div>
</template>

<script>
    import AuthService from '../../services/AuthService';
    import UserService from '../../services/UserService';
    import EventService from '../../services/EventService';

    import AddEvent from './modal/AddEvent.vue'
    import AddUser from './modal/AddUser.vue'

    export default {
        data(){
            return {
                user: null,
                users: [],
                events: [],
                date: new Date(),
                dayList: [],
                monthDayEnded: new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).getDate(),
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                months: ['January', 'February', 'March', 'April', 'May', 'June', 'July',
                    'August', 'September', 'October', 'November', 'December'],
                width: ((window.innerWidth * 0.8)) / 31
            }
        },
        components: {
            'add-event': AddEvent,
            'add-user': AddUser,
        },
        mounted(){
            this.composeDayList();
            this.userSelf();
            this.getUsers();
            this.getEvents();
        },

        methods: {
            composeDayList() {
                for (var i = 1; i <= this.monthDayEnded; i++) {
                    var day = (new Date(this.date.getFullYear(), this.date.getMonth(), i)).getDay();
                    this.dayList.push({"day": i, "weekDay": this.days[day]});
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
                this.getEvents();
            },
            prevMonth() {
                this.date = new Date(this.date.setMonth(this.date.getMonth() - 1));
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
            },
        }
    }
</script>
