<?php get_header();
/*
Template Name: Home
*/
?>

<main class="main">

    <?php
    $params = array('posts_per_page' => -1, 'post_type' => 'product');
    $wc_query = new WP_Query($params);
    ?>
    <?php if ($wc_query->have_posts()) : ?>
        <div class="row">
            <?php while ($wc_query->have_posts()) :
                $wc_query->the_post(); ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                    <article class="article-item">
                        <?php if (has_post_thumbnail()) { ?>
                            <div class="article-item-image">
                                <?php
                                $image_id = get_post_thumbnail_id();
                                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
                                $image_title = get_the_title($image_id);
                                $size = 'my-size';
                                $image_src = wp_get_attachment_image_src($image_id, $size)[0];
                                ?>
                                <img src="<?php echo $image_src; ?>" title="<?php echo $image_title ?>" alt="<?php echo $image_alt ?>" />
                                <?php global $product;
                                if (!$product->is_in_stock()) {
                                    echo '<span class="article-item-sold"></span>';
                                }
                                ?>
                            </div>
                        <?php } else { ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/images//placeholder-600x400.jpg" />
                        <?php } ?>
                        <div class="article-item-info">
                            <h1 class="article-item-info-title"> <?php the_title(); ?></h1>
                            <div class="article-item-info-title-desc">
                                <?php the_excerpt(); ?>
                            </div>
                            <p class="mb-30"><span class="color-silver">Release date</span> <?php the_time('jS F, Y'); ?> </p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary article-item-info-btn">View Details</a>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php else :  ?>
            <p>
                <?php _e('No Products'); ?>
            </p>
        <?php endif; ?>
        </div>
        <!-- ./row-->

</main>
<!-- ./main-->

<?php get_footer(); ?>