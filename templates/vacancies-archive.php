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
                                        <span class="small text-muted">
                                            <span class="mx-2">|</span>
                                            <i class="lnr lnr-earth mr-2"></i>Nederland, Lekkerkerk </span>

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
