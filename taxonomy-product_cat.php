<?php
/**
 * WooCommerce Category Page Template
 */
get_header(); ?>

<main class="main">

    <?php
    $category = get_queried_object();

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category->slug,
            ),
        ),
    );

    $products = new WP_Query($args);

    // Collect product IDs to find their industry tags
    $product_ids = array();
    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            $product_ids[] = get_the_ID();
        }
        wp_reset_postdata();
        $products->rewind_posts();
    }

    // Get all unique product tags used by products in this category
    $industry_tags = array();
    if (!empty($product_ids)) {
        $tags = wp_get_object_terms($product_ids, 'product_tag', array('fields' => 'all'));
        if (!is_wp_error($tags)) {
            foreach ($tags as $tag) {
                $industry_tags[$tag->term_id] = $tag;
            }
        }
    }
    ?>

    <?php if (!empty($industry_tags)) : ?>
    <div class="product-bar">
        <div class="industry-filters">
            <button class="industry-filter-btn active" data-filter="all">All</button>
            <?php foreach ($industry_tags as $tag) : ?>
                <button class="industry-filter-btn" data-filter="<?php echo esc_attr($tag->slug); ?>"><?php echo esc_html($tag->name); ?></button>
            <?php endforeach; ?>
        </div>
        <div class="grid-controls">
            <button class="grid-toggle active" data-cols="3" title="3 columns">
                <svg width="14" height="14" viewBox="0 0 14 14"><rect x="0" y="0" width="3.5" height="3.5"/><rect x="5.25" y="0" width="3.5" height="3.5"/><rect x="10.5" y="0" width="3.5" height="3.5"/><rect x="0" y="5.25" width="3.5" height="3.5"/><rect x="5.25" y="5.25" width="3.5" height="3.5"/><rect x="10.5" y="5.25" width="3.5" height="3.5"/><rect x="0" y="10.5" width="3.5" height="3.5"/><rect x="5.25" y="10.5" width="3.5" height="3.5"/><rect x="10.5" y="10.5" width="3.5" height="3.5"/></svg>
            </button>
            <button class="grid-toggle" data-cols="4" title="4 columns">
                <svg width="14" height="14" viewBox="0 0 14 14"><rect x="0" y="0" width="2.5" height="2.5"/><rect x="3.83" y="0" width="2.5" height="2.5"/><rect x="7.66" y="0" width="2.5" height="2.5"/><rect x="11.5" y="0" width="2.5" height="2.5"/><rect x="0" y="3.83" width="2.5" height="2.5"/><rect x="3.83" y="3.83" width="2.5" height="2.5"/><rect x="7.66" y="3.83" width="2.5" height="2.5"/><rect x="11.5" y="3.83" width="2.5" height="2.5"/><rect x="0" y="7.66" width="2.5" height="2.5"/><rect x="3.83" y="7.66" width="2.5" height="2.5"/><rect x="7.66" y="7.66" width="2.5" height="2.5"/><rect x="11.5" y="7.66" width="2.5" height="2.5"/></svg>
            </button>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($products->have_posts()) : ?>
        <div class="row">
            <?php while ($products->have_posts()) : $products->the_post();
                global $product;
                $post_tags = wp_get_post_terms(get_the_ID(), 'product_tag', array('fields' => 'slugs'));
                $tag_slugs = !empty($post_tags) && !is_wp_error($post_tags) ? implode(' ', $post_tags) : '';
            ?>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 product-item-wrap" data-tags="<?php echo esc_attr($tag_slugs); ?>">
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
        <p>No products found in this category.</p>
    <?php endif; ?>

    <?php
    $testimonial_args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category->slug,
            ),
        ),
        'meta_query' => array(
            array(
                'key'     => '_testimonial_quote',
                'value'   => '',
                'compare' => '!=',
            ),
        ),
    );
    $testimonial_products = new WP_Query($testimonial_args);
    ?>

    <?php if ($testimonial_products->have_posts()) : ?>
    <div class="product-testimonials">
        <h2 class="product-testimonials-heading">What our clients say</h2>
        <div class="testimonials-list">
            <?php while ($testimonial_products->have_posts()) : $testimonial_products->the_post();
                $t_quote       = get_post_meta(get_the_ID(), '_testimonial_quote', true);
                $t_author_name = get_post_meta(get_the_ID(), '_testimonial_author_name', true);
                $t_author_role = get_post_meta(get_the_ID(), '_testimonial_author_role', true);
                if (empty($t_quote)) continue;
            ?>
                <div class="testimonial-item">
                    <?php if (has_post_thumbnail()) :
                        $t_img = wp_get_attachment_image_src(get_post_thumbnail_id(), array(56, 56));
                    ?>
                        <img src="<?php echo esc_url($t_img[0]); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="testimonial-logo-thumb" />
                    <?php endif; ?>
                    <div class="testimonial-quote">"<?php echo esc_html($t_quote); ?>"</div>
                    <div class="testimonial-author">
                        <?php if ($t_author_name) : ?>
                            <div class="testimonial-author-name"><?php echo esc_html($t_author_name); ?></div>
                        <?php endif; ?>
                        <?php if ($t_author_role) : ?>
                            <div class="testimonial-author-role"><?php echo esc_html($t_author_role); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
    <?php endif; ?>

</main>
<!-- ./main -->

<script>
(function () {
    var btns = document.querySelectorAll('.industry-filter-btn');
    var items = document.querySelectorAll('.product-item-wrap');

    btns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            btns.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');

            var filter = btn.getAttribute('data-filter');
            items.forEach(function (item) {
                if (filter === 'all') {
                    item.style.display = '';
                } else {
                    var tags = item.getAttribute('data-tags').split(' ');
                    item.style.display = tags.indexOf(filter) !== -1 ? '' : 'none';
                }
            });
        });
    });
}());
</script>

<?php get_footer(); ?>
