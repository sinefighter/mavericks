<main class="main" id="main">
<?php if ( have_posts() ) { ?>
	<?php
	echo get_template_part( 'parts/block-breadcrumbs');

	echo get_template_part( 'parts/block-title');

	?>
	<section class="section margin-top-negative">
		<div class="wrap" id="list-posts">
			<div class="row news-amount">
			<?php while ( have_posts() ) { the_post(); ?>
				<?php get_template_part( 'parts/block', 'post' ); ?>
			<?php } ?>
			</div>
			<div class="pagination">
				<?php echo paginate_links(); ?>
			</div>
		</div>
	</section>
<?php } ?>
</main>