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
            password : {isVisible : false, msg : '密码长度不能小于6位'},
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

            if (this.user.password != this.user.repassword) {
                this.prompt.repassword.isVisible = true;
                flag = false;
            } else {this.prompt.repassword.isVisible = false}

            return flag;
        },

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