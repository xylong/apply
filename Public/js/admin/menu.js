var vm  = new Vue({
	data : {
		options : [],

		node : {
			pid : 0,
			title : '',
			url : '',
			tip : '',
			icon : '',
			sort : 0
		},
	},

	methods : {
		save : function () {
			this.$http.post('add', this.node, {
                    emulateJSON:true
                }).then(function(res){
                    toastr.success('添加成功');
                    this.node.pid = this.node.sort = 0;
                    this.node.title = this.node.url = this.node.tip = this.node.url = '';
                },function(res){
                    toastr.error('添加失败');
                });
		}
	},

	ready : function () {
		this.$http
			.get('index')
			.then(function(res){
                this.options = res.data;
				this.options.unshift({id : 0, title : '顶级菜单'})
            },function(res){
            });
	}
}).$mount('#menu')