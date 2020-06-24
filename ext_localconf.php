<?php
defined('TYPO3_MODE') || die();

(static function ($_EXTKEY = 'asset_post_processing') {
    // You can actually also load assets for the backend with the AssetCollector
    if (TYPO3_MODE === 'FE') {
        $assetCollector = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Page\AssetCollector::class
        );

        // add assets by PHP or `<f:assets.*>` ViewHelpers
        $assetCollector->addJavaScript(
            'library',
            'EXT:asset_post_processing/Resources/Public/JavaScript/library-1.0.js',
            [],
            ['priority' => true]
        );
        $assetCollector->addJavaScript(
            'asset-status',
            'EXT:asset_post_processing/Resources/Public/JavaScript/asset-status.js'
        );
        $assetCollector->addStyleSheet(
            'asset-status',
            'EXT:asset_post_processing/Resources/Public/Css/asset-status.css'
        );
    }
})();
