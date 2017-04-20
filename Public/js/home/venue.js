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
        prompt : {
            theme : {isVisible : false, msg : '活动主题不能为空'},
            proposer : {isVisible : false, msg : '申请人不能为空'},
            phone : {isVisible : false, msg : '手机号格式错误'},
            area : {isVisible : false, msg : '请填写使用面积'},
            board : {isVisible : false, msg : '请填写展板数量'},
            rack : {isVisible : false, msg : '请填写展架数量'},
            place : {isVisible : false, msg : '请输入摆放地点'},
            images : {isVisible : false, msg : '请上传活动海报(至多3张)'},
            planning : {isVisible : false, msg : '请上传活动策划(上传压缩文件)'}
        },

        square : [
            {id:1, name: '青广左侧'},
            {id:2, name: '青广中部'},
            {id:3, name: '青广右侧'}
        ],

        theme : '',
        proposer : '',
        phone : '',
        area : '',
        board : '',
        rack  : '',
        place : '',
        stime : '',
        etime : '',
        planning : '',
        images: [],
        file : ''
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
        addPic: function(e) {
            e.preventDefault();
            $('#pic').trigger('click');
            return false;
        },

        onFileChange: function(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length) return; 
            this.images = [];
            this.createImage(files);

        },

        createImage: function(file) {
            if(typeof FileReader==='undefined') {
                alert('您的浏览器不支持图片上传，请升级您的浏览器');
                return false;
            }
            var image = new Image();
            var vm = this;
            var leng=file.length;
            for(var i=0;i<leng;i++) {
                var reader = new FileReader();
                reader.readAsDataURL(file[i]);
                reader.onload =function(e) {
                    vm.images.push(e.target.result);
                };
            }                        
        },

        delImage: function(index){
            var files = document.getElementById('pic').files;
            this.images.splice(index, 1);
        },

        addZip(e){
            e.preventDefault();
            $('#zip').trigger('click');
            return false;
        },

        fileChange : function (e) {
            var files = e.target.files || e.dataTransfer.files;
            this.planning = files[0].name;
                // var reader = new FileReader();
                // reader.readAsDataURL(files[0]);
                // reader.onload = function(e){
                //     vm.planning = e.target.result;
                // };
        },

        sub : function () {
            if (!this.checkData()) return;
            // 处理截止日期
            if (this.etime) {
                var etime = this.etime.substring(0, 8) + (parseInt(this.etime.substring(8)) - 1);
            } else {
                var etime = this.stime;
            }

            $('#stime').val(this.stime);
            $('#etime').val(etime);
            $('#uploadForm').submit();
              

            /*this.$http
                .post('index.php?s=/Home/Venue/apply', {
                    theme   : this.theme,
                    proposer: this.proposer,
                    phone   : this.phone,
                    num     : this.num,
                    place   : this.place,
                    remark  : this.remark,
                    planning: this.planning,
                    images  : this.images,
                    stime   : this.stime,
                    etime   : etime
                }, {
                    emulateJSON:true
                }).then(function(res) {
                    toastr.success('申请提交成功');
                    $('#myModal').modal('hide');
                    this.theme = this.proposer = this.phone = this.num = this.place = this.remark = this.planning = this.stime = this.etime = '';
                    this.images = [];
                    this.images = [];
                }, function(res){
                    toastr.error('申请提交失败');
                });*/
        },

        checkData : function () {
            var flag = true;
            for (var key in this.prompt) {
                if (key == 'phone') {
                    if (!checkPhone(this.phone)) {
                        this.prompt.phone.isVisible = true;
                        flag = false;
                    } else {
                        this.prompt.phone.isVisible = false;
                    }
                    continue;
                }

                if (key == 'area' || key == 'board' || key == 'rack' || key == 'place') {
                    if (!/^[0-9]*[1-9][0-9]*$/.test(this[key])) {
                        this.prompt[key].isVisible = true;
                        flag = false;
                    } else {
                        this.prompt[key].isVisible = false;
                    }

                    continue;
                }

                if (key == 'images') {
                    if (this.images.length === 0 || this.images.length > 3) {
                        this.prompt.images.isVisible = true;
                        flag = false;
                    } else {
                        this.prompt.images.isVisible = false;
                    }
                    continue;
                }

                if (this[key].length === 0) {
                    this.prompt[key]['isVisible'] = true;
                    flag = false;
                } else {
                    this.prompt[key]['isVisible'] = false;
                }
            }
            return flag;
        },

    },

    ready : function () {
        
    }
}).$mount('#myModal')




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
        month: '月'
    },
    editable: true,
    droppable: true, // this allows things to be dropped onto the calendar

    events: {
        url: 'index.php?s=/Home/Venue/index',
        type: 'get',
        error: function() {
            alert('there was an error while fetching events!');
        },
        editable : false
    },


    eventClick: function(event, jsEvent, view) {
        var now = new Date().Format("yyyy-MM-dd");
        if (event.id) return;
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
        
        vm.stime = event.start.format('YYYY-MM-DD');
        vm.etime = event.end ? event.end.format('YYYY-MM-DD') : null;
        $('#myModal').modal('show');
    }

});