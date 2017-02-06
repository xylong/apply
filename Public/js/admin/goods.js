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

		add : function () {
			$('#myModal').modal('show');
		},

		sub : function () {
			if (this.number.length === 0 || this.selected == 0) return;

			this.$http
				.post('addUser', {
                    number 	: this.number,
                    pid		:thi.selected
                }, {
                    emulateJSON:true
                }).then(function(res){
                    toastr.success('添加成功');
                    this.number = '';
                    this.selected = 0;
                },function(res){
                    toastr.error('添加失败');
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
