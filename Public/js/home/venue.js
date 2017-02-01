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
        stime : '',
        etime : '',

        images: []
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
        addPic:function(e){
            e.preventDefault();
            $('input[type=file]').trigger('click');
            return false;
        },

        onFileChange:function(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)return; 
            this.createImage(files);

        },

        createImage:function(file) {
            if(typeof FileReader==='undefined'){
                alert('您的浏览器不支持图片上传，请升级您的浏览器');
                return false;
            }
            var image = new Image();         
            var vm = this;
            var leng=file.length;
            for(var i=0;i<leng;i++){
                var reader = new FileReader();
                reader.readAsDataURL(file[i]); 
                reader.onload =function(e){
                vm.images.push(e.target.result);                                    
                };                 
            }                        
        },

        delImage:function(index){
            this.images.shift(index);
        },

        removeImage: function(e) {
            this.images = [];
        },

        uploadImage: function() {
            var obj = {images : this.images};
            $.ajax({
                type: 'post',
                url: "index.php?s=/Home/Venue/up",
                data: obj,
                dataType: "json",
                success: function(data) {
                    if(data.status){
                        alert(data.msg);
                        return false;
                    }else{
                        alert(data.msg);
                        return false;
                    }
                }
            });
        }

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
        right: 'month,agendaDay'
    },
    editable: true,
    droppable: true, // this allows things to be dropped onto the calendar

    events: [

    ],


    eventClick: function(event, jsEvent, view) {
        vm.stime = event.start.format('YYYY-MM-DD');
        vm.etime = event.end ? event.end.format('YYYY-MM-DD') : null;
        $('#myModal').modal('show');
    }

});