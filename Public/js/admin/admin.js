var vm = new Vue({
    data : {
        total: 0,
        display: 10,
        current: 1,

        list : [],
        keyword : ''
    },

    methods : {
        getList : function (p) {
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

    },

    events:{
        pagechange:function(p){
            this.getList();
        }
    },

    ready : function () {
        this.getList();
    }
}).$mount('#app');
