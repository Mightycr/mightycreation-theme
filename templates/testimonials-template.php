<?php
/*
Template Name: Testimonials
*/
get_header(); ?>

<main class="main">

    <div class="testimonials-list">

        <?php
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'meta_query'     => array(
                array(
                    'key'     => '_testimonial_quote',
                    'value'   => '',
                    'compare' => '!=',
                ),
            ),
        );
        $testimonial_products = new WP_Query($args);

        if ($testimonial_products->have_posts()) :
            while ($testimonial_products->have_posts()) : $testimonial_products->the_post();
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
        <?php
            endwhile;
            wp_reset_postdata();
        else :
        ?>
            <p>No testimonials yet.</p>
        <?php endif; ?>

    </div>

</main>
<!-- ./main-->

<?php get_footer(); ?>
