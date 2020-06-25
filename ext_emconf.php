<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'asset_rendering',
    'description' => 'Example for using AssetRenderer events',
    'author' => 'Jonas Eberle',
    'author_email' => '',
    'author_company' => '',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'MyVendor\\AssetPostProcessing\\' => 'Classes',
        ],
    ],
];
