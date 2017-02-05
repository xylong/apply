// 过滤显示用户类型
Vue.filter('utype', function(value) {
    switch (value) {
		case 2:
			return '社团';
			break;
		case 3:
			return '校级学生组织';
			break;
		default:
			return '学院团委学生会';
			break;
	}
});

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
		college : [],

		isModify : false,
		detail : {},
		user : {
			id : 0,
			cid : 0,
			phone : '',
			password : ''
		},

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
				.get('index.php?s=/Admin/User/users', map)
				.then(function(res) {
		    		this.list = res.data.data;
		    		this.total = parseInt(res.data.count);
		    },function(res){
		        console.log(res.status);
		    });
		},

		tab : function (type) {
			if (type !== this.isActive) this.isActive = type
		},

		userInfo : function (id) {
			this.$http
				.get('getUserInfo', {
					id : id
				})
				.then(function(res) {
					this.detail = res.data;
		    },function(res){
		        console.log(res.status);
		    });
		},

		addUser : function () {
			this.getCollegeByType();
			$('#myModal').modal('show');
		},

		modify : function () {
			this.isModify = true;
		},

		cancel : function () {
			this.isModify = false;
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