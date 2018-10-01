<?php

namespace App;

add_action('after_setup_theme', function () {
    $sage = sage('blade')->compiler();

    /**
     * Create @posts() Blade directive
     */
    $sage->directive('posts', function ($expression) {
        return "<?php while ($expression->have_posts()) : $expression->the_post(); ?>";
    });

    /**
     * Create @endposts Blade directive
     */
    $sage->directive('endposts', function () {
        return '<?php endwhile; wp_reset_postdata(); ?>';
    });

    /**
    * Create @field() Blade directive
    */
    $sage->directive('field', function ($expression) {
        return "<?php echo get_field($expression) ?? null ?>";
    });

    /**
     * Create @option() Blade directive
     */
    $sage->directive('option', function ($expression) {
        return "<?php echo get_field($expression, 'options') ?? null ?>";
    });

    /**
     * Create @xdebug Blade directive
     */
    $sage->directive('xdebug', function () {
        return '<?php xdebug_break(); ?>';
    });

    /**
     * Create @dump() Blade directive
     */
    $sage->directive('dump', function ($expression) {
        return "<?php var_dump($expression) ?>";
    });

    /**
     * Create @icon() Blade directive
     */
    $sage->directive('icon', function ($expression, $class = null) {
        if (!empty($class)) {
            $svg = '<svg class="' . $class . '"><use xlink:href="#' . $expression . '"></svg>';
        } else {
            $svg = '<svg><use xlink:href="#' . $expression . '"></svg>';
        }
        return $svg;
    });
});
