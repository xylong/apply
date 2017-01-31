var vm = new Vue({
    data : {
        total: 0,
        display: 10,
        current: 1,

        isActive : 0,
        tab : [{type:0,name:'未审核'},{type:1,name:'已审核'}],
        applys : [],

        detail : {}, // 申请详情
        result : [] // 审核结果
    },
    methods : {
        tabChange : function (type) {
			if (type !== this.isActive) this.isActive = type
		},

        getList : function (p) {
            if (p) this.current = p;

            this.$http
				.get('index.php?s=/Admin/House/apply', {
                    is_examine : this.isActive,
                    p : this.current
                })
				.then(function(res) {
                    this.applys = res.data.data;
                    this.total = parseInt(res.data.count);
    		    },function(res){
    		        console.log(res.status);
    		    });
        },

        review : function (id) {
            this.id = id;

            this.$http
				.get('index.php?s=/Admin/House/applyDetail', {
                    id : id
                })
				.then(function(res) {
                    this.detail = res.data.apply;
                    this.result = res.data.result;
		    },function(res){
		        console.log(res.status);
		    });
        }
    },
    ready : function () {
        this.getList();
    }
}).$mount('#apply');


// 监听选项卡改变
vm.$watch('isActive', function() {
    this.getList(1);
});
