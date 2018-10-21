<?php

namespace App;

add_action('after_setup_theme', function () {
    $sage = sage('blade')->compiler();

    /**
     * Create @asset() Blade directive
     */
    $sage->directive('asset', function ($asset) {
        return '<?= ' . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
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
     * Create @dumps() Blade directive
     */
    $sage->directive('dumps', function ($expression) {
        return "<?php var_dump($expression) ?>";
    });
});
