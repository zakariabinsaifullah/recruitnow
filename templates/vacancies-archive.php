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
            'posts_per_page' => 1,
            'paged' => $paged
        )
    );
    ?>
    <div class="posts-section">
        <?php if ($posts_query->have_posts()) { ?>
            <h2><?php echo esc_html__('Latest Vacancies', 'textdomain'); ?></h2>
            <div class="archived-posts">
                <?php while ($posts_query->have_posts()) {
                    $posts_query->the_post(); ?>
                    <div class="archive-item">
                        <?php if (has_post_thumbnail(get_the_ID())) { ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail(); ?>
                                </a>
                            </div>
                        <?php } ?>
                        <div class="post-title">
                            <a href="<?php the_permalink(); ?>">
                                <h3><?php the_title(); ?></h3>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php
            $total_pages = $posts_query->max_num_pages;
            if ($total_pages > 1) {
                $current_page = max(1, get_query_var('paged')); ?>
                <div class="archive-pagination">
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
</main>
<?php
get_footer();
