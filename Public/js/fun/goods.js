var vm = new Vue({
	data : {
		isActive : 0,
		type : [
			{type:0, name:'全部'},
			{type:1, name:'会议物资'},
			{type:2, name:'团委物资'},
			{type:3, name:'重要物资'}
		],

		classify : [],	// 物品分类
		goods : [],	// 物品
		pid : 0	// 分类id
	},

	computed : {
		// 物资统计
		statistics : function () {
			return {
				total : this.goods.length,
				free : 0,
				stock : 0
			};
		}
	},

	methods : {
		tab : function (type) {
			if (type !== this.isActive) this.isActive = type
		},

		goodsList : function (id) {
			this.pid = id;

			this.$http
				.get('index', {
					pid : this.pid
				})
				.then(function(res){
			    	this.goods = res.data;
		    },function(res){
		        console.log(res.status);
		    });
		}
	},

	ready : function () {
		this.$http
			.get('index')
			.then(function(res){
		    	this.classify = res.data;
	    },function(res){
	        console.log(res.status);
	    });
	}
}).$mount('#goods');
