    <?php get_header(); ?>

    <main class="main">

        <h1><?php the_title(); ?></h1>

        <?php while ( have_posts() ) : the_post();
                the_content();
		      endwhile; ?>

    </main>
    <!-- ./main-->

    <?php get_footer(); ?>
