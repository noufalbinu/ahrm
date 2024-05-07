/*
 * Template Name: zontheme
 */

<!-- Header -->
<?php include (TEMPLATEPATH . '/header.php'); ?>
<!-- End Header -->
<!-- middle content area -->
<div id="midbox">
<?php get_sidebar( 'right' ); ?>
<!-- main content area -->
<a name="maincontent" id="maincontent"></a>
<!-- WordPress Loop -->
<div class="blogpostwrapper">
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div class="blogpost">
<h3 class="entrytitle" id="post-<?php the_ID(); ?>"> <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?> </a> </h3>
<?php the_content(); ?>
</div>
<?php endwhile; ?>
<?php else : ?>
<h6 class="center">Not Found</h6>
<p class="center">Sorry, but you are looking for something that isn't here.</p>
<?php include (TEMPLATEPATH . "/searchform.php"); ?>
<?php endif; ?>
</div>
<!-- End WordPress Loop -->
<!-- end main content area -->
</div>
<!-- end middle content area -->
<!-- Footer -->
<?php include (TEMPLATEPATH . '/footer.php'); ?>
<!-- Footer -->







