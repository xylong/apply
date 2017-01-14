<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 客户管理</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/apply/Public/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/apply/Public/css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <!-- Data Tables -->
    <link href="/apply/Public/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <link href="/apply/Public/css/animate.css" rel="stylesheet">
    <link href="/apply/Public/css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row" id="apply">
            <div class="col-sm-6">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="clients-list">
                            <div class="panel blank-panel">

                                <div class="panel-heading">
                                    <div class="panel-title m-b-md">
                                        <h4>申请备案</h4>
                                    </div>
                                    <div class="panel-options">

                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="tabs_panels.html#tab-4" @click="changeType(1)">物资</a></li>
                                            <li class=""><a data-toggle="tab" href="tabs_panels.html#tab-5" @click="changeType(2)">青春广场</a></li>
                                            <li class=""><a data-toggle="tab" href="tabs_panels.html#tab-6" @click="changeType(3)">展场展架</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div id="tab-4" class="tab-pane active">
                                            <table class="table table-striped table-bordered table-hover borrow">
                                                <thead>
                                                    <tr>
                                                        <th>申请号</th>
                                                        <th>主题</th>
                                                        <th>联系方式</th>
                                                        <th>申请时间</th>
                                                        <th>查看</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(is_array($borrow)): $i = 0; $__LIST__ = $borrow;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr class="gradeX">
                                                            <td><?php echo ($item["apply_code"]); ?></td>
                                                            <td><?php echo ($item["theme"]); ?></td>
                                                            <td><?php echo ($item["phone"]); ?></td>
                                                            <td class="center"><?php echo ($item["apply_time"]); ?></td>
                                                            <td class="client-status"><button type="button" style="cursor:pointer;" class="btn btn-xs btn-info" @click="review(<?php echo ($item["id"]); ?>)">查看</button></td>
                                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div id="tab-5" class="tab-pane">
                                            <table class="table table-striped table-bordered table-hover young">
                                                <thead>
                                                    <tr>
                                                        <th>申请号</th>
                                                        <th>申请人</th>
                                                        <th>联系方式</th>
                                                        <th>指导老师</th>
                                                        <th>申请时间</th>
                                                        <th>审核</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(is_array($young)): $i = 0; $__LIST__ = $young;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr class="gradeX">
                                                            <td><?php echo ($item["apply_code"]); ?></td>
                                                            <td><?php echo ($item["emperson"]); ?></td>
                                                            <td><?php echo ($item["phone"]); ?></td>
                                                            <td class="center"><?php echo ($item["counselor"]); ?></td>
                                                            <td class="center"><?php echo ($item["apply_time"]); ?></td>
                                                            <td class="client-status"><button type="button" style="cursor:pointer;" class="btn btn-xs btn-info" @click="review(<?php echo ($item["id"]); ?>)">查看</button></td>
                                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="tab-6" class="tab-pane">
                                            <table class="table table-striped table-bordered table-hover venue">
                                                <thead>
                                                    <tr>
                                                        <th>申请号</th>
                                                        <th>主题</th>
                                                        <th>联系方式</th>
                                                        <th>申请时间</th>
                                                        <th>审核</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(is_array($venue)): $i = 0; $__LIST__ = $venue;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr class="gradeX">
                                                            <td><?php echo ($item["apply_code"]); ?></td>
                                                            <td><?php echo ($item["theme"]); ?></td>
                                                            <td><?php echo ($item["phone"]); ?></td>
                                                            <td class="center"><?php echo ($item["apply_time"]); ?></td>
                                                            <td class="client-status"><button type="button" style="cursor:pointer;" class="btn btn-xs btn-info" @click="review(<?php echo ($item["id"]); ?>)">查看</button></td>
                                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6" v-if="info.length !== 0">

                <!-- 物资申请 -->
                <div class="ibox" v-if="type == 1">
                    <div class="ibox-content">
                        <div class="row m-t-sm">
                            <div class="col-sm-12">
                                <div class="panel blank-panel">
                                    <div class="panel-body">
                                        <div class="tab-content">
                                            <div v-bind:class="[isActive ? activeClass : '', showClass]">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="m-b-md">
                                                            <h2 v-text="info.theme"></h2>
                                                        </div>
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
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <dl class="dl-horizontal">
                                                            <dt>联系方式：</dt>
                                                            <dd v-text="info.phone"></dd>
                                                            <dt>申请单位：</dt>
                                                            <dd v-text="info.nickname"></dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-sm-7" id="cluster_info">
                                                        <dl class="dl-horizontal">
                                                            <dt>开始时间：</dt>
                                                            <dd v-text="info.stime"></dd>
                                                            <dt>结束时间：</dt>
                                                            <dd v-text="info.etime"></dd>
                                                            <dt>借用详情</dt>
                                                            <dd>
                                                                <ul>
                                                                    <li v-for="item in info.borrow">
                                                                        <span class="text-primary">{{item.name}}</span>&nbsp;&nbsp;
                                                                        <span class="text-warning">{{item.number}}个</span>
                                                                    </li>
                                                                  </ul>
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="form-group" v-for="item in info.equipments">
                                                        <label class="col-sm-2 control-label" v-text="item.name"></label>
                                                        <div class="col-sm-10">
                                                            <label class="checkbox-inline" v-for="e in item.child">
                                                                <input v-if="info.isagree == null" type="checkbox" v-bind:value="e.id" v-model="equipments">{{e.number}}</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="hr-line-dashed"></div>

                                                <div class="ibox float-e-margins">
                                                    <div class="ibox-title">
                                                        <h5 v-text="info.theme + '审核详情'"></h5>
                                                    </div>

                                                    <div class="timeline-item" v-for="(index, v) in step">
                                                        <div class="row">
                                                            <div class="col-xs-3 date" :class="highlight">
                                                                <i v-if="v.isagree == null" class="fa fa-spinner"></i>
                                                                <i v-if="v.isagree == 1" class="fa fa-check"></i>
                                                                <i v-if="v.isagree == 2" class="fa fa-close"></i>
                                                                <p v-if="v.time" class="text-info" v-text="v.time"></p>
                                                                <p v-else class="text-info">待审核</p>
                                                                <br>
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

                <!-- 工坊申请 -->
                <div class="ibox" v-if="type == 2">
                    <div class="ibox-content">
                        <div class="row m-t-sm">
                            <div class="col-sm-12">
                                <div class="panel blank-panel">
                                    <div class="panel-body">
                                        <div class="tab-content">
                                            <div v-bind:class="[isActive ? activeClass : '', showClass]">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="m-b-md">
                                                            <h2 v-text="info.nickname"></h2>
                                                        </div>
                                                        <dl class="dl-horizontal">
                                                            <dt>借用工坊：</dt>
                                                            <dd><span class="label label-primary" v-text="info.yname"></span>
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <dl class="dl-horizontal">
                                                            <dt>申&nbsp;请&nbsp;人：</dt>
                                                            <dd v-text="info.emperson"></dd>
                                                            <dt>联系方式：</dt>
                                                            <dd v-text="info.phone"></dd>
                                                            <dt>申请单位：</dt>
                                                            <dd v-text="info.nickname"></dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-sm-7" id="cluster_info">
                                                        <dl class="dl-horizontal">
                                                            <dt>开始时间：</dt>
                                                            <dd v-text="info.stime"></dd>
                                                            <dt>结束时间：</dt>
                                                            <dd v-text="info.etime"></dd>
                                                            <dt>指导老师：</dt>
                                                            <dd v-text="info.counselor"></dd>
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
                                                
    
                                                <div class="hr-line-dashed"></div>

                                                <div class="ibox float-e-margins">
                                                    <div class="ibox-title">
                                                        <h5 v-text="info.nickname + '审核详情'"></h5>
                                                    </div>

                                                    <div class="timeline-item" v-for="(index, v) in step">
                                                        <div class="row">
                                                            <div class="col-xs-3 date" :class="highlight">
                                                                <i v-if="v.isagree == null" class="fa fa-spinner"></i>
                                                                <i v-if="v.isagree == 1" class="fa fa-check"></i>
                                                                <i v-if="v.isagree == 2" class="fa fa-close"></i>
                                                                <p v-if="v.time" class="text-info" v-text="v.time"></p>
                                                                <p v-else class="text-info">待审核</p>
                                                                <br>
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

                <!-- 展场展架 -->
                <div class="ibox" v-if="type == 3">
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
                                                                    <!-- <a class="dropdown-toggle btn btn-primary btn-xs" data-toggle="dropdown" href="javascript:;" aria-expanded="false" @click="showUnion">
                                                                        设置联合审批
                                                                    </a> -->
                                                                    <!-- <a v-if="isUnion" href="javascript:;" class="btn btn-xs btn-primary" @click="setUnion">提交</a> -->
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

    <!-- Data Tables -->
    <script src="/apply/Public/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="/apply/Public/js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- 自定义js -->
    <script src="/apply/Public/js/content.js?v=1.0.0"></script>
    <script src="/apply/Public/js/layer/layer.js"></script>
    <script src="/apply/Public/js/vue.js"></script>

    <script>
        $(function () {
            $('.full-height-scroll').slimScroll({
                height: '100%'
            });
            $('.borrow').dataTable();
            $('.young').dataTable();
            $('.venue').dataTable();
        });

        var apply = new Vue({
            el : '#apply',
            data : {
                activeClass: 'active',
                showClass: 'tab-pane',
                isActive : true,
                highlight : '',

                info : [],  // 申请内容
                step : [],  // 审核流程
                type : 1,    // 申请类型

                application : [],    // 申请
                visiblePages : '',
                equipments : [],    // 选中的要借出的设备

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
                tab : function (bool) {
                    this.isActive = bool;
                },

                changeType : function (type) {
                    this.type = type;
                    this.info = this.step = [];
                },

                getData : function (id) {
                    var _this = this;
                    switch (this.type) {
                        case 1:
                            $.get("<?php echo U('Borrow/review');?>", {
                                id : id,
                                type : this.type
                            }, function (data) {
                                if (data.status) {
                                    apply.info = data.data.info;
                                    apply.step = data.data.step;
                                    _this.progress_bar();
                                } else {
                                    layer.msg('获取审核信息失败', {icon: 2});
                                }
                            }, 'json');
                            break;

                        case 2:
                            $.get("<?php echo U('Workshop/review');?>", {
                                id : id,
                                type : this.type
                            }, function (data) {
                                if (data.status) {
                                    apply.info = data.data.info;
                                    apply.step = data.data.step;
                                    _this.progress_bar();
                                } else {
                                    layer.msg('获取审核信息失败', {icon: 2});
                                }
                            }, 'json');
                            break;

                        case 3:
                            this.isUnion = false;
                            this.checked = [];

                            $.get("<?php echo U('Venue/review');?>", {
                                id : id,
                                type : this.type
                            }, function (data) {
                                if (data.status) {
                                    apply.info = data.data.info;
                                    apply.step = data.data.step;
                                    _this.progress_bar();
                                } else {
                                    layer.msg('获取审核信息失败', {icon: 2});
                                }
                            }, 'json');
                            break;
                    }
                },

                progress_bar : function () {
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
                },

                // 查看审核
                review : function (id) {
                    this.getData(id);
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

                // 展示联合审批
                showUnion : function () {
                    this.isUnion = true;
                },

            },
            
        });
    </script>

    
    

</body>

</html>