

var vm = new Vue({
	data : {
		total: 0,
        display: 10,
        current: 1,

		isActive : 0,
        tab : [{type:0,name:'未审核'},{type:1,name:'已审核'}],
        applys : [],

        detail : {}, // 申请详情
        result : [], // 审核结果
        myturn : '',  // 轮到自己
        union  : false, // 联合审批
        departments : [],   // 联合审批部门
        union_departments : [],

        picked : '',    // 提交的审核结果
        opinion : '' // 意见
	},

	methods : {
		tabChange : function (type) {
			if (type !== this.isActive) this.isActive = type
		},

		// 申请列表
		getList : function (p) {
            if (p) this.current = p;

            this.$http
                .get('index.php?s=/Admin/Venue/index', {
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

        // 查看
        review : function (id) {
            this.id = id;

            this.$http
                .get('index.php?s=/Admin/Venue/applyDetail', {
                    id : id
                })
                .then(function(res) {
                    this.detail = res.data.apply;
                    this.detail.img = res.data.apply.img.split(',');
                    this.result = res.data.result;
                    this.myturn = res.data.myturn;
                    this.union = res.data.union;
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
                .post('index.php?s=/Admin/Venue/review', {
                    aid : this.detail.id,
                    isagree : this.picked,
                    opinion : this.opinion,
                    role_id : this.detail.receiver,
                    utype	: this.detail.utype,	// 申请者类型
                    step	: this.result.length	// 审核到第几步了
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

        setUnion : function () {
            this.$http
                .get('index.php?s=/Admin/Venue/getUnionSelection')
                .then(function(res) {
                    this.departments = res.data;
                    $('#myModal').modal('show');
            },function(res){
            });
        },

        saveUnion : function () {
            if (this.union_departments.length === 0) {
                swal({
                    title: "警告",
                    text: "选择部门不能为空",
                    type: "warning",
                    confirmButtonColor: "#DD6B55",
                    closeOnConfirm: false
                });
                return;
            }

            this.$http
                .post('index.php?s=/Admin/Venue/setUnions', {
                    id : this.detail.id,
                    union : this.union_departments
                }, {
                    emulateJSON:true
                }).then(function(res){
                    toastr.success('设置成功');
                    $('#myModal').modal('hide');
                },function(res){
                    toastr.error('设置失败');
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