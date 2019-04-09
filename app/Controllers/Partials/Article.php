<?php
namespace App\Controllers\Partials;

trait Article
{
    /**
     * Returns the Post Type of current query
     * @return string
     */
    public function postType(): string
    {
        $queried_object = get_queried_object();

        if ($queried_object instanceof \WP_Term) {
            $taxonomy = get_taxonomy($queried_object->taxonomy);
            $post_type = head($taxonomy->object_type);
        } else {
            $post_type = !empty($queried_object->name) ? $queried_object->name : get_post_type();
        }

        return $post_type;
    }

    /**
     * Returns the Post Type Category taxonomy of current query
     * @return string
     */
    public function postTypeCategoryTaxonomy(): string
    {
        $post_type = $this->postType();
        $taxonomy = '';

        if (! empty($post_type)) {
            $taxonomy = 'post' === $post_type ? 'category' : "{$post_type}_category";
        }

        return $taxonomy;
    }

    public function relatedArticles()
    {
        return array_map(function ($post) {
            $post->time_ago = human_time_diff(get_the_time('U'), current_time('timestamp'));
            $post->term_name = yoast_get_primary_term($this->postTypeCategoryTaxonomy(), $post->ID);
            return $post;
        }, get_posts([
            'post_type' => $this->postType(),
        ]));
    }
}
