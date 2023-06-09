<?php get_header(); ?>
<main class="main" id="main">
<?php while ( have_posts() ) { the_post(); ?>

	<?php
	echo get_template_part( 'parts/block-breadcrumbs');

	echo get_template_part( 'parts/block-title');
	
	?>

	<section class="section blog-section margin-top-negative-md">
		<div class="wrap">
			<div class="main-image news-main-image">
				<img src="<?php echo get_template_directory_uri(); ?>/dist/img/course.jpg" alt="" class="cover-img">
			</div>
			<div class="row-w content blog-content">
				<div class="col-10-w col-md-w">
					<p>У червні в Києві розпочне роботу відкритий простір для освітян «Освіторія Хаб», повідомляє прес-служба проекту. </p>
					<p>Освітній простір площею тисячу квадратних метрів буде розташовано на вулиці Московській, 8Б, неподалік від Мистецького Арсеналу. </p>
					<p>В «Освіторія Хаб» облаштують коворкінг на 40 місць. У ньому можна буде орендувати місце на місяць або погодинно. </p>
					<p>Тут є шість приватних офісів для невеликих колективів на 4-8 працівників, скайп-будки, переговорні кімнати, а також кухня з безкоштовним молоком, кавою, чаєм і печивом, кав’ярня, лаунж-зона, тренувальний зал, душ і туалет. Принтер і сканер – у цілодобовому доступі.</p>
					<img src="<?php echo get_template_directory_uri(); ?>/dist/img/I2.png" alt="">
					<p>В лекторії на 170 осіб планують проводити лекції та тренінги запрошених іноземних спікерів і світових лідерів думок в освітній галузі. Лекторій обладнаний акустичною системою і трьома плазмовими екранами. </p>
					<p>Відвідувачі матимуть вільний доступ до бібліотеки з мотиваційною літературою для вчителів і батьків. Одна з родзинок простору – декоративні стіни, обиті м’якими панелями. На них можна прикріпляти файли, малюнки, фото тощо. Ще одна стіна з білого скла в коворкінгу також придатна для малювання та стікерів. На території Хабу розташовано невеликий парк. Цього року поряд відкриють Фестивальну площу, де проводитимуть освітні фестивалі та пізнавальні кемпи для учнів. Крім того, поряд із Хабом працюватиме Міський ринок їжі. </p>
					<p>У новому просторі розміститься тренінговий центр ГС «Освіторія», а також приміщенням зможуть користуватися освітні громадські організації; IT-стартапи, які створюють soft для закладів освіти; батьки, які хочуть дізнатися більше про виховання дітей тощо. Нагадаємо, торік у Києві відкрили новий кампус інноваційного парку UNIT.City з коворкінгом Chasopys.</p>
				</div>
			</div>
		</div>
	</section>

	<?php if(get_post_type() != 'events') { ?>
		<?php
			$posts_per_page = 2;
			$random_posts = new  WP_Query([
				'post_type' => 'post',
				'orderby' => 'rand',
				'posts_per_page' => $posts_per_page,
				'post__not_in' => [get_the_ID()],
			]);
		?>
		<?php if($random_posts->have_posts()) { ?>
		<section class="section blog-latest">
			<div class="wrap">
				<h2 class="t-center">
					ОСТАННІ НОВИНИ
				</h2>
				<div class="row news-amount">
					<?php while($random_posts->have_posts()) { $random_posts->the_post(); ?>
						<?php get_template_part( 'parts/block', 'post' ); ?>
					<?php } wp_reset_postdata(); ?>
				</div>
			</div>
		</section>
		<?php } ?>
	<?php } ?>
<?php } ?>
</main>

<?php get_footer(); ?>
