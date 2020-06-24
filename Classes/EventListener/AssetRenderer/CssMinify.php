<?php
declare(strict_types = 1);

namespace MyVendor\AssetPostProcessing\EventListener\AssetRenderer;

use TYPO3\CMS\Core\Page\AssetCollector;
use TYPO3\CMS\Core\Page\Event\BeforeStylesheetsRenderingEvent;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CssMinify
{
    /**
     * @var AssetCollector
     */
    protected $assetCollector;

    /**
     * Manipulates CSS. If not inline, it copies the file to ./typo3temp/assets/css/.
     */
    public function __invoke(BeforeStylesheetsRenderingEvent $event): void
    {
        $this->assetCollector = $event->getAssetCollector();

        if ($event->isInline()) {
            $assets = $this->assetCollector->getInlineStyleSheets($event->isPriority());
            foreach ($assets as $identifier => $asset) {
                // for inline assets, source is the actual content of the tag
                $asset['source'] = $this->minify($asset['source']);
                $this->assetCollector->addStyleSheet($identifier, $asset['source']);
            }
        } else {
            $assets = $this->assetCollector->getStyleSheets($event->isPriority());
            foreach ($assets as $identifier => $asset) {
                // only work on local files
                $filename = GeneralUtility::getFileAbsFileName($asset['source']);
                if ($filename === '') {
                    continue;
                }
                $css = file_get_contents($filename);
                $css = $this->minify($css);
                $asset['source'] = GeneralUtility::writeStyleSheetContentToTemporaryFile($css);
                $this->assetCollector->addStyleSheet($identifier, $asset['source']);
            }
        }
    }

    protected function minify(string $css): string
    {
        // we do not actually minify... We just change our status message:
        $appendCss = '
            /* From CssMinify */
            #asset-status section::after {
                content: "\2705  CssMinify"; /* WHITE HEAVY CHECK MARK */
            }
        ';
        return $css . $appendCss;
    }
}
