$(document).ready(function() {

    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green'
    });

    /* initialize the external events
     -----------------------------------------------------------------*/
    function drag() {
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
    }


    var vm = new Vue({
        data : {
            code : '',
            proposer : '',
            tutor : '',
            house : '',
            phone : '',
            reason : '',
            start : '',
            end : '',
        },

        methods : {

            // 获取物资分类及库存
            getClassify : function () {
                this.$http
                    .get('getGoods')
                    .then(function(res) {
                        this.classify = res.data;
                },function(res){
                    console.log(res.status);
                });
            }
        },

        ready : function () {
            
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
        drop: function() {
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },
        events: [

        ],

        dayClick: function(date, allDay, jsEvent, view) {
            drag(); // 进入某天中允许多拽
            calendar.fullCalendar( 'gotoDate', date );
            calendar.fullCalendar('changeView','agendaDay')
        },

        eventClick: function(calEvent, jsEvent, view) {
            $('#myModal').modal('show');
        },

        eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
            console.log(dayDelta)
        },
    });


});