<?php

return [
    'base_url'  => 'https://petstore.swagger.io/v2',
    'endpoints' => [
        'pet' => [
            'get'    => [
                'findByStatus' => '/pet/findByStatus',
                'findById'     => '/pet/%s',
            ],
            'post'   => [
                'new'          => '/pet',
                'update'       => '/pet',
                'upload_image' => '/pet/%s/uploadImage',
            ],
            'put'    => [
                'update' => '/pet',
            ],
            'delete' => '/pet/%s',
        ],
    ]
];
