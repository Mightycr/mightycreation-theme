<?php

/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>


<main class="main">

    <div class="text-center padded120">
        <h1>404</h1>
        <h2>The page you are looking for does not exist yet!</h2>
        <a href="<?php echo get_home_url(); ?>" class="btn btn-primary">Back to home</a>
    </div>

</main>
<!-- ./main-->

<?php get_footer(); ?>