var vm = new Vue({
	data : {
		isActive : 0,
		type : [
			{type:0, name:'全部'},
			{type:1, name:'会议物资'},
			{type:2, name:'团委物资'},
			{type:3, name:'重要物资'}
		],

		number : '',
		selected : 0,
		isHasId : 0,	// 判断是编辑还是添加


		inventory : {
			stock : 0,
			occupy: 0,
			free  : 0
		},	// 库存
		classify : [],	// 物品分类
		goods : [],	// 物品
		pid : 0	// 分类id
	},

	methods : {
		tab : function (type) {
			if (type !== this.isActive) this.isActive = type
		},

		goodsList : function (id) {
			this.pid = id;

			this.$http
				// .get('index', {
				.get('index.php?s=/Admin/Goods/index', {
					pid : this.pid
				})
				.then(function(res){
			    	this.goods = res.data.goods;
					this.inventory.stock = parseInt(res.data.stock[0]['stock']);
					this.inventory.occupy = parseInt(res.data.stock[0]['occupy']);
					this.inventory.free = this.inventory.stock - this.inventory.occupy;
		    },function(res){
		        console.log(res.status);
		    });
		},

		add : function (id) {
			this.isHasId = id;
			$('#myModal').modal('show');
		},

		modify : function (id) {
			this.isHasId = id;
			$('#myModal').modal('show');
		},

		sub : function () {
			var map = {
				number : this.number
			};
			if (this.isHasId) {
				map.id = this.isHasId;
			} else {
				map.pid = this.selected;
			}

			if (map.number.length === 0 || map.number == 0) {
				toastr.warning('编号不能为空');
				return;
			}

			this.$http
				.post('manageGood', map, {
                    emulateJSON:true
                }).then(function(res){
                    toastr.success('操作成功');
                    this.number = '';
                    this.selected = 0;
                },function(res){
                    toastr.error('操作失败');
                });
		},

		del : function (id) {
			swal({
		        title: "确定删除?",
		        text: "删除后将不可恢复!",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Yes",
		        closeOnConfirm: false
		    }, function () {
		    	swal("删除成功!", "刷新后查看.", "success");
		    	vm.doDel(id);
		    });
		},

		doDel : function (id) {
			this.$http
				.get('delGood', {id : id})
				.then(function(res) {
			    },function(res){
			        console.log(res.status);
			    });
		},

		// 切换物品状态
		switchState : function (id, status) {
			var state = !status;

			swal({
		        title: "确认归还?",
		        text: "",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Yes",
		        closeOnConfirm: false
		    }, function () {
		    	swal("操作成功!", "", "success");
		    	vm.doSwitch(id, state);
		    });

			
		},

		doSwitch : function (id, state) {
			this.$http
				.post('switchState', {
					id : id,
					status : state
				}, {
                    emulateJSON:true
                }).then(function(res){
                    toastr.success('操作成功');
                    this.goodsList(this.pid);
                },function(res){
                    toastr.error('操作失败');
                });
		}
		
	},

	ready : function () {
		this.$http
			// .get('index')
			.get('index.php?s=/Admin/Goods/index')
			.then(function(res){
		    	this.classify = res.data;
	    },function(res){
	        console.log(res.status);
	    });
	}
}).$mount('#goods');
