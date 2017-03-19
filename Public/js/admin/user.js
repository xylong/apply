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

		newpwd : '',
		renewpwd : '',
		prompt : {
                phone : {isVisible : false, msg : '手机号格式错误'},
                password : {isVisible : false, msg : '密码不能小于6位'},
                repassword : {isVisible : false, msg : '与密码不符'}
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

		modify : function () {
			this.isModify = true;
		},

		sub : function () {
			if (!this.checkData()) return;
			this.$http
				.post('addUser', {
					id : this.detail.id,
                    phone : this.detail.phone,
                    password : this.newpwd
                }, {
                    emulateJSON:true
                }).then(function(res){
                    toastr.success('申请提交成功');
                    this.phone = this.password = this.repassword = this.society = '';
                },function(res){
                    toastr.error('申请提交失败');
                });
		},

		checkData : function () {
            var flag = true;

            if (this.detail.phone.length !== 0) {
	           	if (!checkPhone(this.detail.phone)) {
	           		this.prompt.phone.isVisible = true;
	           		flag = false;
	           	} else {this.prompt.phone.isVisible = false}
            }

           	if (this.newpwd.length < 6) {
           		this.prompt.password.isVisible = true;
           		flag = false;
           	} else {this.prompt.password.isVisible = false}

           	if (this.renewpwd != this.newpwd) {
           		this.prompt.repassword.isVisible = true;
           		flag = false;
           	} else {this.prompt.repassword.isVisible = false}

           	return flag;
        },

        del : function (id, index) {
        	this.$http
				.get('del', {
					id : id
				})
				.then(function(res) {
					this.list.splice(index, 1);
		    },function(res){
		        console.log(res.status);
		    });
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