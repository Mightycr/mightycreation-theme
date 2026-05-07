<?php get_header();
/*
Template Name: About
*/
?>

<?php
// ACF fields
$photo = get_field('photo');
$author_full_name = get_field('author_full_name');
$author_job_title = get_field('author_job_title');
?>

<main class="main">

    <div class="about-box">
        <?php while (have_posts()):
            the_post();
            the_content();
        endwhile; ?>
        <div class="about-box-author">
            <?php if ($photo): ?>
                <div class="about-box-author-photo">
                    <img src="<?php echo esc_url($photo['url']); ?>" alt="<?php echo esc_attr($photo['alt']); ?>">
                </div>
            <?php endif; ?>

            <div class="about-box-author-author-info">
                <?php if ($author_full_name): ?>
                    <h4><?php echo esc_html($author_full_name); ?></h4>
                <?php endif; ?>
                <?php if ($author_job_title): ?>
                    <p><?php echo esc_html($author_job_title); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</main>
<!-- ./main-->

<?php get_footer(); ?>