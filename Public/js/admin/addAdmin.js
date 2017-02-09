var vm = new Vue({
	data : {
		user : {
			account : '',
			password : '',
			repassword : '',
			id_number : '',
			phone : ''
		},
		prompt : {
			account : {isVisible : false, msg : '账号不能为空'},
			password : {isVisible : false, msg : '密码长度不能小于6位'},
			repassword : {isVisible : false, msg : '两次密码输入不一致'},
			id_number : {isVisible : false, msg : '一卡通不能为空'},
			phone : {isVisible : false, msg : '请输入正确手机号'}
		}
	},

	methods : {
		sub : function () {
			if (!this.checkData()) return;

			this.$http.post('addUser', this.user, {
                    emulateJSON:true
                }).then(function(res){
                    if (res.data.status) {
                      toastr.success('申请提交成功');
                      for (var key in this.user) {
                        this.user[key] = '';
                      } 
                    }else {
                      toastr.error(res.data.info);
                    }
                },function(res){
                    toastr.error('申请提交失败');
                });
		},

		checkData : function () {
            var flag = true;
           	if (!this.user.account) {
           		this.prompt.account.isVisible = true;
           		flag = false
           	} else {this.prompt.account.isVisible = false;}

           	if (!checkPhone(this.user.phone)) {
           		this.prompt.phone.isVisible = true;
           		flag = false;
           	} else {this.prompt.phone.isVisible = false}

           	if (this.user.password.length < 6) {
           		this.prompt.password.isVisible = true;
           		flag = false;
           	} else {this.prompt.password.isVisible = false}

           	if (this.user.password != this.user.repassword) {
           		this.prompt.repassword.isVisible = true;
           		flag = false;
           	} else {this.prompt.repassword.isVisible = false}

            if (this.user.id_number.length === 0) {
              this.prompt.id_number.isVisible = true;
              flag = false;
            } else {this.prompt.id_number.isVisible = false}

           	return flag;
        },
	},

	ready : function () {
		
	}
}).$mount('#user');