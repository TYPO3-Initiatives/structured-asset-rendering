<?php
declare(strict_types = 1);

namespace MyVendor\AssetPostProcessing\EventListener\AssetRenderer;

use TYPO3\CMS\Core\Page\AssetCollector;
use TYPO3\CMS\Core\Page\Event\AbstractBeforeAssetRenderingEvent;
use TYPO3\CMS\Core\Page\Event\BeforeJavaScriptsRenderingEvent;
use TYPO3\CMS\Core\Page\Event\BeforeStylesheetsRenderingEvent;

class Cdn
{
    /**
     * @var AssetCollector
     */
    protected $assetCollector;

    /**
     * @var BeforeStylesheetsRenderingEvent
     */
    protected $event;

    /**
     * @var array
     */
    protected $rewrite = [
        'EXT:asset_post_processing/Resources/Public/JavaScript/library-'
        => 'EXT:asset_post_processing/Resources/LetsPretendIAmTheCdn/JavaScript/library-'
    ];

    /**
     * Rewrites paths or parts of paths in asset URIs.
     */
    public function __invoke(AbstractBeforeAssetRenderingEvent $event): void
    {
        if ($event->isInline()) {
            return;
        }

        $this->assetCollector = $event->getAssetCollector();
        $this->event = $event;

        if (is_a($event, BeforeStylesheetsRenderingEvent::class)) {
            $this->rewriteStylesheets();
        } elseif (is_a($event, BeforeJavaScriptsRenderingEvent::class)) {
            $this->rewriteJavaScripts();
        }
    }

    protected function rewriteJavaScripts(): void
    {
        // make sure we only work on files of the current rendering pass
        $assets = $this->assetCollector->getJavaScripts($this->event->isPriority());
        foreach ($assets as $identifier => $asset) {
            $this->assetCollector->addJavaScript($identifier, $this->mapUri($asset['source']));
        }
    }

    protected function rewriteStylesheets(): void
    {
        $assets = $this->assetCollector->getStyleSheets($this->event->isPriority());
        foreach ($assets as $identifier => $asset) {
            $this->assetCollector->addStyleSheet($identifier, $this->mapUri($asset['source']));
        }
    }

    protected function mapUri(string $uri): string
    {
        return strtr($uri, $this->rewrite);
    }
}
