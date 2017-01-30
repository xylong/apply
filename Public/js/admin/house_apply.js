var vm = new Vue({
    data : {
        isActive : 0,
        tab : [{type:0,name:'未审核'},{type:1,name:'已审核'}],
        applys : []
    },
    methods : {
        tabChange : function (type) {
			if (type !== this.isActive) this.isActive = type
		},

        getList : function (p) {
            var map = { $is_examine : this.isActive };

            this.$http
				.get('index.php?s=/Admin/House/apply', map)
				.then(function(res) {
                    this.applys = res.data;
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
    console.log(this.isActive);
});
