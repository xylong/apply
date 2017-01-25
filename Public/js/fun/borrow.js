$(document).ready(function() {

    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green'
    });

    /* initialize the external events
     -----------------------------------------------------------------*/
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
            theme : '',
            start : '',
            end : '',

            classify : []
        },

        filters: {
            // 日期减一
            reduceDay : {
                read : function (value) {
                    if (value) {
                        return value.substring(0, 8) + (parseInt(value.substring(8)) - 1);
                    }
                },
                write : function (value) {
                    return value;
                }
            }
        },

        methods : {
           sub : function () {
               console.log(this.start, this.end)
           }
        },

        ready : function () {
            this.$http
                .get('getGoods')
                .then(function(res) {
                    this.classify = res.data;
            },function(res){
                console.log(res.status);
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
        drop: function() {
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },
        events: [

        ],


        eventClick: function(event, jsEvent, view) {
            vm.start = event.start.format('YYYY-MM-DD');
            vm.end = event.end ? event.end.format('YYYY-MM-DD') : null;
            $('#myModal').modal('show');
        },

        renderEvent : function () {
            alert(123)  
        },

        eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
            console.log('hello')
        },
    });


});