"use strict";

/* global opts */

class Menu {
  constructor({
    menuSelector = "",
    menuContentsSelector = "",
    menuToggleButtonSelector = "",
    menuHeaderSelector = "",
  } = {}) {
    this._menu = document.querySelector(menuSelector);
    this._menuContents = this._menu.querySelector(menuContentsSelector);
    this._menuToggleButton = this._menu.querySelector(menuToggleButtonSelector);
    this._menuHeader = this._menu.querySelector(menuHeaderSelector);

    this._expanded = true;
    this._animate = false;
    this._duration = 200;
    this._frameTime = 1000 / 60;
    this._nFrames = Math.round(this._duration / this._frameTime);
    this._collapsed;

    this.expand = this.expand.bind(this);
    this.collapse = this.collapse.bind(this);
    this.toggle = this.toggle.bind(this);

    this._calculateScales();
    this._createEaseAnimations();
    this._addEventListeners();

    this.collapse();
    this.activate();
  }

  activate() {
    this._menu.classList.add("menu--active");
    this._animate = true;
  }

  collapse() {
    if (!this._expanded) {
      return;
    }
    this._expanded = false;

    const { x, y } = this._collapsed;
    const invX = 1 / x;
    const invY = 1 / y;

    this._menu.style.transform = `scale(${x}, ${y})`;
    this._menuContents.style.transform = `scale(${invX}, ${invY})`;

    if (!this._animate) {
      return;
    }

    this._applyAnimation({ expand: false });
  }

  expand() {
    if (this._expanded) {
      return;
    }
    this._expanded = true;

    this._menu.style.transform = `scale(1, 1)`;
    this._menuContents.style.transform = `scale(1, 1)`;

    if (!this._animate) {
      return;
    }

    this._applyAnimation({ expand: true });
  }

  toggle() {
    if (this._expanded) {
      this.collapse();
      return;
    }

    this.expand();
  }

  _addEventListeners() {
    this._menuToggleButton.addEventListener("click", this.toggle);
  }

  _applyAnimation({ expand } = opts) {
    this._menu.classList.remove("menu--expanded");
    this._menu.classList.remove("menu--collapsed");
    this._menuContents.classList.remove("menu__contents--expanded");
    this._menuContents.classList.remove("menu__contents--collapsed");

    // Force a recalc styles here so the classes take hold.
    window.getComputedStyle(this._menu).transform;

    if (expand) {
      this._menu.classList.add("menu--expanded");
      this._menuContents.classList.add("menu__contents--expanded");
      return;
    }

    this._menu.classList.add("menu--collapsed");
    this._menuContents.classList.add("menu__contents--collapsed");
  }

  _calculateScales() {
    const collapsed = this._menuHeader.getBoundingClientRect();
    const expanded = this._menu.getBoundingClientRect();

    this._collapsed = {
      x: collapsed.width / expanded.width,
      y: collapsed.height / expanded.height,
    };
  }

  _createEaseAnimations() {
    let menuEase = document.querySelector(".menu-ease");
    if (menuEase) {
      return menuEase;
    }

    menuEase = document.createElement("style");
    menuEase.classList.add("menu-ease");

    const menuExpandAnimation = [];
    const menuExpandContentsAnimation = [];
    const menuCollapseAnimation = [];
    const menuCollapseContentsAnimation = [];

    const percentIncrement = 100 / this._nFrames;

    for (let i = 0; i <= this._nFrames; i++) {
      const step = this._ease(i / this._nFrames).toFixed(5);
      const percentage = (i * percentIncrement).toFixed(5);
      const startX = this._collapsed.x;
      const startY = this._collapsed.y;
      const endX = 1;
      const endY = 1;

      // Expand animation.
      this._append({
        percentage,
        step,
        startX,
        startY,
        endX,
        endY,
        outerAnimation: menuExpandAnimation,
        innerAnimation: menuExpandContentsAnimation,
      });

      // Collapse animation.
      this._append({
        percentage,
        step,
        startX: 1,
        startY: 1,
        endX: this._collapsed.x,
        endY: this._collapsed.y,
        outerAnimation: menuCollapseAnimation,
        innerAnimation: menuCollapseContentsAnimation,
      });
    }

    menuEase.textContent = `
    @keyframes menuExpandAnimation {
      ${menuExpandAnimation.join("")}
    }
    @keyframes menuExpandContentsAnimation {
      ${menuExpandContentsAnimation.join("")}
    }
    @keyframes menuCollapseAnimation {
      ${menuCollapseAnimation.join("")}
    }
    @keyframes menuCollapseContentsAnimation {
      ${menuCollapseContentsAnimation.join("")}
    }`;

    document.head.appendChild(menuEase);
    return menuEase;
  }

  _append({
    percentage,
    step,
    startX,
    startY,
    endX,
    endY,
    outerAnimation,
    innerAnimation,
  } = opts) {
    const xScale = (startX + (endX - startX) * step).toFixed(5);
    const yScale = (startY + (endY - startY) * step).toFixed(5);

    const invScaleX = (1 / xScale).toFixed(5);
    const invScaleY = (1 / yScale).toFixed(5);

    outerAnimation.push(`
      ${percentage}% {
        transform: scale(${xScale}, ${yScale});
      }`);

    innerAnimation.push(`
      ${percentage}% {
        transform: scale(${invScaleX}, ${invScaleY});
      }`);
  }

  _clamp(value, min, max) {
    return Math.max(min, Math.min(max, value));
  }

  _ease(v, pow = 4) {
    v = this._clamp(v, 0, 1);

    return 1 - Math.pow(1 - v, pow);
  }
}

new Menu({
  menuSelector: ".js-menu",
  menuContentsSelector: ".js-menu-contents",
  menuToggleButtonSelector: ".js-menu-toggle",
  menuHeaderSelector: ".js-menu-title",
});
