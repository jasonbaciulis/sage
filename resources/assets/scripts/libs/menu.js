// On btn click toggle mega menu panels. If open then close, if closed then open.
// Also check if there are other panels open and close them/toggle their state

/**
 * @see https://codepen.io/osublake/pen/wKLmzK?editors=0110
 * @see https://greensock.com/forums/topic/13268-how-to-toggle-tweens-in-a-dry-fashion/?tab=comments#comment-55018
 **/

(function($) {
  let model = {
    init: function() {
      view.buttons.map(createAnimation);
    },
    createAnimation: function(_, element) {
      const panelId = $(element).attr("data-target");
      const targetPanel = document.querySelector(panelId);

      const tween = TweenLite.to(targetPanel, 0.5, {
        y: 200,
        autoAlpha: 1,
      }).reverse();

      // Return a function to toggle the reversed state
      return function(target) {
        let reversed;
        const dataTarget = $(target).attr("data-target");

        if (panelId !== dataTarget) {
          reversed = true;
        } else {
          reversed = !tween.reversed();
        }
        tween.reversed(reversed);
      };
    },
  };

  let controller = {
    init: function() {
      model.init();
      view.init();
      view.buttons.click(this.playAnimation);
    },

    // Create animation for each element
    playAnimation: function(event) {
      // Cycle through list of animations, toggling reversed state
      animations.each(function(_, anonymousAnimateFunction) {
        anonymousAnimateFunction(event.target);
      });
    },
  };

  let view = {
    buttons: $(".menu-button"),
  };

  controller.init();
})(jQuery);

// Hover mega menus are this simple.
// Dropdown Menu Fade
// jQuery(document).ready(function() {
//   $(".dropdown").hover(
//     // First param is handler for mouse over
//     function() {
//       $(".dropdown-menu", this).fadeIn("fast");
//     },
//     // Second pram is handler for mouse out
//     function() {
//       $(".dropdown-menu", this).fadeOut("fast");
//     }
//   );
// });
