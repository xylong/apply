<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 展场展架申请</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/apply/Public/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/apply/Public/css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <link href="/apply/Public/css/animate.css" rel="stylesheet">
    <link href="/apply/Public/css/style.css?v=4.1.0" rel="stylesheet">
    <link href="/apply/Public/css/plugins/toastr/toastr.min.css" rel="stylesheet">
</head>

<body class="gray-bg" id="apply">
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-sm-6">
                <div class="ibox">
                    <div class="ibox-content">
                        <span class="text-muted small pull-right">最后更新：<i class="fa fa-clock-o"></i> 2015-09-01 12:00</span>
                        <h2>申请列表</h2>
                        <p>
                            展场展架申请
                        </p>
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-1">
                                <button type="button" id="loading-example-btn" class="btn btn-white btn-sm" @click="relaod"><i class="fa fa-refresh"></i> 刷新</button>
                            </div>
                            <div class="col-md-11">
                                <form role="form" class="form-inline" action="<?php echo U('Venue/export');?>" method="post" id="export">
                                    <div class="form-group" id="data_5">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <input id="sdate" class="input-sm form-control" name="sdate" placeholder="选择开始时间" readonly>
                                            <span class="input-group-addon">到</span>
                                            <input id="edate" class="input-sm form-control" name="edate" placeholder="选择结束时间" readonly>
                                        </div>
                                    </div>
                                    <button class="btn btn-white" type="button" @click="export"><i class="fa fa-sign-out"></i>导出</button>
                                </form>
                            </div>
                        </div>
                        <div class="clients-list">
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <tbody>
                                                    <tr v-for="v in application">
                                                        <td><a data-toggle="tab" href="javascript:;" class="client-link" v-text="v.apply_code"></a></td>
                                                        <td v-text="v.theme"></td>
                                                        <td class="contact-type"><i class="fa fa-clock-o"> </i></td>
                                                        <td v-text="v.apply_time"></td>
                                                        <td class="client-status"><button type="button" style="cursor:pointer;" class="btn btn-xs btn-info" @click="review(v.aid)">审核</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div id="page"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6" v-if="info.length !== 0">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row m-t-sm">
                            <div class="col-sm-12">
                                <div class="panel blank-panel">
                                    <div class="panel-heading">
                                        <div class="panel-options">
                                            <ul class="nav nav-tabs">
                                                <li><a href="javascript:;" @click="tab(true)">申请详情</a>
                                                </li>
                                                <li class=""><a href="javascript:;" @click="tab(false)">审核进度</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="tab-content">
                                            <div v-bind:class="[isActive ? activeClass : '', showClass]">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="m-b-md">
                                                            <h2 v-text="info.theme"></h2>
                                                        </div>
                                                        <dl class="dl-horizontal">
                                                            <dt>状态：</dt>
                                                            <dd>
                                                                <span v-if="progress.width == '100%'" class="label label-primary">已完成</span>
                                                                <span v-else class="label label-primary">进行中</span>
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <dl class="dl-horizontal">

                                                            <dt>申&nbsp;请&nbsp;人&nbsp;：</dt>
                                                            <dd v-text="info.nickname"></dd>
                                                            <dt>联系方式：</dt>
                                                            <dd v-text="info.phone"></dd>
                                                            <dt>申请单位：</dt>
                                                            <dd v-text="info.nickname"></dd>
                                                            <dt>摆放地点：</dt>
                                                            <dd v-text="info.place"></dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-sm-7" id="cluster_info">
                                                        <dl class="dl-horizontal">

                                                            <dt>开始时间：</dt>
                                                            <dd v-text="info.stime"></dd>
                                                            <dt>结束时间：</dt>
                                                            <dd v-text="info.etime"></dd>
                                                            <dt>展板数量：</dt>
                                                            <dd class="text-warning" v-text="info.number"></dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <dl class="dl-horizontal">
                                                            <dt>当前进度</dt>
                                                            <dd>
                                                                <div class="progress progress-striped active m-b-sm">
                                                                    <div v-bind:style="progress;" class="progress-bar"></div>
                                                                </div>
                                                                <small>当前已完成申请总进度的 <strong v-text="progress.width"></strong></small>
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>

                                                <div class="mail-attachment">
                                                    <p>
                                                        <span><i class="fa fa-paperclip"></i> 附件 - </span>
                                                        <a href="javascript:;">图片预览</a>
                                                    </p>

                                                    <div class="attachment" id="preview">
                                                        <div class="file-box">
                                                            <div class="file">
                                                                <a v-bind:href="info.download">
                                                                    <span class="corner"></span>

                                                                    <div class="icon">
                                                                        <i class="fa fa-file"></i>
                                                                    </div>
                                                                    <div class="file-name">
                                                                        下载策划文件.zip
                                                                    </div>
                                                                </a>
                                                            </div>

                                                        </div>
                                                        <div class="file-box" v-for="(index, img) in info.img">
                                                            <div class="file">
                                                                <a href="javascript:;">
                                                                    <span class="corner"></span>

                                                                    <div class="image">
                                                                        <img alt="image" class="img-responsive" v-bind:src="img" @click="preview(img)">
                                                                    </div>
                                                                    <div class="file-name">
                                                                    {{index + 1 + '.jpg'}}
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div v-bind:class="[isActive ? '' : activeClass, showClass]">
                                                <div class="row animated fadeInRight">
                                                    <div class="col-sm-12">
                                                        <div class="ibox float-e-margins">
                                                            <div class="ibox-title">
                                                                <h5>审核详情</h5>
                                                                <div v-if="info.is_union == 0" class="ibox-tools">
                                                                    <a class="dropdown-toggle btn btn-primary btn-xs" data-toggle="dropdown" href="javascript:;" aria-expanded="false" @click="showUnion">
                                                                        设置联合审批
                                                                    </a>
                                                                    <a v-if="isUnion" href="javascript:;" class="btn btn-xs btn-primary" @click="setUnion">提交</a>
                                                                    <ul class="dropdown-menu todo-list m-t small-list ui-sortable">
                                                                        <li v-for="v in departments">
                                                                            <input type="checkbox" value="{{v.id}}" v-model="checked">
                                                                            <span class="m-l-xs text-info" v-text="v.name"></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <div class="timeline-item" v-for="(index, v) in step">
                                                                <div class="row">
                                                                    <div class="col-xs-3 date" :class="v.highlight">
                                                                        <i v-if="v.isagree == null" class="fa fa-spinner"></i>
                                                                        <i v-if="v.isagree == 1" class="fa fa-check"></i>
                                                                        <i v-if="v.isagree == 2" class="fa fa-close"></i>
                                                                        <p v-if="v.time" class="text-info" v-text="v.time"></p>
                                                                        <p v-else class="text-info">待审核</p>
                                                                        <br>
                                                                        <button v-if="v.isagree == null && v.access == 1" type="button" class="btn btn-primary btn-xs" @click="submit">提交</button>
                                                                    </div>
                                                                    <div class="col-xs-7 content">
                                                                        <p class="m-b-xs"><strong class="text-warning" v-text="v.name"></strong></p>
                                                                        <div class="col-sm-12">
                                                                            <textarea v-if="v.isagree == null && v.access == 1" class="form-control" v-model="opinion"></textarea>
                                                                            <p v-else v-text="v.opinion" class="text-success"></p>

                                                                            <div class="switch" v-if="v.isagree == null && v.access == 1">
                                                                                <div class="onoffswitch">
                                                                                    <input type="checkbox" v-model="isagree" class="onoffswitch-checkbox" id="{{'example' + index}}">
                                                                                    <label class="onoffswitch-label" for="{{'example' + index}}">
                                                                                        <span class="onoffswitch-inner"></span>
                                                                                        <span class="onoffswitch-switch"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- 全局js -->
    <script src="/apply/Public/js/jquery.min.js?v=2.1.4"></script>
    <script src="/apply/Public/js/bootstrap.min.js?v=3.3.6"></script>

    <script src="/apply/Public/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Toastr script -->
    <script src="/apply/Public/js/plugins/toastr/toastr.min.js"></script>

    <!-- 自定义js -->
    <script src="/apply/Public/js/jquery.twbsPagination.js" charset="utf-8"></script>
    <script src="/apply/Public/js/plugins/layer/laydate/laydate.js"></script>
    <script src="/apply/Public/js/content.js?v=1.0.0"></script>
    <script src="/apply/Public/js/layer/layer.js"></script>
    <script src="/apply/Public/js/vue.js"></script>

    <script>
        $(function () {
            $('.full-height-scroll').slimScroll({
                height: '100%'
            });
        });

        laydate({
            elem: '#sdate',
            event: 'focus'
        });
        laydate({
            elem: '#edate',
            event: 'focus'
        });

        var apply = new Vue({
            el : '#apply',
            data : {
                activeClass: 'active',
                showClass: 'tab-pane',
                isActive : true,
                application : [],   // 申请
                info : [],  // 申请内容
                step : [],  // 审核流程
                type : 3,    // 申请类型

                opinion : '',
                isagree : false,
                progress : {
                    width : '0%',
                },

                departments : [],    // 联合审批部门
                checked : [],    // 选中的联合审批部门
                isUnion : false
            },
            methods : {
                // 刷新
                relaod : function () {
                    $.get("<?php echo U('Venue/lists');?>", function (data) {
                        if (data.status) {
                            apply.application = data.data;
                        }
                    }, 'json');
                },

                // 导出
                export : function () {
                    var sdate = $('#sdate').val(),
                        edate = $('#edate').val();

                    if (sdate.length !== 0 && edate.length !== 0) {
                        // 结束时间大于开始时间
                        if (sdate <= edate) {
                            $('#export').submit();
                        } else {
                            toastr.error('开始日期不能大于结束日期!');
                        }
                    } else {
                        toastr.error('请选择日期范围!');
                    }
                },

                // 切换选项卡
                tab : function (bool) {
                    this.isActive = bool;
                },

                // 展示联合审批
                showUnion : function () {
                    this.isUnion = true;
                },

                // 设置联合审批
                setUnion : function () {
                    if (!this.checked.length) {
                        toastr.error('没有选择任何联合审批部门!');
                        return;
                    }

                    $.post("<?php echo U('Venue/setUnion');?>", {
                        id : this.info.id,
                        checked : this.checked
                    },function (data) {
                        if (data.status) {
                            apply.isUnion = false;
                            apply.checked = [];
                            toastr.success(data.info);
                        } else {
                            toastr.error(data.info);
                        }
                    }, 'json');
                },

                // 预览
                preview : function (img) {
                    layer.ready(function(){
                        layer.photos({
                            photos: {
                                "title": "",
                                "id": 0,
                                "start": 0,
                                "data": [
                                {
                                    "alt": "",
                                    "pid": 0,
                                    "src": img,
                                    "thumb": ""
                                }
                                ]
                            },
                            // anim: 5
                        });
                    });
                },

                page : function (pageid) {
                    $.get("<?php echo U('Venue/lists');?>", {
                        pageid : localStorage.page
                    }, function (data) {
                        if (data.status) {
                            apply.application = data.data.data;
                            apply.visiblePages = data.data.count;

                            $('#page').twbsPagination({
                                totalPages: apply.visiblePages,
                                visiblePages: apply.visiblePages,
                                version: '1.1',
                                onPageClick: function(event, page) {
                                    localStorage.page = page;
                                    apply.page(apply.type, page);
                                    $('#page-content').text('Page ' + page);
                                }
                            });
                        }
                    }, 'json');
                },

                // 查看审核
                review : function (id) {
                    this.isUnion = false;
                    this.checked = [];

                    $.get("<?php echo U('Venue/review');?>", {
                        id : id,
                        type : this.type
                    }, function (data) {
                        if (data.status) {
                            apply.info = data.data.info;
                            apply.step = data.data.step;

                            for (var i = 0; i < apply.step.length; i++) {
                                // 审核进程高亮
                                switch (apply.step[i]['isagree']) {
                                    case '1':
                                        apply.step[i]['highlight'] = 'text-success';
                                        break;
                                    case '2':
                                        apply.step[i]['highlight'] = 'text-danger';
                                        break;
                                    default:
                                        apply.step[i]['highlight'] = 'text-warning';
                                        break;
                                }
                            }

                            // 计算进度
                            var numerator = 0, // 分子
                                denominator = apply.step.length;

                            for (var i = 0; i < denominator; i++) {
                                if (apply.step[i].isagree != null) {
                                    if (apply.step[i].isagree == 2) {
                                        denominator = numerator;
                                        break;
                                    }
                                    numerator++;
                                }
                            }
                            apply.progress.width = Math.ceil(numerator / denominator * 100) + '%';

                        } else {
                            toastr.error('获取审核信息失败!');
                        }
                    }, 'json');
                },

                // 提交审核
                submit : function () {
                    $.post("<?php echo U('Venue/approve');?>", {
                        aid : this.info.id,
                        type : this.type,
                        isagree : this.isagree ? 1 : 2,
                        opinion : this.opinion
                    }, function (data) {
                        if (data.status) {
                            toastr.success(data.info);
                            this.opinion = '';
                            this.isagree = false;
                        } else {
                            toastr.error(data.info);
                        }
                    });
                }

                
            },
            ready : function () {
                this.page(1);
                $.get("<?php echo U('Venue/departments');?>", function (data) {
                    if (data.status) {
                        apply.departments = data.data;
                    }
                }, 'json');
            }
        });
    </script>
</body>

</html>