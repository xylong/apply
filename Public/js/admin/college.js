var vm = new Vue({
	data : {
		keyword : '',
		list : [],

		total: 0,
        display: 10,
        current: 1,

        cid		: 0,	// 学院id
        admins : [],
        picked : []
	},

	methods : {
		getList : function (p) {
			this.cid = 0;
			if (p) this.current = p;

			this.$http.get('index.php?s=/Admin/User/colleges',{
				keyword : this.keyword,
				p : this.current
		    }).then(function(res){
		    	this.list = res.data.data;
		    	this.total = parseInt(res.data.count);
		    },function(res){
		        console.log(res.status);
		    });
		},

		allot : function (id) {
			this.cid= id;
			this.$http
                .get('index.php?s=/Admin/Admin/getHeadByCid', {
                    id : this.cid
                })
                .then(function(res) {
                    if (res.data) {
                        this.picked = res.data;
                    } else {
                        this.picked = [];
                    }
                },function(res){
                    console.log(res.status);
                });
		},

		// 分配负责人
        doAllot : function () {
            if (this.picked.length === 0 || this.uid === 0) {
                toastr.warning('未选择管理员');
                return;
            }

            this.$http
                .post('index.php?s=/Admin/Admin/setAdminForCid', {
                    uid : this.picked,
                    id : this.cid
                }, {
                    emulateJSON:true
                }).then(function(res){
                    toastr.success('分配成功');
                },function(res){
                    toastr.success('分配失败');
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
		this.$http
			.get('index.php?s=/Admin/Admin/getAllAdmin')
			.then(function(res){
				this.admins = res.data;
		    },function(res){
		        console.log(res.status);
		    });
	}
}).$mount('#app');
