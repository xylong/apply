var vm = new Vue({
	data : {
		rid : 0,	// 角色id
		name : '',	// 角色名称
		remark : '',	// 角色描述
		status : 1,	// 角色状态

		roles : [], 	// 角色列表
		node : [],
		checked : []
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

		getNode : function () {
			this.$http
				.get('nodes')
				.then(function(res) {
		    		this.node = res.data;
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

			this.$http
				.get('nodes', {rid : this.rid})
				.then(function(res) {
		    		if (res.data) {
		    			this.checked = res.data;
		    		} else {
		    			this.checked = [];
		    		}
		    	}, function(res){
		        	console.log(res.status);
		    	});
		},

		saveAuth : function () {
			if (this.checked.length === 0) {
				toastr.warning('请选择权限');
				return;
			}
			if (this.rid == 0) {
				toastr.warning('请选择角色');
				return;
			}

			this.$http
				.post('saveAuth', {
					rid : this.rid,
					mid : this.checked
				}, {
                    emulateJSON:true
                })
                .then(function(res) {
                	toastr.success('权限设置成功');
                },function(res){
                    toastr.error('权限设置失败');
                });

		}
	},

	ready : function () {
		this.getRole();
		this.getNode();
	}
}).$mount('#role');
