<?php
/**
 * WooCommerce Tag Template
 */
get_header(); ?>

<main class="main">

    <div class="product-bar">
        <p class="tag-label">Tag: <?php single_tag_title(); ?></p>
        <div class="grid-controls">
            <button class="grid-toggle active" data-cols="3" title="3 columns">
                <svg width="14" height="14" viewBox="0 0 14 14"><rect x="0" y="0" width="3.5" height="3.5"/><rect x="5.25" y="0" width="3.5" height="3.5"/><rect x="10.5" y="0" width="3.5" height="3.5"/><rect x="0" y="5.25" width="3.5" height="3.5"/><rect x="5.25" y="5.25" width="3.5" height="3.5"/><rect x="10.5" y="5.25" width="3.5" height="3.5"/><rect x="0" y="10.5" width="3.5" height="3.5"/><rect x="5.25" y="10.5" width="3.5" height="3.5"/><rect x="10.5" y="10.5" width="3.5" height="3.5"/></svg>
            </button>
            <button class="grid-toggle" data-cols="4" title="4 columns">
                <svg width="14" height="14" viewBox="0 0 14 14"><rect x="0" y="0" width="2.5" height="2.5"/><rect x="3.83" y="0" width="2.5" height="2.5"/><rect x="7.66" y="0" width="2.5" height="2.5"/><rect x="11.5" y="0" width="2.5" height="2.5"/><rect x="0" y="3.83" width="2.5" height="2.5"/><rect x="3.83" y="3.83" width="2.5" height="2.5"/><rect x="7.66" y="3.83" width="2.5" height="2.5"/><rect x="11.5" y="3.83" width="2.5" height="2.5"/><rect x="0" y="7.66" width="2.5" height="2.5"/><rect x="3.83" y="7.66" width="2.5" height="2.5"/><rect x="7.66" y="7.66" width="2.5" height="2.5"/><rect x="11.5" y="7.66" width="2.5" height="2.5"/></svg>
            </button>
        </div>
    </div>

    <?php
    $tag = get_queried_object();

    $show_all_stock = function( $query ) {
        $mq = $query->get( 'meta_query' );
        if ( is_array( $mq ) ) {
            foreach ( $mq as $k => $clause ) {
                if ( isset( $clause['key'] ) && $clause['key'] === '_stock_status' ) {
                    unset( $mq[ $k ] );
                }
            }
            $query->set( 'meta_query', array_values( $mq ) );
        }
    };
    add_action( 'pre_get_posts', $show_all_stock, 9999 );

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_tag',
                'field'    => 'slug',
                'terms'    => $tag->slug,
            ),
        ),
    );

    $products = new WP_Query($args);
    remove_action( 'pre_get_posts', $show_all_stock, 9999 );

    if ($products->have_posts()) : ?>
        <div class="row" id="product-grid">
            <?php while ($products->have_posts()) : $products->the_post();
                global $product;
            ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 product-item-wrap">
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
                                    echo '<span class="article-item-sold"></span>';
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
                            <p class="mb-30"><span class="color-silver">Release date:</span><?php echo get_the_date('jS F, Y'); ?></p>
                            <p class="mb-30 article-item-price"><span class="color-silver">Price:</span><?php echo $product->get_price_html(); ?></p>
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
