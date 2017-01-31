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
            houses : []
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
                        alert(res.status);
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
                return flag;
            },

            getEvent: function () {
                
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
        selectable:true,
        selectHelper:true,
        axisFormat: 'H(:mm)',
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
            $('#myModal').modal('show');
        },


    });

    // 月视图下取消拖拽的样式
    $('.fc-month-button').click(function() {
        $('.external-event:first').removeClass('cool-event');
    });

// });
