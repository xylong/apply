var vm = new Vue({
	data : {
		isActive : 1,
		type : [
			{ id : 1, name : '物资' },
			{ id : 2, name : '青春工坊'},
			{ id : 3, name : '青广活动'},
		],

		applys : [],
		qrcode : '',
		id : 0,

		total: 0,
        display: 10,
        current: 1,
	},

	computed : {
		url : function () {
			switch (this.isActive) {
				case 1:
					return 'index.php?s=/Home/Public/getBorrowById';
					break;

				case 2:
					return 'index.php?s=/Home/Public/getHouseById';
					break;
				
				default:
					return 'index.php?s=/Home/Public/getVenueById';
					break;
			}
		}
	},

	methods : {
		changeType : function (id) {
			if (id !== this.isActive) this.isActive = id;
		},

		// 申请列表
		getList : function (p) {
            if (p) this.current = p;

            this.$http
                .get('index.php?s=/Home/Base/applyRecord', {
                    type : this.isActive,
                    p : this.current
                })
                .then(function(res) {
                    this.applys = res.data.data;
                    this.total = parseInt(res.data.count);
                },function(res){
                    console.log(res.status);
                });
        },

        // 查看二维码
        qr : function (id) {
        	this.id = id;
            this.$http.get('qrcode', {
            	id   : this.id,
            	type : this.isActive
            }).then(function(res){
                this.qrcode = res.data;
                $('#myModal').modal('show');
            },function(res){
                console.log(res.status);
            });
        },

        download : function () {
            window.location.href = 'downloadQR?id=' + this.id + '&type=' + this.isActive;
        }
	},

	events:{
        pagechange:function(p){
            this.getList();
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