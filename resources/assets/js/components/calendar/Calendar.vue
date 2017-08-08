<template>
    <div class="main-content">
        <div class="row box-shadow">
            <div class="part width-20">
                <ul class="user-list">
                    <li>
                        <md-button @click.native="prevMonth" class="md-raised md-primary no-padding"> <</md-button>
                        <md-button @click.native="nextMonth" class="md-raised md-primary no-padding"> ></md-button>
                        <span style="padding: 0 10px">{{ monthList[date.getMonth()] + ", " + date.getFullYear()
                            }}</span>
                        <div class="add-user-wr">
                            <add-user v-if="user.role=='admin'"></add-user>
                        </div>
                    </li>
                    <li v-for="us in userList">
                        <a href="#">{{ us.name }}</a>
                        <md-button v-if="user.role=='admin' && us.role != 'admin'" class="md-accent user-remove" @click.native="removeUser(us)"><md-icon>indeterminate_check_box</md-icon></md-button>
                        <md-button v-if="user.role=='admin' && us.role != 'admin'" class="md-accent user-edit" @click.native="editUser(us)"><md-icon>create</md-icon></md-button>
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
                        <div v-for="user in userList" class="row-table user-events">
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

        <md-dialog-confirm :md-title="confirm.title" :md-content-html="confirm.contentHtml" :md-ok-text="confirm.ok"
                :md-cancel-text="confirm.cancel" @close="confirm_delete" ref="delete_dialog">
        </md-dialog-confirm>
    </div>
</template>

<script>
    var today = new Date(),
        lastDayMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate(),
        weekDay = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        monthList = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        dayList = [],
        width = ((window.innerWidth * 0.8)) / 31;
    for (var d = 1; d <= lastDayMonth; d++) {
        var dayNumber = (new Date(today.getFullYear(), today.getMonth(), d)).getDay();
        dayList.push({"day": d, "weekDay": weekDay[dayNumber]});
    }
    import Add_event from './modal/Add_event.vue'
    import Add_user from './modal/Add_user.vue'
    export default {
        data(){
            return {
                user: '',
                month: today.getMonth(),
                year: today.getFullYear(),
                date: today,
                lastDayMonth: lastDayMonth,
                dayList: dayList,
                monthList: monthList,
                userList: '',
                eventList: '',
                birthdaysList: [],
                width: width,
                confirm: {
                    title: 'Confirm delete',
                    contentHtml: 'Are you sure want to delete the user?',
                    ok: 'Delete',
                    cancel: 'Cancel'
                },
                remove_user: "",
                refs: "",
            }
        },
        components: {
            'add-event': Add_event,
            'add-user': Add_user,
        },
        mounted(){
            this.loadUser();
        },

        methods: {
            loadUser(){
                this.$http.get('api/user').then(responce => {
                    this.user = responce.body;
                });

                this.$http.get('api/users').then(responce => {
                    this.userList = responce.body;
                    for (var u = 0; u < this.userList.length; u++) {
                        var birthday = {
                            user_id: this.userList[u].id,
                            type: "birthday",
                            date: this.userList[u].birthday
                        };
                        this.birthdaysList.push(birthday);
                    }
                    this.getEvents();
                });
            },
            nextMonth(){
                this.month++;
                this.getEvents();
            },
            prevMonth() {
                this.month--;
                this.getEvents();
            },
            generationMonth(year, month) {
                this.date = new Date(year, month);
                this.lastDayMonth = new Date(year, month + 1, 0).getDate();

                this.dayList = [];
                for (d = 1; d <= this.lastDayMonth; d++) {
                    dayNumber = (new Date(year, month, d)).getDay();
                    this.dayList.push({"day": d, "weekDay": weekDay[dayNumber]});
                }

            },
            getEvents(){
                var monthInfo = {
                    from: this.year + "-" + (this.month + 1) + "-01",
                    to: this.year + "-" + (this.month + 1) + "-" + this.lastDayMonth
                };

                this.$http.get('api/events?from=' + monthInfo.from + "&to=" + monthInfo.to).then(responce => {
                    this.generationMonth(this.year, this.month);

                    var convertEvents = [];
                    var eventsList = responce.body;

                    for (var h = 0; h < eventsList.length; h++) {
                        var date = new Date(eventsList[h].date);
                        var event = {
                            user_id: eventsList[h].user_id,
                            type: eventsList[h].type,
                            title: eventsList[h].title,
                            day: date.getDate(),
                            duration: eventsList[h].duration
                        };
                        convertEvents.push(event);
                    }

                    //add Birthday to Event array
                    for (var b = 0; b < this.birthdaysList.length; b++) {
                        var dateBirthday = new Date(this.birthdaysList[b].date);
                        if (monthList[this.date.getMonth()] == monthList[dateBirthday.getMonth()]) {

                            var event = {
                                user_id: this.birthdaysList[b].user_id,
                                type: this.birthdaysList[b].type,
                                title: "Birthday",
                                day: dateBirthday.getDate(),
                                duration: 1
                            };

                            convertEvents.push(event);
                        }

                    }

                    this.eventList = convertEvents;


                });
            },
            removeUser(user){
                this.$refs["delete_dialog"].open();
                this.remove_user = user;
            },
            editUser(user){
                this.$refs['add_user'] = this.refs["add_user"];
                this.$refs['add_user'].open();
                Add_user.methods.test(user);
            },
            confirm_delete(type) {
                if(type == "ok"){

                    var data = {
                        id: this.remove_user.id,
                    };

                    this.$http.post('api/user/remove', data).then(responce => {
                        this.loadUser();
                    });
                }

            }
        }
    }
</script>
