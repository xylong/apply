var vm = new Vue({
    data : {
        total: 0,
        display: 10,
        current: 1,

        list : [],
        keyword : '',

        user : {
            id : '',
            account : '',
            id_number : '',
            phone : '',
            password : '',
            repassword : ''
        },
        prompt : {
            account : {isVisible : false, msg : '账号不能为空'},
            password : {isVisible : false, msg : ''},
            repassword : {isVisible : false, msg : '两次密码输入不一致'},
            id_number : {isVisible : false, msg : '一卡通不能为空'},
            phone : {isVisible : false, msg : '请输入正确手机号'}
        },

        uid : 0,    // 用户id
        role : [],  // 角色列表
        jurisdiction : []   // 角色权限
    },

    methods : {
        getList : function (p) {
            this.uid = 0;   // 搜索或点击分页时把右边角色区关掉

            if (p) this.current = p;
            var map = {p : this.current};
            if (this.keyword.length > 0) {
				map.keyword = this.keyword;
			}

            this.$http
                .get('index.php?s=/Admin/Admin/index', map)
                .then(function(res) {
                    this.list = res.data.data;
                    this.total = parseInt(res.data.count);
            },function(res){
                console.log(res.status);
            });
        },

        // 获取权限
        access : function (id) {
            this.uid = id;
            this.$http
                .get('index.php?s=/Admin/Admin/getPermission', {
                    user_id : this.uid
                })
                .then(function(res) {
                    if (res.data) {
                        this.jurisdiction = res.data;
                    } else {
                        this.jurisdiction = [];
                    }
                },function(res){
                    console.log(res.status);
                });
        },

        // 分配权限
        assign : function () {
            if (this.jurisdiction.length === 0 || this.uid === 0) {
                toastr.warning('未选择用户或角色');
                return;
            }

            this.$http
                .post('index.php?s=/Admin/Admin/allot', {
                    role_id : this.jurisdiction,
                    user_id : this.uid
                }, {
                    emulateJSON:true
                }).then(function(res){
                    toastr.success('分配成功');
                },function(res){
                    toastr.success('分配失败');
                });
        },

        del : function (id, index) {
            swal({
                title: "确认删除?",
                text: "删除后不可恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            }, function () {
                vm.delAdmin(id);
            });
        },

        delAdmin : function (id, index) {
            this.$http
                .get('delUser', {
                    id : id
                })
                .then(function(res) {
                    swal("操作成功!", "", "success");
                    this.list.splice(index, 1);
                },function(res){
                    console.log(res.status);
                });
        },

        edit : function (id, index) {
            this.user.id = id;
            this.user.account = this.list[index].account;
            this.user.id_number = this.list[index].id_number;
            this.user.phone = this.list[index].phone;

            $('#myModal').modal('show');
        },

        sub : function () {
            if (!this.checkData()) return;

            var data = {};
            for (var item in this.user) {
                if (this.user[item] === 0 || this.user[item] === '') continue;
                data[item] = this.user[item];
            }

            this.$http
                .post('addUser', data, {
                    emulateJSON:true
                }).then(function(res){
                    toastr.success('分配成功');
                },function(res){
                    toastr.success('分配失败');
                });
        },

        checkData : function () {
            var flag = true;
            if (!this.user.account) {
                this.prompt.account.isVisible = true;
                flag = false
            } else {this.prompt.account.isVisible = false;}

            if (!this.user.id_number) {
              this.prompt.id_number.isVisible = true;
              flag = false;
            } else {this.prompt.id_number.isVisible = false}

            if (!checkPhone(this.user.phone)) {
                this.prompt.phone.isVisible = true;
                flag = false;
            } else {this.prompt.phone.isVisible = false}

            if (!this.password_strength()) {
                this.prompt.password.isVisible = true;
                flag = false;
            } else {this.prompt.password.isVisible = false}

            if (this.user.password != this.user.repassword) {
                this.prompt.repassword.isVisible = true;
                flag = false;
            } else {this.prompt.repassword.isVisible = false}

            return flag;
        },

        password_strength : function () {
            var numasc = 0;
            var charasc = 0;
            var otherasc = 0;
            if(0 == this.user.password.length){
                this.prompt.password.msg = '密码不能为空';
                return false;
            }else if(this.user.password.length < 8 || this.user.password.length > 12){
                this.prompt.password.msg = '密码至少8个字符,最多12个字符';
                return false;
            }else{
                for (var i = 0; i < this.user.password.length; i++) {
                    var asciiNumber = this.user.password.substr(i, 1).charCodeAt();
                    if (asciiNumber >= 48 && asciiNumber <= 57) {
                        numasc += 1;
                    }
                    if ((asciiNumber >= 65 && asciiNumber <= 90)||(asciiNumber >= 97 && asciiNumber <= 122)) {
                        charasc += 1;
                    }
                    if ((asciiNumber >= 33 && asciiNumber <= 47)||(asciiNumber >= 58 && asciiNumber <= 64)||(asciiNumber >= 91 && asciiNumber <= 96)||(asciiNumber >= 123 && asciiNumber <= 126)) {
                        otherasc += 1;
                    }
                }
                if(0 == numasc)  {
                    this.prompt.password.msg = '密码必须含有数字';
                    return false;
                }else if(0 == charasc){
                    this.prompt.password.msg = '密码必须含有字母';
                    return false;
                }else if(0 == otherasc){
                    this.prompt.password.msg = '密码必须含有特殊字符';
                    return false;
                }else{
                    return true;
                }
            }
        }

    },

    events:{
        pagechange:function(p){
            this.getList();
        }
    },

    ready : function () {
        this.getList();
        this.$http
            .get('index.php?s=/Admin/Admin/role')
            .then(function(res) {
                this.role = res.data;
            },function(res){
                console.log(res.status);
            });
    }
}).$mount('#app');