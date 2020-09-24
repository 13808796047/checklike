<?php

/*
 * This file is part of the overtrue/laravel-wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    /*
     * 默认配置，将会合并到各模块中
     */
    'defaults' => [
        /*
         * 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
         */
        'response_type' => 'array',

        /*
         * 使用 Laravel 的缓存系统
         */
        'use_laravel_cache' => true,

        /*
         * 日志配置
         *
         * level: 日志级别，可选为：
         *                 debug/info/notice/warning/error/critical/alert/emergency
         * file：日志文件位置(绝对路径!!!)，要求可写权限
         */
        'log' => [
            'level' => env('WECHAT_LOG_LEVEL', 'debug'),
            'file' => env('WECHAT_LOG_FILE', storage_path('logs/wechat.log')),
        ],
    ],

    /*
     * 路由配置
     */
    'route' => [
        /*
         * 开放平台第三方平台路由配置
         */
        // 'open_platform' => [
        //     'uri' => 'serve',
        //     'action' => Overeltrue\LaravWeChat\Controllers\OpenPlatformController::class,
        //     'attributes' => [
        //         'prefix' => 'open-platform',
        //         'middle' => nwareull,
        //     ],
        // ],
    ],

    /*
     * 公众号
     */
    'official_account' => [
        'dev' =>
            [
                'app_id' => env('DEV_WECHAT_OFFICIAL_ACCOUNT_APPID', ''),         // AppID
                'secret' => env('DEV_WECHAT_OFFICIAL_ACCOUNT_SECRET', ''),    // AppSecret
                'token' => env('DEV_WECHAT_OFFICIAL_ACCOUNT_TOKEN', ''),           // Token
                'aes_key' => env('DEV_WECHAT_OFFICIAL_ACCOUNT_AES_KEY', ''),                 // EncodingAESKey
                'templates' => [
                    'subscribed' => [
                        'template_id' => env('DEV_WECHAT_OFFICIAL_ACCOUNT_BOUNDPHONE_TEMPLATE_ID'),
                        'appid' => env('DEV_MINIPROGRAM_APPID'),
                        'page_path' => env('DEV_MINIPROGRAM_BINDPHONE_URL'),
                    ],
                    'pending' => [
                        'template_id' => env('DEV_WECHAT_OFFICIAL_ACCOUNT_PENDING_TEMPLATE_ID'),
                        'appid' => env('DEV_MINIPROGRAM_APPID'),
                        'page_path' => env('DEV_MINIPROGRAM_PENDING_URL'),
                    ],
                    'paid' => [
                        'template_id' => env('DEV_WECHAT_OFFICIAL_ACCOUNT_PAID_TEMPLATE_ID'),
                        'appid' => env('DEV_MINIPROGRAM_APPID'),
                        'page_path' => env('DEV_MINIPROGRAM_PAID_URL'),
                    ],
                    'checked' => [
                        'template_id' => env('DEV_WECHAT_OFFICIAL_ACCOUNT_CHECKED_TEMPLATE_ID'),
                        'appid' => env('DEV_MINIPROGRAM_APPID'),
                        'page_path' => env('DEV_MINIPROGRAM_CHECKED_URL'),
                    ],
                    'binded' => [
                        'template_id' => env('DEV_WECHAT_OFFICIAL_ACCOUNT_BINDED_TEMPLATE_ID'),
                        'appid' => env('DEV_MINIPROGRAM_APPID'),
                        'page_path' => env('DEV_MINIPROGRAM_BINDED_URL'),
                    ]
                ]
            ],
        'wf' =>
            [
                'app_id' => env('WF_WECHAT_OFFICIAL_ACCOUNT_APPID', ''),         // AppID
                'secret' => env('WF_WECHAT_OFFICIAL_ACCOUNT_SECRET', ''),    // AppSecret
                'token' => env('WF_WECHAT_OFFICIAL_ACCOUNT_TOKEN', ''),           // Token
                'aes_key' => env('WF_WECHAT_OFFICIAL_ACCOUNT_AES_KEY', ''),                 // EncodingAESKey
                'templates' => [
                    'subscribed' => [
                        'template_id' => env('WF_WECHAT_OFFICIAL_ACCOUNT_BOUNDPHONE_TEMPLATE_ID'),
                        'appid' => env('WF_MINIPROGRAM_APPID'),
                        'page_path' => env('WF_MINIPROGRAM_BINDPHONE_URL'),
                    ],
                    'pending' => [
                        'template_id' => env('WF_WECHAT_OFFICIAL_ACCOUNT_PENDING_TEMPLATE_ID'),
                        'appid' => env('WF_MINIPROGRAM_APPID'),
                        'page_path' => env('WF_MINIPROGRAM_PENDING_URL'),
                    ],
                    'paid' => [
                        'template_id' => env('WF_WECHAT_OFFICIAL_ACCOUNT_PAID_TEMPLATE_ID'),
                        'appid' => env('WF_MINIPROGRAM_APPID'),
                        'page_path' => env('WF_MINIPROGRAM_PAID_URL'),
                    ],
                    'checked' => [
                        'template_id' => env('WF_WECHAT_OFFICIAL_ACCOUNT_CHECKED_TEMPLATE_ID'),
                        'appid' => env('WF_MINIPROGRAM_APPID'),
                        'page_path' => env('WF_MINIPROGRAM_CHECKED_URL'),
                    ],
                    'binded' => [
                        'template_id' => env('WF_WECHAT_OFFICIAL_ACCOUNT_BINDED_TEMPLATE_ID'),
                        'appid' => env('WF_MINIPROGRAM_APPID'),
                        'page_path' => env('WF_MINIPROGRAM_BINDED_URL'),
                    ]
                ]
            ],
        'wp' =>
            [
                'app_id' => env('WP_WECHAT_OFFICIAL_ACCOUNT_APPID', ''),         // AppID
                'secret' => env('WP_WECHAT_OFFICIAL_ACCOUNT_SECRET', ''),    // AppSecret
                'token' => env('WP_WECHAT_OFFICIAL_ACCOUNT_TOKEN', ''),           // Token
                'aes_key' => env('WP_WECHAT_OFFICIAL_ACCOUNT_AES_KEY', ''),                 // EncodingAESKey
                'templates' => [
                    'subscribed' => [
                        'template_id' => env('WP_WECHAT_OFFICIAL_ACCOUNT_BOUNDPHONE_TEMPLATE_ID'),
                        'appid' => env('WP_MINIPROGRAM_APPID'),
                        'page_path' => env('WP_MINIPROGRAM_BINDPHONE_URL'),
                    ],
                    'pending' => [
                        'template_id' => env('WP_WECHAT_OFFICIAL_ACCOUNT_PENDING_TEMPLATE_ID'),
                        'appid' => env('WP_MINIPROGRAM_APPID'),
                        'page_path' => env('WP_MINIPROGRAM_PENDING_URL'),
                    ],
                    'paid' => [
                        'template_id' => env('WP_WECHAT_OFFICIAL_ACCOUNT_PAID_TEMPLATE_ID'),
                        'appid' => env('WP_MINIPROGRAM_APPID'),
                        'page_path' => env('WP_MINIPROGRAM_PAID_URL'),
                    ],
                    'checked' => [
                        'template_id' => env('WP_WECHAT_OFFICIAL_ACCOUNT_CHECKED_TEMPLATE_ID'),
                        'appid' => env('WP_MINIPROGRAM_APPID'),
                        'page_path' => env('WP_MINIPROGRAM_CHECKED_URL'),
                    ],
                    'binded' => [
                        'template_id' => env('WP_WECHAT_OFFICIAL_ACCOUNT_BINDED_TEMPLATE_ID'),
                        'appid' => env('WP_MINIPROGRAM_APPID'),
                        'page_path' => env('WP_MINIPROGRAM_BINDED_URL'),
                    ]
                ]
            ],
        'pp' =>
            [
                'app_id' => env('PP_WECHAT_OFFICIAL_ACCOUNT_APPID', ''),         // AppID
                'secret' => env('PP_WECHAT_OFFICIAL_ACCOUNT_SECRET', ''),    // AppSecret
                'token' => env('PP_WECHAT_OFFICIAL_ACCOUNT_TOKEN', ''),           // Token
                'aes_key' => env('PP_WECHAT_OFFICIAL_ACCOUNT_AES_KEY', ''),                 // EncodingAESKey
                'templates' => [
                    'subscribed' => [
                        'template_id' => env('PP_WECHAT_OFFICIAL_ACCOUNT_BOUNDPHONE_TEMPLATE_ID'),
                        'appid' => env('PP_MINIPROGRAM_APPID'),
                        'page_path' => env('PP_MINIPROGRAM_BINDPHONE_URL'),
                    ],
                    'pending' => [
                        'template_id' => env('PP_WECHAT_OFFICIAL_ACCOUNT_PENDING_TEMPLATE_ID'),
                        'appid' => env('PP_MINIPROGRAM_APPID'),
                        'page_path' => env('PP_MINIPROGRAM_PENDING_URL'),
                    ],
                    'paid' => [
                        'template_id' => env('PP_WECHAT_OFFICIAL_ACCOUNT_PAID_TEMPLATE_ID'),
                        'appid' => env('PP_MINIPROGRAM_APPID'),
                        'page_path' => env('PP_MINIPROGRAM_PAID_URL'),
                    ],
                    'checked' => [
                        'template_id' => env('PP_WECHAT_OFFICIAL_ACCOUNT_CHECKED_TEMPLATE_ID'),
                        'appid' => env('PP_MINIPROGRAM_APPID'),
                        'page_path' => env('PP_MINIPROGRAM_CHECKED_URL'),
                    ],
                    'binded' => [
                        'template_id' => env('PP_WECHAT_OFFICIAL_ACCOUNT_BINDED_TEMPLATE_ID'),
                        'appid' => env('PP_MINIPROGRAM_APPID'),
                        'page_path' => env('PP_MINIPROGRAM_BINDED_URL'),
                    ]
                ]
            ],
        'cn' =>
            [
                'app_id' => env('CN_WECHAT_OFFICIAL_ACCOUNT_APPID', ''),         // AppID
                'secret' => env('CN_WECHAT_OFFICIAL_ACCOUNT_SECRET', ''),    // AppSecret
                'token' => env('CN_WECHAT_OFFICIAL_ACCOUNT_TOKEN', ''),           // Token
                'aes_key' => env('CN_WECHAT_OFFICIAL_ACCOUNT_AES_KEY', ''),                 // EncodingAESKey
                'templates' => [
                    'subscribed' => [
                        'template_id' => env('CN_WECHAT_OFFICIAL_ACCOUNT_BOUNDPHONE_TEMPLATE_ID'),
                        'appid' => env('CN_MINIPROGRAM_APPID'),
                        'page_path' => env('CN_MINIPROGRAM_BINDPHONE_URL'),
                    ]
                ]
            ],
        /*
 * OAuth 配置
 *
 * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
 * callback：OAuth授权完成后的回调页地址(如果使用中间件，则随便填写。。。)
 */
//            'oauth' => [
//                'scopes' => array_map('trim', explode(',', env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_SCOPES', 'snsapi_userinfo'))),
//                'callback' => env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_CALLBACK', '/oauth/weixin/callback'),
//            ],
    ],

    /*
     * 开放平台第三方平台
     */
    // 'open_platform' => [
    //     'default' => [
    //         'app_id'  => env('WECHAT_OPEN_PLATFORM_APPID', ''),
    //         'secret'  => env('WECHAT_OPEN_PLATFORM_SECRET', ''),
    //         'token'   => env('WECHAT_OPEN_PLATFORM_TOKEN', ''),
    //         'aes_key' => env('WECHAT_OPEN_PLATFORM_AES_KEY', ''),
    //     ],
    // ],

    /*
     * 小程序
     */
    'mini_program' => [
        'dev' => [
            'app_id' => env('DEV_WECHAT_MINI_PROGRAM_APPID', ''),
            'secret' => env('DEV_WECHAT_MINI_PROGRAM_SECRET', ''),
            'token' => env('DEV_WECHAT_MINI_PROGRAM_TOKEN', ''),
            'aes_key' => env('DEV_WECHAT_MINI_PROGRAM_AES_KEY', ''),
            'mch_id' => env('DEV_WECHAT_MINI_PROGRAM_MCH_ID'),
            'key' => env('DEV_WECHAT_MINI_PROGRAM_KEY'),
        ],
        'wf' => [
            'app_id' => env('WF_WECHAT_MINI_PROGRAM_APPID', ''),
            'secret' => env('WF_WECHAT_MINI_PROGRAM_SECRET', ''),
            'token' => env('WF_WECHAT_MINI_PROGRAM_TOKEN', ''),
            'aes_key' => env('WF_WECHAT_MINI_PROGRAM_AES_KEY', ''),
            'mch_id' => env('WF_WECHAT_MINI_PROGRAM_MCH_ID'),
            'key' => env('WF_WECHAT_MINI_PROGRAM_KEY'),
        ],
        'wp' => [
            'app_id' => env('WP_WECHAT_MINI_PROGRAM_APPID', ''),
            'secret' => env('WP_WECHAT_MINI_PROGRAM_SECRET', ''),
            'token' => env('WP_WECHAT_MINI_PROGRAM_TOKEN', ''),
            'aes_key' => env('WP_WECHAT_MINI_PROGRAM_AES_KEY', ''),
            'mch_id' => env('WP_WECHAT_MINI_PROGRAM_MCH_ID'),
            'key' => env('WP_WECHAT_MINI_PROGRAM_KEY'),
        ],
        'pp' => [
            'app_id' => env('PP_WECHAT_MINI_PROGRAM_APPID', ''),
            'secret' => env('PP_WECHAT_MINI_PROGRAM_SECRET', ''),
            'token' => env('PP_WECHAT_MINI_PROGRAM_TOKEN', ''),
            'aes_key' => env('PP_WECHAT_MINI_PROGRAM_AES_KEY', ''),
            'mch_id' => env('PP_WECHAT_MINI_PROGRAM_MCH_ID'),
            'key' => env('PP_WECHAT_MINI_PROGRAM_KEY'),
        ],
        'cn' => [
            'app_id' => env('CN_WECHAT_MINI_PROGRAM_APPID', ''),
            'secret' => env('CN_WECHAT_MINI_PROGRAM_SECRET', ''),
            'token' => env('CN_WECHAT_MINI_PROGRAM_TOKEN', ''),
            'aes_key' => env('CN_WECHAT_MINI_PROGRAM_AES_KEY', ''),
            'mch_id' => env('CN_WECHAT_MINI_PROGRAM_MCH_ID'),
            'key' => env('CN_WECHAT_MINI_PROGRAM_KEY'),
        ],
    ],

    /*
     * 微信支付
     */
    // 'payment' => [
    //     'default' => [
    //         'sandbox'            => env('WECHAT_PAYMENT_SANDBOX', false),
    //         'app_id'             => env('WECHAT_PAYMENT_APPID', ''),
    //         'mch_id'             => env('WECHAT_PAYMENT_MCH_ID', 'your-mch-id'),
    //         'key'                => env('WECHAT_PAYMENT_KEY', 'key-for-signature'),
    //         'cert_path'          => env('WECHAT_PAYMENT_CERT_PATH', 'path/to/cert/apiclient_cert.pem'),    // XXX: 绝对路径！！！！
    //         'key_path'           => env('WECHAT_PAYMENT_KEY_PATH', 'path/to/cert/apiclient_key.pem'),      // XXX: 绝对路径！！！！
    //         'notify_url'         => 'http://example.com/payments/wechat-notify',                           // 默认支付结果通知地址
    //     ],
    //     // ...
    // ],

    /*
     * 企业微信
     */
    // 'work' => [
    //     'default' => [
    //         'corp_id' => 'xxxxxxxxxxxxxxxxx',
    //         'agent_id' => 100020,
    //         'secret'   => env('WECHAT_WORK_AGENT_CONTACTS_SECRET', ''),
    //          //...
    //      ],
    // ],
];
