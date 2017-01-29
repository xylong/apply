var vm = new Vue({
    data : {
        id : 0,
        name : '',
        houses : [],
        describe : '',
        isVisible : false
    },

    methods : {
        add : function () {
            this.isVisible = true;
            this.init();
        },

        init : function () {
            this.id = 0;
            this.name = this.describe = '';
        },

        getHouse : function () {
            this.$http
                .get('index.php?s=/Admin/House/index')
                .then(function(res){
                    this.houses = res.data;
                },function(res){
                    alert(res.status);
            });
        },

        display : function (index) {
            this.id = this.houses[index]['id'];
            this.name = this.houses[index]['name'];
            this.describe = this.houses[index]['describe'];
            this.isVisible = true;
        },

        sub : function () {
            if (this.name.length === 0) {
                toastr.warning('青春工坊名称不能为空');
                return;
            }

            this.$http.post('index.php?s=/Admin/House/edit', {
                id : this.id,
                name : this.name,
                describe : this.describe
            }, {
                emulateJSON:true
            }).then(function(res){
                toastr.success('编辑成功');
                this.init();
                this.getHouse();
            },function(res){
                toastr.error('编辑失败');
            });
        }
    },

    ready : function () {
        this.getHouse();
    }
}).$mount('#house');
