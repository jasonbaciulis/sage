<style>
  .menu {
    position: absolute;
    opacity: 0;
    pointer-events: none;
    transform-origin: top left;
    overflow: hidden;
    contain: content;
    border-radius: 3px;
    box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
    background: #FFF;
    will-change: transform;
    animation-duration: 200ms;
    animation-timing-function: step-end;
  }
  .menu__contents {
    transform-origin: top left;
    will-change: transform;
    contain: content;
    animation-duration: 200ms;
    animation-timing-function: step-end;
  }
  .menu__toggle {
    text-align: left;
    padding: 0;
    margin: 0;
    border: none;
    background: none;
    cursor: pointer;
    width: 100%;
  }
  .menu__title {
    padding: 0;
    margin: 0;
    font-weight: 500;
    display: inline-block;
    padding: 8px 12px;
  }
  .menu__items {
    position: relative;
    list-style: none;
    padding: 0;
    margin: 0;
    background: #FFF;
    z-index: 1;
  }
  .menu__item {
    padding: 8px 12px;
    border-top: 1px solid #DDD;
  }
  .menu--active {
    opacity: 1;
    pointer-events: auto;
  }
  .menu--expanded {
    animation-name: menuExpandAnimation;
  }
  .menu__contents--expanded {
    animation-name: menuExpandContentsAnimation;
  }
  .menu--collapsed {
    animation-name: menuCollapseAnimation;
  }
  .menu__contents--collapsed {
    animation-name: menuCollapseContentsAnimation;
  }
</style>

<nav class="menu js-menu">
  <div class="menu__contents js-menu-contents">
    <button class="menu__toggle js-menu-toggle">
      <h1 class="menu__title js-menu-title">Menu</h1>
    </button>
    <ul class="menu__items">
      <li class="menu__item">Menu item 1</li>
      <li class="menu__item">Menu item 2</li>
      <li class="menu__item">Menu item 3</li>
      <li class="menu__item">Menu item 4</li>
    </ul>
  </div>
</nav>
