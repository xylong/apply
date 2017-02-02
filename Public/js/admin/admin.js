var vm = new Vue({
    data : {
        total: 0,
        display: 10,
        current: 1,

        list : [],
        keyword : '',

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
