<?php
/**
 * Plugin Name: Extended Custom Post Types
 * Plugin URI: https://github.com/johnbillion/extended-cpts
 * Description: Extended CPTs is a library which provides extended functionality to WordPress custom post types and taxonomies. This allows developers to quickly build post types and taxonomies without having to write the same code again and again. This plugin creates CPTs and taxonomies for this theme.
 */

add_action('init', function () {
    register_extended_post_type('news', [
        'menu_icon' => 'dashicons-admin-post',
        'enter_title_here' => 'News title',
        'supports' => [
            'title',
            'excerpt',
            'editor',
            'revisions',
            'page-attributes',
            'thumbnail',
        ],
        // 'show_in_menu' => 'edit.php',
        'has_archive' => false,
        'taxonomies' => ['post_tag'],
        'featured_image' => 'Featured Image at least 690x690px',
        'admin_cols' => [
            'publish_date' => [
                'title'      => 'Date Published',
                'post_field' => 'post_date',
                'default'    => 'DESC',
            ],
            'area' => [
                'title'    => 'Area',
                'taxonomy' => 'area',
            ],
            'country' => [
                'title'    => 'Country',
                'taxonomy' => 'country',
            ],
            'city' => [
                'title'    => 'City',
                'taxonomy' => 'city',
            ],
        ],
    ], [
        'singular' => 'News',
        'plural' => 'News',
        'slug' => 'news'
    ]);

    register_extended_post_type('quote', [
        'menu_icon' => 'dashicons-format-quote',
        'enter_title_here' => 'Quote title',
        // 'show_in_menu' => 'edit.php',
        'has_archive' => false,
        'admin_cols' => [
            'quote-author' => [
                'title'    => 'Quote author',
                'taxonomy' => 'quote-author',
            ],
        ],
    ], [
        'singular' => 'Quote',
        'plural' => 'Quotes',
        'slug' => 'quote'
    ]);

    register_extended_post_type('ministry-story', [
        'menu_icon' => 'dashicons-book',
        'enter_title_here' => 'Story\'s title',
        'supports' => [
            'title',
            'excerpt',
            'editor',
            'revisions',
            'page-attributes',
            'thumbnail',
        ],
        // 'show_in_menu' => 'edit.php',
        'taxonomies' => ['post_tag'],
        'has_archive' => false,
        'rewrite' => [
            'permastruct' => '/who-we-are/our-mission/ministry-stories/%postname%',
        ],
        'featured_image' => 'Featured Image at least 690x690px',
        'admin_cols' => [
            'area' => [
                'title'    => 'Area',
                'taxonomy' => 'area',
            ],
            'country' => [
                'title'    => 'Country',
                'taxonomy' => 'country',
            ],
            'city' => [
                'title'    => 'City',
                'taxonomy' => 'city',
            ],
        ],
    ], [
        'singular' => 'Ministry story',
        'plural' => 'Ministry stories',
        'slug' => 'ministry-stories'
    ]);

    register_extended_post_type('vocation-story', [
        'menu_icon' => 'dashicons-pressthis',
        'enter_title_here' => 'Story\'s title',
        'supports' => [
            'title',
            'excerpt',
            'editor',
            'revisions',
            'page-attributes',
            'thumbnail',
        ],
        // 'show_in_menu' => 'edit.php',
        'taxonomies' => ['post_tag'],
        'has_archive' => false,
        'rewrite' => [
            'permastruct' => '/vocation/vocation-stories/%postname%',
        ],
        'featured_image' => 'Featured Image at least 690x690px',
        'admin_cols' => [
            'area' => [
                'title'    => 'Area',
                'taxonomy' => 'area',
            ],
            'country' => [
                'title'    => 'Country',
                'taxonomy' => 'country',
            ],
            'city' => [
                'title'    => 'City',
                'taxonomy' => 'city',
            ],
        ],
    ], [
        'singular' => 'Vocation story',
        'plural' => 'Vocation stories',
        'slug' => 'vocation-stories'
    ]);

    register_extended_post_type('ongoing-story', [
        'menu_icon' => 'dashicons-book-alt',
        'enter_title_here' => 'Story\'s title',
        // 'show_in_menu' => 'edit.php',
        'has_archive' => false,
        'admin_cols' => [
            'publish_date' => [
                'title'      => 'Date Published',
                'post_field' => 'post_date',
                'default'    => 'ASC',
            ],
        ],
    ], [
        'singular' => 'Ongoing story',
        'plural' => 'Ongoing stories',
        'slug' => 'ongoing-story'
    ]);

    register_extended_post_type('event', [
        'menu_icon' => 'dashicons-megaphone',
        'enter_title_here' => 'Event\'s title',
        'supports' => [
            'title',
            'excerpt',
            'editor',
            'revisions',
            'page-attributes',
            'thumbnail',
        ],
        // 'show_in_menu' => 'edit.php',
        'has_archive' => false,
        'rewrite' => [
            'permastruct' => '/who-we-are/our-mission/events/%postname%',
        ],
        'featured_image' => 'Featured Image at least 690x690px',
        'admin_cols' => [
            'start_date' => [
                'title'       => 'Start Date',
                'meta_key'    => 'event_start_date',
                'date_format' => 'd M Y',
                'default'     => 'ASC',
            ],
            'area' => [
                'title'    => 'Area',
                'taxonomy' => 'area',
            ],
            'country' => [
                'title'    => 'Country',
                'taxonomy' => 'country',
            ],
            'city' => [
                'title'    => 'City',
                'taxonomy' => 'city',
            ],
        ],
    ], [
        'singular' => 'Event',
        'plural' => 'Events',
        'slug' => 'events'
    ]);

    register_extended_post_type('school-institution', [
        'menu_icon' => 'dashicons-welcome-learn-more',
        'enter_title_here' => 'School\'s or institution\'s name',
        // 'show_in_menu' => 'edit.php',
        'has_archive' => false,
        'featured_image' => 'Featured Image at least 526x526px',
        'admin_cols' => [
            'area' => [
                'title'    => 'Area',
                'taxonomy' => 'area',
            ],
            'country' => [
                'title'    => 'Country',
                'taxonomy' => 'country',
            ],
            'city' => [
                'title'    => 'City',
                'taxonomy' => 'city',
            ],
            'institution-type' => [
                'title'    => 'Type',
                'taxonomy' => 'institution-type',
            ],
        ],
    ], [
        'singular' => 'School & Institution',
        'plural' => 'Schools & Institutions',
        'slug' => 'schools-institutions'
    ]);

    register_extended_post_type('resource', [
        'menu_icon' => 'dashicons-portfolio',
        'enter_title_here' => 'Resource\'s title',
        // 'show_in_menu' => 'edit.php',
        'has_archive' => false,
        'featured_image' => 'Featured Image at least 510x510px',
        'admin_cols' => [
            'resource_format' => [
                'title'       => 'Format',
                'meta_key'    => 'resource_format',
            ],
            'area' => [
                'title'    => 'Area',
                'taxonomy' => 'area',

            ],
            'resource_category' => [
                'title'    => 'Category',
                'taxonomy' => 'resource-category',
            ],
            'publish_date' => [
                'title'      => 'Date Published',
                'post_field' => 'post_date',
                'default'    => 'DESC',
            ],
        ],
    ], [
        'singular' => 'Resource',
        'plural' => 'Resources',
        'slug' => 'resources'
    ]);
});


/**
 *  Taxonomies
 */
add_action('init', function () {
    register_extended_taxonomy('area', ['news', 'fcjs', 'ministry-story', 'vocation-story', 'event', 'school-institution', 'resource'], [], [
        'singular' => 'Area',
        'plural' => 'Areas',
        'slug' => 'area'
    ]);

    register_extended_taxonomy('quote-author', 'quote', [
        'meta_box' => 'radio'
    ], [
        'singular' => 'Quote author',
        'plural' => 'Quote authors',
        'slug' => 'quote-author'
    ]);
});
