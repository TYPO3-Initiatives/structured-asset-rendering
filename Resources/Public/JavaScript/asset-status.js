(function () {
  function icon(ok) {
    return ok ? '\u2705' /* WHITE HEAVY CHECK MARK */ : '\u274C' /* CROSS MARK */
  }

  const overlayEl = document.createElement('div'),
    header = document.createElement('h2'),
    status = document.createElement('section')

  overlayEl.id = 'asset-status'

  header.textContent = 'Listeners changed URI:'
  overlayEl.append(header)

  status.textContent = [
    icon(library.location === 'CDN') + ' Cdn',
    icon(library.version === '1.1') + ' LibraryVersion'
  ].join('\n')

  overlayEl.append(status)

  document.body.prepend(overlayEl)
})()
