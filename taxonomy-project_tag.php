<?php
/**
* A Simple Tag Template
*/
 
get_header(); ?>


<main class="tag-template">

    <div class="tag-template-header">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                <h3 class="color-white fontRobotoMono mb-0">Tagged as</h3>
                <h1 class="color-white mb-0 fontLarge"><?php single_tag_title( ); ?></h1>
            </div>
        </div>
        <!-- ./row-->

    </div>
    <!-- ./tag-template-header-->

    <div class="tag-template-item">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <h1 class="tag-template-item-title">Projects</h1>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="tag-template-item-box">
                    <?php if ( have_posts() ) : ?>
                    <div class="row">
                        <?php while ( have_posts() ) : the_post(); ?>
                        <div class="col-xs-12 col-sm-6 mb-20">
                            <a href="<?php the_permalink(); ?>">
                                <?php  if ( has_post_thumbnail() ) {
                                            echo '<img src="' . get_the_post_thumbnail_url($post->ID, 'full') . '" />';
                                        }else { 
                                            echo '<img src="' . get_bloginfo( 'stylesheet_directory') . '/images/placeholder-blog.jpg" />';        
                                    }?>
                            </a>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <!-- ./row-->
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- ./row-->
    </div>
    <!-- ./tag-template-item-->

</main>
<!-- ./tag-template-->

<?php get_footer(); ?>
