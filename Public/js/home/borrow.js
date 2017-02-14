/*
|--------------------------------------------------------------------------
| 物资借用申请
|--------------------------------------------------------------------------
|
| @author   darker
| @since    Version 1.0.0
| @date     2017-2-1
|
*/

// $(document).ready(function() {
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
            apply : [],

            theme : '',
            phone : '',
            start : '',
            end : '',

            classify : [],
            borrow : []
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
            },
            goodsNum : {
                read : function (value) {
                    if (value) {
                        return value.replace(/.+\_/, '');
                    }
                },
                write : function (newVal, oldVal, index) {
                    if (newVal) return index + '_' + newVal;
                }
            }
        },

        methods : {
            sub : function () {
                var post = this.filterData();
                if (!post) return;

                this.$http.post('index.php?s=/Home/Borrow/apply', post, {
                    emulateJSON:true
                }).then(function(res){
                    $('#myModal').modal('hide');
                    this.theme = this.phone = this.start = this.end = '';
                    this.borrow = [];
                },function(res){
                    alert(res.status);
                });
            },

            // 过滤提交的数据
            filterData : function () {
                if (this.theme.length === 0) return;
                if (!checkPhone(this.phone)) return;

                // 处理借用的数量
                var len = this.borrow.length;
                if (len === 0) return;
                for (var i = 0; i < len; i++) {
                    if (this.borrow[i] === undefined) this.borrow[i] = 0;
                }


                var data = {
                    borrow: this.borrow,
                    theme : this.theme,
                    phone : this.phone,
                    stime : this.start
                };

                // 处理截止日期
                this.end = this.end ? this.end.substring(0, 8) + (parseInt(this.end.substring(8)) - 1) : null;
                if (this.end) data.etime = this.end;

                return data;
           },

           // 获取物资分类及库存
           getClassify : function () {
                this.$http
                    .get('index.php?s=/Home/Borrow/getGoods')
                    .then(function(res) {
                        this.classify = res.data;
                },function(res){
                    console.log(res.status);
                });
            }
        },

        ready : function () {
            this.getClassify();
        }
    }).$mount('#myModal');

    /*var bar = new Vue({
        data : {
            isVisible : false,
            info : {}
        },
        methods : {
            getApply : function (id) {
                this.$http
                    .get('index.php?s=/Home/Borrow/getApply', {
                        id : id
                    })
                    .then(function(res) {
                        res.data.borrow = res.data.borrow.split(',').map(function (item) {
                            var tmp = item.split('_');
                            for (obj of vm.classify) {
                                if (tmp[0] == obj.id) {
                                    return { id : tmp[0], name : obj.name, num : tmp[1] }
                                }
                            }
                            for (var i = 0; i < vm.classify.length; i++) {
                                if (tmp[0] == vm.classify[i]['id']) {
                                    return { id : tmp[0], name : vm.classify[i]['name'], num : tmp[1] }
                                }
                            }
                        });
                        this.info = res.data;
                },function(res){
                    console.log(res.status);
                });
            }
        }
    }).$mount('#bar');*/


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
            right: 'month'
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
        events: {
            url: 'index.php?s=/Home/Borrow/index',
            type: 'get',
            error: function() {
                alert('there was an error while fetching events!');
            },
            editable : false
        },

        eventClick: function(event, jsEvent, view) {
            var now = new Date().Format("yyyy-MM-dd");
            if (!event.id && lessCurrentTime(event.start.format('YYYY-MM-DD'))) {
                swal({
                    title: "申请错误",
                    text: "起始时间不能小于当前时间",
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    closeOnConfirm: false
                });
                return
            };

            if (event.id) {
                // if (event.viewable) {
                //     bar.getApply(event.id);
                //     bar.isVisible = true;
                // } else {
                //     bar.info = {};
                //     bar.isVisible = false;
                // }
                return;
            };
            vm.getClassify();
            vm.start = event.start.format('YYYY-MM-DD');
            vm.end = event.end ? event.end.format('YYYY-MM-DD') : null;
            $('#myModal').modal('show');
        }
    });


// });
