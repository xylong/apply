var vm = new Vue({
	data : {
		keyword : '',
		list : [],

		total: 0,
        display: 10,
        current: 1
	},

	methods : {
		getList : function (p) {
			if (p) this.current = p;

			this.$http.get('colleges',{
				keyword : this.keyword,
				p : this.current
		    }).then(function(res){
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
