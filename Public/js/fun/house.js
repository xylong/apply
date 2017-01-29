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
                phone : {isVisible : false, msg : '联系方式不能为空'},
                tutor : {isVisible : false, msg : '指导老师不能为空'},
                selected : {isVisible : false, msg : '请选择青春工坊'},
                reason : {isVisible : false, msg : '使用事由不能为空'}
            },
            houses : []
        },

        methods : {
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
                        console.log(res.data);
                        $('#myModal').modal('hide');
                        this.proposer = this.phone = this.tutor = this.house = this.reason = this.start = this.end = '';
                    },function(res){
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
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        dropAccept: '.cool-event',
        // events: {
        //     url: 'index',
        //     type: 'get',
        //     error: function() {
        //         alert('there was an error while fetching events!');
        //     },
        //     editable : false
        // },

        dayClick: function( date, allDay, jsEvent, view ) {
            if (lessCurrentTime(date.format('YYYY-MM-DD'))) {
                swal({
                    title: "申请错误",
                    text: "预约时间不能小于当前时间",
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    closeOnConfirm: false
                });
                return;
            }

            // 切换日视图
            calendar.fullCalendar( 'gotoDate', date );
            calendar.fullCalendar('changeView','agendaDay');
            if (calendar.fullCalendar('getView').name === 'agendaDay') {
                $('.external-event:first').addClass('cool-event');
            }

        },

        eventClick: function(event, jsEvent, view) {
            $('#myModal').modal('show');
        },


    });

    // 月视图下取消拖拽的样式
    $('.fc-month-button').click(function() {
        $('.external-event:first').removeClass('cool-event');
    });

// });
