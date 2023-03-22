<?php
/* Template Name: Custom Archive Template */
get_header();
?>
<main id="main" class="content-wrapper">

    <?php
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $posts_query = new WP_Query(
        array(
            'post_type' => 'vacancies',
            'post_status' => 'publish',
            // 'posts_per_page' => 1,
            'paged' => $paged
        )
    );

    ?>
    <div class="posts-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    Left Filter Bar
                </div>
                <div class="col-md-9">
                    <?php if ($posts_query->have_posts()) { ?>
                        <?php while ($posts_query->have_posts()) {
                            $posts_query->the_post();
                            $post_id = get_the_ID();
                        ?>
                            <article class="card mb-3 p-4">
                                <a href="<?php the_permalink(); ?>" class="main-wrapper text-normal row p-4">

                                    <div class="content col-md-8">

                                        <h2 class="h5"><?php the_title(); ?></h2>

                                        <span class="badge badge-secondary">Uitzenden</span>
                                        <?php
                                        $regions = get_post_meta($post_id, 'recruit_now_regions', true);
                                        if (!empty($regions)) :
                                        ?>
                                            <span class="small text-muted">
                                                <span class="mx-2">|</span>
                                                <span class="archive-icon-wrap">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                        <path d="M57.7 193l9.4 16.4c8.3 14.5 21.9 25.2 38 29.8L163 255.7c17.2 4.9 29 20.6 29 38.5v39.9c0 11 6.2 21 16 25.9s16 14.9 16 25.9v39c0 15.6 14.9 26.9 29.9 22.6c16.1-4.6 28.6-17.5 32.7-33.8l2.8-11.2c4.2-16.9 15.2-31.4 30.3-40l8.1-4.6c15-8.5 24.2-24.5 24.2-41.7v-8.3c0-12.7-5.1-24.9-14.1-33.9l-3.9-3.9c-9-9-21.2-14.1-33.9-14.1H257c-11.1 0-22.1-2.9-31.8-8.4l-34.5-19.7c-4.3-2.5-7.6-6.5-9.2-11.2c-3.2-9.6 1.1-20 10.2-24.5l5.9-3c6.6-3.3 14.3-3.9 21.3-1.5l23.2 7.7c8.2 2.7 17.2-.4 21.9-7.5c4.7-7 4.2-16.3-1.2-22.8l-13.6-16.3c-10-12-9.9-29.5 .3-41.3l15.7-18.3c8.8-10.3 10.2-25 3.5-36.7l-2.4-4.2c-3.5-.2-6.9-.3-10.4-.3C163.1 48 84.4 108.9 57.7 193zM464 256c0-36.8-9.6-71.4-26.4-101.5L412 164.8c-15.7 6.3-23.8 23.8-18.5 39.8l16.9 50.7c3.5 10.4 12 18.3 22.6 20.9l29.1 7.3c1.2-9 1.8-18.2 1.8-27.5zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
                                                    </svg>
                                                </span>
                                            <?php
                                            foreach ($regions as $region) :
                                                echo '<span>' . $region['Name'] . '</span>';
                                            endforeach;
                                        endif;
                                            ?>
                                            </span>

                                    </div>

                                    <div class="cta col-md-4 d-flex align-items-center">
                                        <div class="btn btn-sm btn-outline-primary ml-auto"> <?php _e('Apply Now', 'textdomain'); ?></div>
                                    </div>

                                </a>
                            </article>
                        <?php } ?>
                        <?php
                        $total_pages = $posts_query->max_num_pages;
                        if ($total_pages > 1) {
                            $current_page = max(1, get_query_var('paged')); ?>
                            <div class="pagination">
                                <?php echo paginate_links(array(
                                    'base' => get_pagenum_link(1) . '%_%',
                                    'format' => 'page/%#%',
                                    'current' => $current_page,
                                    'total' => $total_pages
                                )); ?>
                            </div>
                        <?php }

                        wp_reset_postdata();
                    } else { ?>
                        <div class="archived-posts"><?php echo esc_html__('No posts matching the query were found.', 'textdomain'); ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();
