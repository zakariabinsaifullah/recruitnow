<?php

/**
 * Render_Templates class
 * Render Archive and Single Templates
 */

class Render_Templates {
    function __construct() {
        add_filter('archive_template', [$this, 'get_vacancies_archive_template']);
        add_filter('single_template', [$this, 'get_vacancies_single_template']);
    }

    public function get_vacancies_archive_template($archive_template) {
        if (is_post_type_archive('vacancies')) {
            $archive_template = RCN_PATH . '/templates/vacancies-archive.php';
        }
        return $archive_template;
    }

    public function get_vacancies_single_template($single_template) {
        global $post;

        if ('vacancies' === $post->post_type) {
            $single_template = dirname(__FILE__) . '/templates/vacancies-details.php';
        }

        return $single_template;
    }
}

if (class_exists('Render_Templates')) {
    new Render_Templates();
}
