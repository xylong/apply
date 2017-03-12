var vm = new Vue({
	data : {
		type : [
			{ id : 1, name : '学院团委学生会' },
			{ id : 2, name : '社团'},
			{ id : 3, name : '校级学生组织'},
		],

		prompt : {
                selected : {isVisible : false, msg : '请选择用户类型'},
                phone : {isVisible : false, msg : '手机号格式错误'},
                password : {isVisible : false, msg : '密码不能小于6位'},
                repassword : {isVisible : false, msg : '与密码不符'},
                cid : {isVisible : false, msg : '请选择学院/单位'},
                society : {isVisible : false, msg : ''}
            },

		college : [],

    cid : 0,
    phone : '',
		society : '',
    password : '',
    selected : 0,
    repassword : '',
	},

	methods : {
		sub : function () {
			if (!this.checkData()) return;

			this.$http.post('addUser', {
                    cid : this.cid,
                    type : this.selected,
                    phone : this.phone,
                    password : this.password,
                    society : this.society,
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
           	if (!this.selected) {
           		this.prompt.selected.isVisible = true;
           		flag = false
           	} else {this.prompt.selected.isVisible = false;}

           	if (!checkPhone(this.phone)) {
           		this.prompt.phone.isVisible = true;
           		flag = false;
           	} else {this.prompt.phone.isVisible = false}

           	if (this.password.length < 6) {
           		this.prompt.password.isVisible = true;
           		flag = false;
           	} else {this.prompt.password.isVisible = false}

           	if (this.password != this.repassword) {
           		this.prompt.repassword.isVisible = true;
           		flag = false;
           	} else {this.prompt.repassword.isVisible = false}

            if (!this.cid) {
              this.prompt.cid.isVisible = true;
              flag = false;
            } else {this.prompt.cid.isVisible = false}

           	return flag;
        },
	},

	ready : function () {
		this.$http
			.get('index.php?s=/Admin/User/getAllCollege')
			.then(function(res) {
				this.college = res.data;
	    },function(res){
	        console.log(res.status);
	    });
	}

}).$mount('#user');