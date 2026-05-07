<?php get_header();
/*
Template Name: Contact
*/
?>

<main class="main">

    <div class="contact-box">
        <h1><?php the_title(); ?></h1>
        <?php while (have_posts()) : the_post();
            the_content();
        endwhile; ?>
    </div>

</main>
<!-- ./main-->

<?php get_footer(); ?>