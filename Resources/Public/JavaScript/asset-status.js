(() => {
    const icon = (ok) => {
        return ok ? '\u2705' /* WHITE HEAVY CHECK MARK */ : '\u274C' /* CROSS MARK */
    }

    const overlayEl = document.createElement('div'),
        header = document.createElement('h2'),
        intro = document.createElement('p'),
        status = document.createElement('section')

    overlayEl.id = 'asset-status'

    header.textContent = 'AssetPostProcessing'
    overlayEl.append(header)

    intro.textContent = 'These AssetRenderer events have altered included assets:'
    overlayEl.append(intro)

    status.innerHTML = 
        icon(library.location === 'CDN') + ' Cdn<br>'
         + icon(library.version === '1.1') + ' LibraryVersion'
    
    overlayEl.append(status)

    document.body.prepend(overlayEl)
})()
