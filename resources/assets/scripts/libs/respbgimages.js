/**
 * @see https://roots.io/guides/responsive-background-images-using-blade-components/
 */

// Searches for inner img and grabs src to apply as background-image
export default class ResponsiveBackgroundImage {
  constructor(element) {
    this.element = element;
    this.img = element.querySelector('img');
    this.src = '';

    this.img.addEventListener('load', () => {
      this.update();
    });

    if (this.img.complete) {
      this.update();
    }
  }

  update() {
    let src =
      typeof this.img.currentSrc !== 'undefined' ? this.img.currentSrc : this.img.src;
    if (this.src !== src) {
      this.src = src;
      this.element.style.backgroundImage = 'url("' + this.src + '")';
      // Add class to remove blur filter or make other reveal animation
      // this.element.classList.add('u-bg-image-loaded');
    }
  }
}
