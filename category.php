<?php get_header();  ?>

<main class="blog-inner">

    <div class="blog-inner-left">

        <h1 class="blog-inner-left-title">Category: <?php single_cat_title(); ?></h1>

        <div class="blog-list">

            <?php if ( have_posts() ) : ?>

            <?php while ( have_posts() ) : the_post(); ?>
            <div class="blog-item">
                <a href="<?php the_permalink(); ?>" class="blog-image">
                    <?php  if ( has_post_thumbnail() ) {
                                        echo '<img src="' . get_the_post_thumbnail_url($post->ID, 'full') . '"/>';
                                    }
                    ?>
                    <span class="blog-image-arrow"></span>
                </a>

                <div class="blog-info">
                    <a href="<?php the_permalink(); ?>" class="blog-title">
                        <?php the_title(); ?>
                    </a>

                    <div class="row mb-10">
                        <div class="col-xs-12">
                            <p class="blog-date"><?php the_time('M d, Y') ?></p>
                            <p class="blog-category">
                                <?php
                $the_cat = get_the_category();
                $category_name = $the_cat[0]->cat_name;
                $category_link = get_category_link( $the_cat[0]->cat_ID );
            ?>
                                <a href="<?php echo $category_link ?>"><?php echo $category_name ?></a>
                            </p>
                        </div>
                    </div>
                    <!-- ./row -->

                    <div class="blog-desc">
                        <?php the_excerpt(); ?>
                    </div>

                    <a href="<?php the_permalink(); ?>" class="blog-link">
                        Read more
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>

            <?php else:  ?>
            <p class="text-center"><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
            <?php endif; ?>

        </div>

    </div>
    <!-- ./blog-inner-left-->

    <div class="blog-inner-right">
        <div class="blog-inner-right-box">
            <h1 class="blog-inner-right-title">Categories</h1>
            <ul class="blog-categories">
                <li class="current"><a href="<?php echo get_page_link( get_page_by_title("Blog")->ID ); ?>">All</a></li>
                <?php
            $categories = get_categories();
            foreach($categories as $category) {
              
                echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '<span class="no">(' . $category->category_count . ')</span></a> </li>';
            }
            ?>
            </ul>
        </div>

        <div class="newsletter">
            <div id="mc_embed_signup">
                <form class="mceNewsletter" action="https://poppetrov.us19.list-manage.com/subscribe/post" method="post" target="formaReturning">
                    <input type="hidden" name="u" value="ddc39fac8ef3c30258c3f4a92">
                    <input type="hidden" name="id" value="e1fdcf3d93">
                    <h4 class="mb-10">newsletter</h4>
                    <div class="newsletter-box">
                        <input type="email" value="" name="EMAIL" class="newsletter-form-control email" id="mce-EMAIL" placeholder="your e-mail" required />
                        <input type="submit" value="send" name="subscribe" id="mc-embedded-subscribe" class="newsletter-btn" />
                    </div>
                </form>
                <div class="newsletter-error">
                    <p></p>
                </div>
                <div class="newsletter-thank-you">
                    <p>Thank you for subscribing!</p>
                </div>
            </div>
        </div>
        <!-- ./newsletter-->

    </div>
    <!-- ./blog-inner-right-->

</main>
<!-- ./blog-inner-->

<?php get_footer(); ?>
