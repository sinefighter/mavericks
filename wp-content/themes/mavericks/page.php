<?php get_header(); ?>
<main class="main" id="main">
<?php while ( have_posts() ) { the_post(); ?>

	<?php
	echo get_template_part( 'parts/block-breadcrumbs');

	echo get_template_part( 'parts/block-title');
	?>
	
<?php } ?>
</main>

<?php get_footer(); ?>