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
                                    <span :class="event.type" v-for="event in eventList"
                                          v-if="(user.id == event.user_id || event.user_id == 0) && day.day == event.day"
                                          :style="{ 'width' : event.duration * width + 'px' }">
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
        <add-event v-if="user.role=='admin'"></add-event>

        <!--<md-dialog-confirm :md-title="confirm.title" :md-content-html="confirm.contentHtml" :md-ok-text="confirm.ok"-->
                <!--:md-cancel-text="confirm.cancel" ref="delete_dialog">-->
        <!--</md-dialog-confirm>-->
    </div>
</template>

<script>
    import AuthService from '../../services/AuthService';
    import UserService from '../../services/UserService';

    import Add_event from './modal/Add_event.vue'
    import Add_user from './modal/Add_user.vue'

    export default {
        data(){
            return {
                user: {},
                users: [],
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
            'add-event': Add_event,
            'add-user': Add_user,
        },
        mounted(){
            this.composeDayList();
            this.userSelf();
            this.getUsers();
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
//                this.month++;
//                this.getEvents();
            },
            prevMonth() {
//                this.month--;
//                this.getEvents();
            },
//            generationMonth(year, month) {
//                this.date = new Date(year, month);
//                this.lastDayMonth = new Date(year, month + 1, 0).getDate();
//
//                this.dayList = [];
//                for (d = 1; d <= this.lastDayMonth; d++) {
//                    dayNumber = (new Date(year, month, d)).getDay();
//                    this.dayList.push({"day": d, "weekDay": weekDay[dayNumber]});
//                }
//
//            },
            getEvents(){
//                var monthInfo = {
//                    from: this.year + "-" + (this.month + 1) + "-01",
//                    to: this.year + "-" + (this.month + 1) + "-" + this.lastDayMonth
//                };
//
//                this.$http.get('api/events?from=' + monthInfo.from + "&to=" + monthInfo.to).then(responce => {
//                    this.generationMonth(this.year, this.month);
//
//                    var convertEvents = [];
//                    var eventsList = responce.body;
//
//                    for (var h = 0; h < eventsList.length; h++) {
//                        var date = new Date(eventsList[h].date);
//                        var event = {
//                            user_id: eventsList[h].user_id,
//                            type: eventsList[h].type,
//                            title: eventsList[h].title,
//                            day: date.getDate(),
//                            duration: eventsList[h].duration
//                        };
//                        convertEvents.push(event);
//                    }
//
//                    //add Birthday to Event array
//                    for (var b = 0; b < this.birthdaysList.length; b++) {
//                        var dateBirthday = new Date(this.birthdaysList[b].date);
//                        if (monthList[this.date.getMonth()] == monthList[dateBirthday.getMonth()]) {
//
//                            var event = {
//                                user_id: this.birthdaysList[b].user_id,
//                                type: this.birthdaysList[b].type,
//                                title: "Birthday",
//                                day: dateBirthday.getDate(),
//                                duration: 1
//                            };
//
//                            convertEvents.push(event);
//                        }
//
//                    }
//
//                    this.eventList = convertEvents;
//
//
//                });
            },
//            removeUser(user){
//                this.$refs["delete_dialog"].open();
//                this.remove_user = user;
//            },
//            editUser(user){
//                this.$refs['add_user'] = this.refs["add_user"];
//                this.$refs['add_user'].open();
//                Add_user.methods.test(user);
//            },
//            confirm_delete(type) {
//                if(type == "ok"){
//
//                    var data = {
//                        id: this.remove_user.id,
//                    };
//
//                    this.$http.post('api/user/remove', data).then(responce => {
//                        this.loadUser();
//                    });
//                }
//
//            }
        }
    }
</script>
