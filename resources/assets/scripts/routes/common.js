import ResponsiveBackgroundImage from '..libs/respbgimages.js';

export default {
  init() {
    // JavaScript to be fired on all pages
    const bgImages = document.querySelectorAll('.js-responsive-bg-image');
    for (let i = 0; i < bgImages.length; i++) {
      new ResponsiveBackgroundImage(bgImages[i]);
    }
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
