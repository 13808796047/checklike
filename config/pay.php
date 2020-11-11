<?php

return [
    'alipay' => [
        'app_id' => env('PAY_ALIYUN_APP_ID'),
        'ali_public_key' => env('PAY_ALIYUN_PUBLIC_KEY'),
        'private_key' => env('PAY_ALIYUN_PRIVATE_KEY'),
//        'log' => [
//            'file' => storage_path('logs/alipay.log'),
//        ],
    ],

    'wechat' => [
        'app_id' => env('WECHAT_APP_ID'),
        'mch_id' => env('WECHAT_MCH_ID'),
        'key' => env('WECHAT_KEY'),
        'cert_client' => '',
        'cert_key' => '',
//        'log' => [
//            'file' => storage_path('logs/wechat_pay.log'),
//        ],
    ],
    'baidu_pay' => [
        'app_id' => env('BAIDU_APP_ID'),
        'rsaPubKeyStr' => env('BAIDU_PUBLIC_KEY'),
        'reaPriKeyStr' => '-----BEGIN RSA PRIVATE KEY-----
          MIICWwIBAAKBgQCGgALBxBbJ6+gU9+zqkkTm37M13rG56wqh5NsPFCbxKPYYuPbPIsXzGisVYNHfPFwMaTOaEgsXfSQspF9B5SyBny4Nq1Jv99bOiDhC1qQrMcymzkQ892RzkxrStIB8l1z4ktKUhnOBVzUEoK9Gxly28c+n4Wmp2QiEJ0dGMReDtQIDAQABAoGACU0I48Vfng8GOYz7gS0kPqLxjaQcvjKWxaNB0sUd/EdM3WDNEH3jGnCQ0iWj3cAazXDo9JqS0ckBm2SygagLb8GOCJn6na2aarDMyjpl12IVZMkliIGLb7Gbg1dwevYTaghJbHHJcdkZijf108nqm27VZdhOa3ryHFu7G1brW3ECQQDGMSfY5AM15Mfmb8wuUHVESmIaIPXCyckbebmZHuxlJFYlF3CmYmBksCektLLhcizxthM6CEB5+HUXpmdro94nAkEArbsGW6Bg/vI8OeA+N1lCPwhR5CJH73eS6N/btUMmiKAc6OdigfcqSyAg6P8cYbsDer5CT+xh1n/xW5PRU2vUwwJAL7YrspIJl9LQsM/fJpMl99+0SDgBEfiD2oJuRMdl/19FAb7n1pY+QF8L3CHIIm/bFAFSFZlg9Dv07FGZ+hbD5wJAfmbcKmBXEkem4Ckyu0ybMYdZJdZ3Zlkmr37ouUqBR9jPD/oCJzNxNzXKHBw5RzYtQuoZD1Oan9l4/zteiwaixwJAOONDiJnYz8v9C09GXLW4K3RV/tbZARN2ZDgxksTHiqNqAl1xh2lag7g68d7KRO2BgX/1naqsfPRbWhCMovo6ZA==
        -----END RSA PRIVATE KEY-----',
        'appKey' => env('BAIDU_APP_KEY'),
        'dealId' => env('BAIDU_DEALID')
    ]
];
