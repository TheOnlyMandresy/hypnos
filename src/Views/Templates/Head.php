<?php

use System\Tools\TextTool;

$meta = ['jsonHead' => [
        'name' => [
            'author' => System::getSystemInfos('website'),
            'description' => TextTool::security($metaDesc, 'decode'),
            'twitter:site' => System::getSystemInfos('website'),
            'twitter:creator' => System::getSystemInfos('website')
        ],
        'property' => [
            'og:image' => TextTool::security($metaImg, 'decode'),
            'og:description' => TextTool::security($metaDesc, 'decode'),
            'og:title' => TextTool::security($title, 'decode')
        ],
        'title' => TextTool::security($title, 'decode')
    ]
];

echo json_encode($meta);