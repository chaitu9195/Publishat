/**
 * Global broken-image fallback.
 *
 * Any <img> that fails to load (missing file, missing thumbnail, missing
 * file-type icon, unreachable viewfile, etc.) is swapped to a placeholder
 * image so the UI never shows a broken-image glyph.
 *
 * Uses the capture phase on document because image "error" events do NOT
 * bubble, and this also covers images added later (AJAX-loaded content).
 *
 * The placeholder URL is taken from window.__IMG_FALLBACK__ (set per-page with
 * the correct base_url) and falls back to a relative path if unset.
 */
(function () {
  function placeholder() {
    return window.__IMG_FALLBACK__ || 'images/no-image.png';
  }

  function swap(img) {
    if (!img || img.tagName !== 'IMG') {
      return;
    }
    // Prevent an infinite loop if the placeholder itself is missing.
    if (img.getAttribute('data-img-fallback') === '1') {
      return;
    }
    var ph = placeholder();
    // Don't replace the placeholder with itself.
    if (img.src && img.src.indexOf(ph) !== -1) {
      return;
    }
    img.setAttribute('data-img-fallback', '1');
    img.src = ph;
  }

  // Catch load errors for current and future images (capture phase).
  document.addEventListener(
    'error',
    function (e) {
      swap(e.target);
    },
    true,
  );

  // Catch images that already failed before this script ran.
  function sweep() {
    var imgs = document.getElementsByTagName('img');
    for (var i = 0; i < imgs.length; i++) {
      var im = imgs[i];
      if (im.complete && im.naturalWidth === 0 && im.getAttribute('src')) {
        swap(im);
      }
    }
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', sweep);
  } else {
    sweep();
  }
})();
