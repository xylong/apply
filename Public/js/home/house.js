// $(document).ready(function() {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green'
    });

    $('#external-events div.external-event').each(function() {

        $(this).data('event', {
            title: $.trim($(this).text()),
            stick: true
        });

        $(this).draggable({
            zIndex: 1111999,
            revert: true,
            revertDuration: 0
        });

    });

    var vm = new Vue({
        data : {
            code : '',
            proposer : '',
            tutor : '',
            selected : '',
            phone : '',
            reason : '',
            start : '',
            end : '',
            prompt : {
                proposer : {isVisible : false, msg : '申请人不能为空'},
                phone : {isVisible : false, msg : '手机号格式错误'},
                tutor : {isVisible : false, msg : '指导老师不能为空'},
                selected : {isVisible : false, msg : '请选择青春工坊'},
                reason : {isVisible : false, msg : '使用事由不能为空'}
            },
            houses : [],
            times : []  // 一天内的所有时间段
        },

        methods : {
            // 提交申请
            sub : function () {
                if (this.checkData()) {
                    this.$http.post('index.php?s=/Home/House/apply', {
                        proposer : this.proposer,
                        phone : this.phone,
                        tutor : this.tutor,
                        house : this.selected,
                        reason : this.reason,
                        stime : this.start,
                        etime : this.end
                    }, {
                        emulateJSON:true
                    }).then(function(res){
                        toastr.success('申请提交成功');
                        $('#myModal').modal('hide');
                        this.proposer = this.phone = this.tutor = this.house = this.reason = this.start = this.end = '';
                    },function(res){
                        toastr.error('申请提交失败');
                    });
                }
            },

            checkData : function () {
                var flag = true;
                for (var key in this.prompt) {
                    if (this[key].length === 0) {
                        this.prompt[key]['isVisible'] = true;
                        flag = false;
                    } else {
                        this.prompt[key]['isVisible'] = false;
                    }
                }

                if (!checkPhone(this.phone)) {
                    this.prompt.phone.isVisible = true;
                    flag = false;
                } else {
                    this.prompt.phone.isVisible = false;
                }

                /* 判断时间重叠 */
                var arr = [];
                for (var i = 0; i < this.times.length; i++) {
                    if (this.times[i].house == this.selected) {
                        arr.push(this.times[i]);
                    }
                }
                
                for (var n = 0; n < arr.length; n++) {
                    if ( !(this.end <= arr[n].stime || this.start >= arr[n].etime) ) {
                        switch (this.selected) {
                            case '1':
                                this.prompt.selected.msg = '绘智格预约时间冲突';
                                break;
                            case '2':
                                this.prompt.selected.msg = '艺韵厅预约时间冲突';
                                break;
                            case '3':
                                this.prompt.selected.msg = '创意格预约时间冲突';
                                break;
                        }
                        this.prompt.selected.isVisible = true;
                        flag = false;
                    }
                }

                return flag;
            },

            // 判断是否在开放时间内
            is_in_opening: function () {
                var stime = this.start.split(' '),
                    etime = this.end.split(' '),
                    open = '09:00:00',
                    close = '21:00:00';

                if (stime[1] >= open && etime[1] <= close) {
                    return true;
                }
                return false;
            },

            // 最大时间跨度
            maxSpan : function () {
                var s = new Date(this.start),
                    e = new Date(this.end);

                var msec = (e.getTime() - s.getTime()) % (24 * 3600 * 1000);
                var hours = msec / (3600 * 1000);
                if (hours > 3) {
                    return false;
                }
                return true;
            },

            /* 判断时间交叉 */
            overlapping : function () {
                var date = this.start.split(' ');
                date = date[0];

                this.$http
                    .get('index.php?s=/Home/House/timesInDay', {
                        date : date
                    })
                    .then(function(res) {
                        if (res.data.length !== 0) {
                            this.times = res.data;
                        }
                    },function(res){
                    });
            }
        },

        ready : function () {
            this.$http
                .get('index.php?s=/Home/House/getHouse')
                .then(function(res){
                    this.houses = res.data;
                },function(res){
                    alert(res.status);
            });
        }
    }).$mount('#myModal');


    /* initialize the calendar
     -----------------------------------------------------------------*/
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var calendar = $('#calendar');

    calendar.fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaDay'
        },
        monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
        buttonText: {
            today: '今日',
            month: '月',
            day: '日'
        },
        // selectable:true,
        // selectHelper:true,
        // axisFormat: 'H(:mm)',
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        dropAccept: '.cool-event',

        events: {
            url: 'index.php?s=/Home/House/index',
            type: 'get',
            error: function() {
                alert('there was an error while fetching events!');
            },
            editable : false
        },

        dayClick: function( date, allDay, jsEvent, view ) {
            var flag = !lessCurrentTime(date.format('YYYY-MM-DD')); // 可否外部拖拽 true／false

            // 切换日视图
            calendar.fullCalendar( 'gotoDate', date );
            calendar.fullCalendar('changeView','agendaDay');
            if (calendar.fullCalendar('getView').name === 'agendaDay' && flag) {
                $('.external-event:first').addClass('cool-event');
            }

        },

        // 外部移入
        drop: function ( date, jsEvent, view ) {
            vm.start = date.format('YYYY-MM-DD HH:mm:ss');
            vm.end =  eventEnd(vm.start, 7200);
        },

        // 内部移动日程
        eventDrop : function( event, dayDelta, revertFunc ) {
            vm.start = event.start.format('YYYY-MM-DD HH:mm:ss');
            vm.end = eventEnd(vm.end, dayDelta._milliseconds / 1000);
        },

        // 调整日程
        eventResize : function( event, dayDelta, revertFunc ) {
            vm.end = eventEnd(vm.end, dayDelta._milliseconds / 1000);
        },

        eventClick: function(event, jsEvent, view) {
            if (event.id) return;
            if (!vm.is_in_opening()) {
                swal({
                    title: "时间超出",
                    text: "开放时间从早上9点到晚上9点",
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    closeOnConfirm: false
                });
                return;
            }
            if (!vm.maxSpan()) {
                swal({
                    title: "时间超出",
                    text: "最大的时间跨度为3个小时",
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    closeOnConfirm: false
                });
                return;
            }
            vm.overlapping();
            $('#myModal').modal('show');
        },

    });

    // 月视图下取消拖拽的样式
    $('.fc-month-button').click(function() {
        $('.external-event:first').removeClass('cool-event');
    });

// });
