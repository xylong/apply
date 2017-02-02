

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
        myturn : '',  // 

        picked : '',    // 提交的审核结果
        opinion : '' // 意见
	},

	methods : {
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


