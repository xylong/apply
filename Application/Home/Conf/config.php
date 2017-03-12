<?php
return array(
	
	/*认证*/
    'USER_AUTH_KEY'     =>'uid',    // 用户认证SESSION标记
    'USER_AUTH_GATEWAY' =>'public/login',// 默认认证网关

    'SESSION_OPTIONS' =>  array(
        'name' => 'uid',                    //设置session名     
        'expire' => 36000,                      //SESSION过期时间，单位秒    
        'use_trans_sid' => 1,                               //跨页传递    
        'use_only_cookies' => 0,                               //是否只开启基于cookies的session的会话方式    
    ),

);