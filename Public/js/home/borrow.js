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
            borrow : [],
            other : '',

            cue : {
                theme : {isVisible : false, msg : '活动主题不能为空'},
                phone : {isVisible : false, msg : '手机号格式错误'},
                borrow : {isVisible : false, msg : '至少选择一项或填写借用物品'},
            },
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
                write : function (newVal, oldVal, id, index) {
                    if (/\d/.test(newVal)) {
                        var limit = parseInt(this.classify[index]['stock']) - parseInt(this.classify[index]['occupy']);
                        if (parseInt(newVal) <= limit) {
                            return id + '_' + newVal;
                        }
                    }
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

            checknum : function (val) {
                console.log(val)
            },

            // 过滤提交的数据
            filterData : function () {
                var flag = true;

                if (this.theme.length === 0) {
                    this.cue.theme.isVisible = true;
                    flag = false;
                } else {
                    this.cue.theme.isVisible = false;
                }

                if (!checkPhone(this.phone)) {
                    this.cue.phone.isVisible = true;
                    flag = false;
                } else {
                    this.cue.phone.isVisible = false;
                }
                
                // 处理借用的数量
                var len = this.borrow.length;
                for (var i = 0; i < len; i++) {
                    if (this.borrow[i] === undefined) this.borrow[i] = 0;
                }
                this.borrow = this.borrow.filter(function (value) {
                    return value;
                });

                // 判断是否借用物资
                if (this.other.length === 0) {
                    if (this.borrow.length === 0) {
                        this.cue.borrow.isVisible = true;
                        flag = false;
                    } else {this.cue.borrow.isVisible = false;}
                } else {this.cue.borrow.isVisible = false;}

                if (!flag) return;

                var data = {
                    borrow: this.borrow,
                    other : this.other,
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
        monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
        buttonText: {
            today: '今日',
            month: '月',
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
