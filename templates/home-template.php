<?php get_header();
/*
Template Name: Home
*/
?>

<main class="main">

    <div id="site-hero" class="site-hero">
        <div class="site-hero-inner">
            <h1 class="site-hero-title"><?php bloginfo('name'); ?></h1>
            <p class="site-hero-subtitle">Unique, ready-made logo designs for visionary brands</p>
            <a href="#" id="hero-cta" class="btn btn-primary">Check my logos</a>
        </div>
    </div>

    <?php
    $params = array('posts_per_page' => -1, 'post_type' => 'product');
    $wc_query = new WP_Query($params);

    $product_ids = array();
    if ($wc_query->have_posts()) {
        while ($wc_query->have_posts()) {
            $wc_query->the_post();
            $product_ids[] = get_the_ID();
        }
        wp_reset_postdata();
        $wc_query->rewind_posts();
    }

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

    <div class="bar-and-grid">

        <div class="product-bar">
            <?php if (!empty($industry_tags)) : ?>
            <div class="industry-filters">
                <button class="industry-filter-btn active" data-filter="all">All</button>
                <?php foreach ($industry_tags as $tag) : ?>
                    <button class="industry-filter-btn" data-filter="<?php echo esc_attr($tag->slug); ?>"><?php echo esc_html($tag->name); ?></button>
                <?php endforeach; ?>
            </div>
            <?php else : ?>
            <div></div>
            <?php endif; ?>
            <div class="grid-controls">
                <button class="grid-toggle" data-cols="3" title="3 columns">
                    <svg width="14" height="14" viewBox="0 0 14 14"><rect x="0" y="0" width="3.5" height="3.5"/><rect x="5.25" y="0" width="3.5" height="3.5"/><rect x="10.5" y="0" width="3.5" height="3.5"/><rect x="0" y="5.25" width="3.5" height="3.5"/><rect x="5.25" y="5.25" width="3.5" height="3.5"/><rect x="10.5" y="5.25" width="3.5" height="3.5"/><rect x="0" y="10.5" width="3.5" height="3.5"/><rect x="5.25" y="10.5" width="3.5" height="3.5"/><rect x="10.5" y="10.5" width="3.5" height="3.5"/></svg>
                </button>
                <button class="grid-toggle active" data-cols="4" title="4 columns">
                    <svg width="14" height="14" viewBox="0 0 14 14"><rect x="0" y="0" width="2.5" height="2.5"/><rect x="3.83" y="0" width="2.5" height="2.5"/><rect x="7.66" y="0" width="2.5" height="2.5"/><rect x="11.5" y="0" width="2.5" height="2.5"/><rect x="0" y="3.83" width="2.5" height="2.5"/><rect x="3.83" y="3.83" width="2.5" height="2.5"/><rect x="7.66" y="3.83" width="2.5" height="2.5"/><rect x="11.5" y="3.83" width="2.5" height="2.5"/><rect x="0" y="7.66" width="2.5" height="2.5"/><rect x="3.83" y="7.66" width="2.5" height="2.5"/><rect x="7.66" y="7.66" width="2.5" height="2.5"/><rect x="11.5" y="7.66" width="2.5" height="2.5"/></svg>
                </button>
            </div>
        </div>

        <div class="grid-scroll">
            <?php if ($wc_query->have_posts()) : ?>
                <div class="row" id="product-grid">
                    <?php while ($wc_query->have_posts()) :
                        $wc_query->the_post();
                        $post_tags = wp_get_post_terms(get_the_ID(), 'product_tag', array('fields' => 'slugs'));
                        $tag_slugs = (!empty($post_tags) && !is_wp_error($post_tags)) ? implode(' ', $post_tags) : '';
                    ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 product-item-wrap" data-tags="<?php echo esc_attr($tag_slugs); ?>">
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
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/placeholder-600x400.jpg" />
                                <?php } ?>
                                <div class="article-item-info">
                                    <h1 class="article-item-info-title"><?php the_title(); ?></h1>
                                    <div class="article-item-info-title-desc">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    <p class="mb-30"><span class="color-silver">Release date</span><?php the_time('jS F, Y'); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary article-item-info-btn">View Details</a>
                                </div>
                            </article>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
                <!-- ./row-->
            <?php else : ?>
                <p><?php _e('No Products'); ?></p>
            <?php endif; ?>
        </div><!-- .grid-scroll -->

    </div><!-- .bar-and-grid -->

</main>
<!-- ./main-->

<script>
(function () {
    var i, j;

    // Industry filter
    var btns  = document.querySelectorAll('.industry-filter-btn');
    var items = document.querySelectorAll('.product-item-wrap');

    var gridScroll = document.querySelector('.grid-scroll');

    function attachFilter(btn) {
        btn.addEventListener('click', function () {
            for (j = 0; j < btns.length; j++) btns[j].classList.remove('active');
            btn.classList.add('active');
            var filter = btn.getAttribute('data-filter');
            for (j = 0; j < items.length; j++) {
                var item = items[j];
                if (filter === 'all') {
                    item.style.display = '';
                } else {
                    var tags = (item.getAttribute('data-tags') || '').split(' ');
                    item.style.display = tags.indexOf(filter) !== -1 ? '' : 'none';
                }
            }
            if (gridScroll) gridScroll.scrollTop = 0;
        });
    }
    for (i = 0; i < btns.length; i++) attachFilter(btns[i]);

    // Grid toggle
    var gridBtns  = document.querySelectorAll('.grid-toggle');
    var gridItems = document.querySelectorAll('.product-item-wrap');

    function setGrid(cols) {
        for (i = 0; i < gridItems.length; i++) {
            if (cols === 4) {
                gridItems[i].classList.remove('col-lg-4');
                gridItems[i].classList.add('col-lg-3');
            } else {
                gridItems[i].classList.remove('col-lg-3');
                gridItems[i].classList.add('col-lg-4');
            }
        }
    }
    function attachGrid(btn) {
        btn.addEventListener('click', function () {
            for (j = 0; j < gridBtns.length; j++) gridBtns[j].classList.remove('active');
            btn.classList.add('active');
            setGrid(parseInt(btn.getAttribute('data-cols'), 10));
        });
    }
    for (i = 0; i < gridBtns.length; i++) attachGrid(gridBtns[i]);
}());
</script>

<?php get_footer(); ?>
