var vm = new Vue({
	data : {
		rid : 0,	// 角色id
		name : '',	// 角色名称
		remark : '',	// 角色描述
		status : 1,	// 角色状态

		roles : [], 	// 角色列表
	},

	methods : {
		getRole : function () {
			this.$http
				.get('index.php?s=/Admin/Admin/role')
				.then(function(res) {
		    		this.roles = res.data;
		    	}, function(res){
		        	console.log(res.status);
		    	});
		},

		save : function () {
			this.$http
				.post('index.php?s=/Admin/Admin/editRole', {
					id : this.rid,
					name : this.name,
					remark : this.remark
				}, {
                    emulateJSON:true
                })
                .then(function(res) {
                	this.getRole();
                	toastr.success('角色保存成功');
                	this.name = this.remark = '';
                },function(res){
                    toastr.error('角色保存失败');
                });
		},

		edit : function (index) {
			this.rid = this.roles[index]['id'];
			this.name = this.roles[index]['name'];
			this.remark = this.roles[index]['remark'];
		}
	},

	ready : function () {
		this.getRole();
	}
}).$mount('#role');
