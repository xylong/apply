/*
|--------------------------------------------------------------------------
| 后台青春工坊审核
|--------------------------------------------------------------------------
|
| @author   darker
| @since    Version 1.0.0
| @date     2017-1-31
|
*/

var vm = new Vue({
    data : {
        apply_code : '',

        total: 0,
        display: 10,
        current: 1,

        start : '',
        end : '',

        isActive : 0,
        tab : [{type:0,name:'未审核'},{type:1,name:'已审核'}],
        applys : [],

        selection : [], // 可选
        goods : [],    // 选中
        oid : 0,    // 申请id

        detail : {}, // 申请详情
        result : [], // 审核结果
        myturn : '',  // 

        picked : '',    // 提交的审核结果
        opinion : '' // 意见
    },
    methods : {
        tabChange : function (type) {
            if (type !== this.isActive) this.isActive = type
        },

        getList : function (p) {
            if (p) this.current = p;

            this.$http
                .get('index.php?s=/Admin/Goods/apply', {
                    is_examine : this.isActive,
                    p : this.current
                })
                .then(function(res) {
                    this.applys = res.data.data;
                    this.total = parseInt(res.data.count);
                },function(res){
                    console.log(res.status);
                });
        },

        review : function (id) {
            this.id = id;

            this.$http
                .get('index.php?s=/Admin/Goods/applyDetail', {
                    id : id
                })
                .then(function(res) {
                    this.selection = res.data.selection;
                    this.detail = res.data.apply;
                    this.result = res.data.result;
                    this.myturn = res.data.myturn;
            },function(res){
                console.log(res.status);
            });
        },

        sub : function () {
            if (this.picked.length === 0) {
                toastr.warning('请选择通过还是拒绝');
                return;
            }

            this.$http
                .post('index.php?s=/Admin/Goods/review', {
                    aid : this.detail.id,
                    isagree : this.picked,
                    opinion : this.opinion,
                    role_id : this.detail.receiver
                }, {
                    emulateJSON:true
                }).then(function(res){
                    toastr.success('审核成功');
                    this.picked = this.opinion = '';
                    this.getList();
                    this.review(this.detail.id);
                },function(res){
                    toastr.error('审核失败');
                });
        },

        // 预约物资
        order : function (id) {
            this.oid = id;
            this.$http
                .get('order', {
                    id : this.oid
                })
                .then(function(res) {
                    this.selection = res.data;
            },function(res){
                console.log(res.status);
            });
            $('#myModal').modal('show');
        },

        subOrder : function () {
            if (this.goods.length === 0) {
                swal({
                    title: "预约错误",
                    text: "您尚未选择物资",
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    closeOnConfirm: false
                });
                return;
            }

            this.$http
                .post('makeAppointment', {
                    id : this.oid,
                    goods : this.goods
                }, {
                    emulateJSON:true
                }).then(function(res){
                    toastr.success('预约成功,物资已锁定');
                    this.goods = [];
                    $('#myModal').modal('hide');
                },function(res){
                    toastr.error('预约失败');
                });
        },

        cancel : function () {
            this.goods = [];
        },

        export : function () {
            var sdate = $('#sdate').val(),
                edate = $('#edate').val();

            if (sdate > edate) {
                swal({
                    title: "导出错误",
                    text: "开始日期不能大于结束日期",
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    closeOnConfirm: false
                });
                return;
            }
            $('#export').submit();
        },

        search : function () {
            if (this.apply_code.length === 0) return;

            this.$http
                .post('search', {
                    code : this.apply_code
                }, {
                    emulateJSON:true
                }).then(function(res){
                    this.applys = res.data;
                    this.total = res.data.length;
                },function(res){
                    toastr.warning('未找到');
                });
        }
    },

    events:{
        pagechange:function(p){
            this.getList();
        }
    },

    ready : function () {
        this.getList();
    }
}).$mount('#apply');


// 监听选项卡改变
vm.$watch('isActive', function() {
    this.getList(1);
});
