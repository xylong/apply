<?php
return array(
	
    /*认证*/
    'USER_AUTH_KEY'     =>'auth_id',    // 用户认证SESSION标记
    'ADMIN_AUTH_KEY'    =>'administrator',        
    'USER_AUTH_GATEWAY' =>'public/login',// 默认认证网关
    'DB_LIKE_FIELDS'    =>'content|remark',

    'SESSION_OPTIONS' =>  array(
        'name' => 'auth_id',                    //设置session名     
        'expire' => 36000,                      //SESSION过期时间，单位秒    
        'use_trans_sid' => 1,                               //跨页传递    
        'use_only_cookies' => 0,                               //是否只开启基于cookies的session的会话方式    
    ),

	
);