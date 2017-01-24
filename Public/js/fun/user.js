var vm = new Vue({
	data : {
		isActive : 1,	// 用户类型
		nav : [
			{type:1,name:'学院团委学生会'},
			{type:2,name:'社团'},
			{type:3,name:'校级学生组织'}
		],
		list : [],
		keyword : '',

		total: 0,
        display: 10,
        current: 1
	},

	methods : {
		getList : function (p) {
			if (p) this.current = p;

			var map = {};
			if (this.keyword.length > 0) {
				map = { p : this.current, keyword : this.keyword };
			} else {
				map = { type : this.isActive, p : this.current};
			}

			this.$http
				.get('users', map)
				.then(function(res) {
		    		this.list = res.data.data;
		    		this.total = parseInt(res.data.count);
		    },function(res){
		        console.log(res.status);
		    });
		},

		tab : function (type) {
			if (type !== this.isActive) this.isActive = type
		}
	},

	events:{
        pagechange:function(p){
            this.getList();
        }
    },

	created : function () {
		this.getList();
	}
}).$mount('#app');

// 监听选项卡改变数据
vm.$watch('isActive', function() {
	this.current = 1;
	this.getList();
});