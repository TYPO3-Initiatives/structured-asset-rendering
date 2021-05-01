<?php

declare(strict_types=1);

namespace MyVendor\AssetPostProcessing\EventListener\AssetRenderer;

use MyVendor\AssetPostProcessing\AbstractAssetsProvider;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Page\Event\AbstractBeforeAssetRenderingEvent;
use TYPO3\CMS\Core\Page\Event\BeforeJavaScriptsRenderingEvent;
use TYPO3\CMS\Core\Page\Event\BeforeStylesheetsRenderingEvent;

/**
 * This loads assets via the AssetRenderer events infrastructure.
 * This is not meant as a best practice example but rather as a playing ground for possible solutions.
 */
class InjectAssets
{
    public function __invoke(AbstractBeforeAssetRenderingEvent $event): void
    {
        if (is_a($event, BeforeStylesheetsRenderingEvent::class)) {
            $this->addStyles($event);
        } elseif (is_a($event, BeforeJavaScriptsRenderingEvent::class)) {
            $this->addScripts($event);
        }
    }

    protected function addScripts(AbstractBeforeAssetRenderingEvent $event): void
    {
        if ($this->isFrontend()) {
            // load non-inline, non-priority scripts
            if (!$event->isInline() && !$event->isPriority()) {
                $event->getAssetCollector()->addJavaScript(
                    'asset-status',
                    'EXT:asset_post_processing/Resources/Public/JavaScript/asset-status.js'
                );
            }
            // load non-inline, priority scripts
            if (!$event->isInline() && $event->isPriority()) {
                $event->getAssetCollector()->addJavaScript(
                    'library',
                    'EXT:asset_post_processing/Resources/Public/JavaScript/library-1.0.js',
                    [],
                    ['priority' => true]
                );
            }
        }
    }

    protected function addStyles(AbstractBeforeAssetRenderingEvent $event): void
    {
        if ($this->isFrontend()) {
            // load non-inline, non-priority styles
            if (!$event->isInline() && !$event->isPriority()) {
                $event->getAssetCollector()->addStyleSheet(
                    'asset-status',
                    'EXT:asset_post_processing/Resources/Public/Css/asset-status.css'
                );
            }
        }
    }

    protected function isFrontend(): bool
    {
        return ($GLOBALS['TYPO3_REQUEST'] ?? null) instanceof ServerRequestInterface
            && ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isFrontend();
    }
}
