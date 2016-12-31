<?php
/**
 * Created by PhpStorm.
 * User: jane
 * Date: 12/31/16
 * Time: 20:18
 */
return [
    'custom' => [
        'email' => [
            'unique' => '邮箱已被占用',
        ],
        'password' =>
            [
                'min' => '字符数最短不能小于 :min。',
            ],
    ]
];
