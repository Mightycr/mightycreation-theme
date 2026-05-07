<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content='width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport' />

    <?php if ( is_front_page() ) : ?>
    <title><?php bloginfo('name'); ?></title>
    <?php else : ?>
    <title><?php wp_title(); ?></title>
    <?php endif; ?>

    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png" sizes="128x128" type="image/png" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <section class="left-menu">

        <a class="nav-mobile jsNavMobile">
            <span></span>
            <span></span>
            <span></span>
        </a>

        <a href="<?php echo get_home_url(); ?>" class="logo"></a>

        <?php wp_nav_menu( array( 'theme_location' => 'main_menu', 'container'=> false, 'menu_class' =>  'nav')); ?>

        <?php wp_nav_menu( array( 'theme_location' => 'secondary_menu', 'container'=> false, 'menu_class' =>  'nav-bottom')); ?>

        <a class="btn btn-primary jsOrderLogoShow">Order Logo</a>

        <?php wp_nav_menu( array( 'theme_location' => 'social_networks_menu', 'container'=> false, 'menu_class' =>  'social-networks')); ?>

    </section>
    <!-- ./left-menu-->
