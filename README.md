# Example TYPO3 Extension
### AssetRenderer events

This is meant as a kickstarter to test [https://review.typo3.org/c/Packages/TYPO3.CMS/+/64021][review] during review and to serve as an example for handling AssetCollector/AssetRenderer events later.

If you want to have a quick look around, you can start it with [DDEV-Local](https://ddev.readthedocs.io/):

    ddev launch

You can also download it or install via composer into your test installation:

    composer config repositories.asset-post-processing vcs https://github.com/TYPO3-Initiatives/structured-asset-rendering.git
    composer config minimum-stability dev
    composer req typo3-structured-content/asset-post-processing:dev-master

No further configuration needed.

After installing it registers some assets (in `ext_localconf.php`). You can also register assets in Fluid with `<f:asset.css>` and `<f:asset.js>`.

It registers some EventListeners in `Services.yaml`. They get called before assets are being rendered.

It reports in the frontend which listeners were executed. Play around with the code and see how it affects assets the listeners and the JS/CSS output.

[review]: https://review.typo3.org/c/Packages/TYPO3.CMS/+/64021
