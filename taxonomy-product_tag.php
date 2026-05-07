<?php
/**
 * WooCommerce Tag Template
 */
get_header(); ?>

<main class="main">

    <h1>Tag: <?php single_tag_title(); ?></h1>

    <?php
    $tag = get_queried_object(); // Get the current tag object

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,  // Get all products
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_tag', // WooCommerce product tag taxonomy
                'field'    => 'slug',
                'terms'    => $tag->slug,
            ),
        ),
    );

    $products = new WP_Query($args);

    if ($products->have_posts()) : ?>
        <div class="row">
            <?php while ($products->have_posts()) : $products->the_post();
                global $product;
            ?>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                    <article class="article-item">
                        <?php if (has_post_thumbnail()) { ?>
                            <div class="article-item-image">
                                <?php
                                $image_id = get_post_thumbnail_id();
                                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                                $image_title = get_the_title($image_id);
                                $image_src = wp_get_attachment_image_src($image_id, 'my-size')[0];
                                ?>
                                <img src="<?php echo esc_url($image_src); ?>" title="<?php echo esc_attr($image_title); ?>" alt="<?php echo esc_attr($image_alt); ?>" />
                                <?php if (!$product->is_in_stock()) {
                                    echo '<span class="article-item-sold">Sold Out</span>';
                                } ?>
                            </div>
                        <?php } else { ?>
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/placeholder-600x400.jpg" />
                        <?php } ?>
                        <div class="article-item-info">
                            <h2 class="article-item-info-title"><?php the_title(); ?></h2>
                            <div class="article-item-info-title-desc">
                                <?php the_excerpt(); ?>
                            </div>
                            <p class="mb-30"><span class="color-silver">Release date:</span> <?php echo get_the_date('jS F, Y'); ?></p>
                            <p class="mb-30"><span class="color-silver">Price:</span> <?php echo $product->get_price_html(); ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary article-item-info-btn">View Details</a>
                        </div>
                    </article>
                </div>

            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <!-- ./row-->

    <?php else : ?>
        <p>No products found with this tag.</p>
    <?php endif; ?>

</main>
<!-- ./main -->

<?php get_footer(); ?>
