<?php
return array(
	// 数据库配置
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'oa', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'oa_', // 数据库表前缀

    'URL_MODEL' => 3,

	/* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__CSS__'       => __ROOT__ . '/Public/css',
        '__JS__'        => __ROOT__ . '/Public/js',
        '__IMG__'       => __ROOT__ . '/Public/img',
        '__FONT__'      => __ROOT__ . '/Public/font-awesome',
    ),

    /* 审核步骤 */
    'STEP' => array(
        array(10, 12),  // 物资审核步骤
        array(10),  // 青春工坊审核步骤
    )


);
