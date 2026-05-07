<?php get_header(); ?>

<main class="main">


    <h1>Blog</h1>


    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <h1><?php the_title(); ?></h1>


            <p><?php the_time('jS F, Y') ?></p>
            <p>
                <?php
                $the_cat = get_the_category();
                $category_name = $the_cat[0]->cat_name;
                $category_link = get_category_link($the_cat[0]->cat_ID);
                ?>
                <a href="<?php echo $category_link ?>"><?php echo $category_name ?></a>
            </p>



            <?php if (has_post_thumbnail()) {
                echo '<img src="' . get_the_post_thumbnail_url($post->ID, 'full') . '"  />';
            } else {
                echo '<img src="' . get_bloginfo('stylesheet_directory') . '/images/placeholder-blog.jpg" />';
            } ?>



            <?php the_content(); ?>




        <?php endwhile; ?>
    <?php endif; ?>

    <hr />


    <?php $prevPost = get_previous_post();
    if ($prevPost) { ?>
        <div class="blog-nav blog-nav-previous ">
            <p class="blog-nav-title">Previous post</p>
            <?php previous_post_link('%link', "%title"); ?>
        </div>
    <?php } ?>

    <a href="<?php echo get_page_link(get_page_by_title("Blog")->ID); ?>" class="blog-back"></a>

    <?php $nextPost = get_next_post();
    if ($nextPost) { ?>
        <div class="blog-nav blog-nav-next">
            <p class="blog-nav-title">Next post</p>
            <?php next_post_link('%link', "%title"); ?>
        </div>
    <?php } ?>

    <hr />

    <h1>Categories</h1>

    <ul>
        <li class="current"><a href="<?php echo get_page_link(get_page_by_title("Blog")->ID); ?>">All</a></li>
        <?php
        $categories = get_categories();
        foreach ($categories as $category) {

            echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '<span class="no">(' . $category->category_count . ')</span></a> </li>';
        }
        ?>
    </ul>


    <?php get_footer(); ?>