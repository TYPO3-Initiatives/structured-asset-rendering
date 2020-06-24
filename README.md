# Example TYPO3 Extension
### AssetRenderer events

This is meant as a kickstarter to test [https://review.typo3.org/c/Packages/TYPO3.CMS/+/64021][review] during review and to serve as an example later.

You can download it or `composer req jonaseberle/asset-post-processing:dev-master`. No further configuration needed.

After installing it registers some assets (in `ext_localconf.php`). You can also register assets in Fluid with `<f:asset.css>` and `<f:asset.js>`.

It registers some EventListeners in `Services.yaml`. They get called before assets are being rendered.

It reports in the frontend which listeners were executed. Play around with the code and see how it affects assets the listeners and the JS/CSS output.

### Note
In non-composer install, flushing caches via "Maintenance" » "Flush TYPO3 and PHP Cache" is required when changing `Services.yaml`.

[review]: https://review.typo3.org/c/Packages/TYPO3.CMS/+/64021
