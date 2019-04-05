<?php

namespace App;

function nav_adjacent()
{
    $ancestors = get_post_ancestors(get_the_ID());
    $parent_id = $ancestors ? $ancestors[0] : null;

    if (!$parent_id) {
        return;
    }

    $pages = get_pages([
        'parent'      => $parent_id,
        'sort_column' => 'menu_order',
        'sort_order'  => 'ASC',
    ]);

    $page_ids  = [];

    foreach ($pages as $page) {
        $page_ids[] += $page->ID;
    }

    $last_index         = count($pages) - 1;
    $current_page_index = array_search(get_the_ID(), $page_ids);
    $prev_page_index    = $current_page_index !== 0 ? $current_page_index - 1 : null;
    $next_page_index    = $current_page_index !== $last_index ? $current_page_index + 1 : null;

    return (object) [
        'prev_id'  => $prev_page_index ? $page_ids[$prev_page_index] : null,
        'next_id'  => $next_page_index ? $page_ids[$next_page_index] : null,
    ];
}

function pagination($mid_size = 4)
{
    return paginate_links([
        'mid_size'           => $mid_size,
        'prev_text'          => '<span class="fas fa-chevron-left"></span><span class="c-pagination__prev-text">Previous</span>',
        'next_text'          => '<span class="c-pagination__next-text">Next</span><span class="fas fa-chevron-right"></span>',
        'before_page_number' => '<span class="sr-only">Page</span>',
        'type'               => 'array',
    ]);
}
