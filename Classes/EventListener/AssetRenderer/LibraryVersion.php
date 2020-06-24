<?php
declare(strict_types = 1);

namespace MyVendor\AssetPostProcessing\EventListener\AssetRenderer;

use TYPO3\CMS\Core\Page\Event\BeforeJavaScriptsRenderingEvent;

/**
 * If a library has been registered (e.g. by a Fluid template), it is made sure that it is loaded from the given URI
 */
class LibraryVersion
{
    protected $libraries = [
        'library' => 'EXT:asset_post_processing/Resources/Public/JavaScript/library-1.1.js',
    ];

    public function __invoke(BeforeJavaScriptsRenderingEvent $event): void
    {
        if ($event->isInline()) {
            return;
        }

        foreach ($this->libraries as $library => $source) {
            // if it was already registered
            if ($asset = $event->getAssetCollector()->getJavaScripts($event->isPriority())[$library] ?? false) {
                // we set our authoritative version
                $event->getAssetCollector()->addJavaScript($library, $source);
            }
        }
    }
}
