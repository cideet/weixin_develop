<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    
    'hostname' => 'localhost',
    'database' => 'vdouwtp5',
    'username' => 'root',
    'password' => '',
    'prefix' => 'vdouw_',

    'type' => 'mysql',                      // 数据库类型
    'hostport' => '3306',                   // 端口
    'dsn' => '',                            // 连接dsn
    'params' => [],                         // 数据库连接参数
    'charset' => 'utf8',                    // 数据库编码默认采用utf8
    'debug' => true,                        // 数据库调试模式
    'deploy' => 0,                          // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'rw_separate' => false,                 // 数据库读写是否分离 主从式有效
    'master_num' => 1,                      // 读写分离后 主服务器数量
    'slave_no' => '',                       // 指定从服务器序号
    'fields_strict' => true,                // 是否严格检查字段是否存在
    'resultset_type' => 'array',            // 数据集返回类型
    'auto_timestamp' => false,              // 自动写入时间戳字段
    'datetime_format' => 'Y-m-d H:i:s',     // 时间字段取出后的默认时间格式
    'sql_explain' => false,                 // 是否需要进行SQL性能分析
];
