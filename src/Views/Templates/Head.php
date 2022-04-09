<?php

$meta = ['jsonHead' => [
        'name' => [
            'author' => System::getSystemInfos('website'),
            'description' => $metaDesc,
            'twitter:site' => System::getSystemInfos('website'),
            'twitter:creator' => System::getSystemInfos('website')
        ],
        'property' => [
            'og:image' => $metaImg,
            'og:description' => $metaDesc,
            'og:title' => $title
        ],
        'title' => $title
    ]
];

echo json_encode($meta);