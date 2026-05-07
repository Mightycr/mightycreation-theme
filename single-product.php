 <?php get_header(); ?>

 <main class="main">

     <div class="row mb-50">
         <div class="col-xs-12 col-sm-6 col-md-6 col-lg-7">
             <div class="article-single-images">
                 <div class="article-item-image">
                     <?php $image_links = $product->get_gallery_attachment_ids(); ?>
                     <?php foreach ($image_links as $image_link) {
                            echo '<img src="';
                            echo $image_link = wp_get_attachment_url($image_link);
                            echo '"/>';
                        }
                        ?>
                     <?php global $product;
                        if (!$product->is_in_stock()) {
                            echo '<span class="article-item-sold"></span>';
                        }
                        ?>
                 </div>
             </div>
             <div class="article-single-nav">
                 <a href="<?php echo get_home_url(); ?>" class="article-single-nav-all"></a>
                 <?php $prev_post = get_previous_post();
                    if ($prev_post) {
                        echo '<a rel="prev" href="' . get_permalink($prev_post->ID) . '"  class="article-single-nav-previous">previous logo<span></span></a>';
                    }
                    $next_post = get_next_post();
                    if ($next_post) {
                        echo '<a rel="next" href="' . get_permalink($next_post->ID) . '"  class="article-single-nav-next">next logo<span></span></a>';
                    }
                    ?>
             </div>

         </div>

         <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">
             <div class="article-single-info">
                 <div class="article-single-info-item">
                     <p class="asii-left">Product name:</p>
                     <h1><?php the_title(); ?></h1>
                 </div>


                 <div class="article-single-info-item">
                     <p class="asii-left">Description:</p>
                     <?php the_content(); ?>
                 </div>

                 <?php if (get_field('format')) : ?>
                     <div class="article-single-info-item">
                         <p class="asii-left">Format:</p>
                         <p><?php the_field('format'); ?></p>
                     </div>
                 <?php endif; ?>

                 <div class="article-single-info-item">
                     <p class="asii-left">Industries:</p>
                     <?php $current_tags = get_the_terms(get_the_ID(), 'product_tag');

                        if ($current_tags && !is_wp_error($current_tags)) {
                            echo '<ul>';
                            foreach ($current_tags as $tag) {
                                $tag_title = $tag->name;
                                $tag_link = get_term_link($tag);
                                echo '<li><a href="' . $tag_link . '">' . $tag_title . '</a></li>';
                            }
                            echo '</ul>';
                        }
                        ?>
                 </div>

                 <div class="row mt-40 mb-20">
                     <div class="col-xs-12">
                         <a class="btn btn-primary jsOrderLogoShow" data-product-name="<?php echo esc_attr(get_the_title()); ?>">Order this logo</a>
                     </div>
                 </div>

             </div>
         </div>

     </div>
     <!-- ./row-->


     <p class="related-heading">Related Logos</p>

     <div id="owl-logos" class="owl-carousel owl-logos">
         <?php
            // Check for current post category and add tax_query to the query arguments
            $cats = wp_get_post_terms(get_the_ID(), 'product_cat');
            $cats_ids = array();
            foreach ($cats as $wpex_related_cat) {
                $cats_ids[] = $wpex_related_cat->term_id;
            }
            $tags = wp_get_post_terms(get_the_ID(), 'product_tag');
            $tag_ids = array();
            foreach ($tags as $tag) {
                $tag_ids[] = $tag->term_id;
            }

            $args = array(
                'posts_per_page' => 10,
                // How many items to display
                'post__not_in' => array(get_the_ID()),
                // Exclude current post
                'no_found_rows' => true, // We don't ned pagination so this speeds up the query
                'orderby' => 'rand',
                'tax_query' => [
                    [
                        'taxonomy' => 'product_tag',
                        'field'    => 'term_id',
                        'operator' => 'IN',
                        'terms'    => $tag_ids,
                    ],
                ]
            );

            // Query posts
            $wpex_query = new wp_query($args);

            // Loop through posts
            foreach ($wpex_query->posts as $post) :
                setup_postdata($post); ?>
             <div class="item">
                 <a href="<?php the_permalink(); ?>">
                     <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
                     <img src="<?php echo $image['0']; ?>" />
                 </a>
             </div>
         <?php
            // End loop
            endforeach;

            // Reset post data
            wp_reset_postdata(); ?>
     </div>

 </main>
 <!-- ./main-->

 <?php get_footer(); ?>