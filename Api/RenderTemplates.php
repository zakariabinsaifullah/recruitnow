<?php

/**
 * Render_Templates class
 * Render Archive and Single Templates
 */

class Render_Templates {

    function __construct() {
        add_filter('archive_template', [$this, 'render_vacancies_archive_template']);
        add_filter('single_template', [$this, 'render_vacancies_single_template']);
    }

    public function render_vacancies_archive_template($archive_template) {
        if (is_post_type_archive('vacancies')) {
            wp_enqueue_style('vacancies-archive', RCN_URL . '/assets/css/vacancies-archive.css', '', RCN_VERSION, 'all');
            $archive_template = RCN_PATH . '/templates/vacancies-archive.php';
        }
        return $archive_template;
    }

    public function render_vacancies_single_template($single_template) {
        global $post;

        if ('vacancies' === $post->post_type) {
            $single_template = RCN_PATH . '/templates/vacancies-details.php';
        }

        return $single_template;
    }
}

if (class_exists('Render_Templates')) {
    new Render_Templates();
}
