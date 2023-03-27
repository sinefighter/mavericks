<?php

if(is_home() && !is_front_page()) {
	$titleClasses = 'page-title-bottom-md';
}elseif(is_page()){
	$titleClasses = 'page-title-center page-title-lg';
}elseif(is_single()){
	$titleClasses = 'page-title-sm page-title-bottom-md';
}else{
	$titleClasses = 'page-title-bottom-md';
}


$titleDescription = true;
$titleBtns = true;
?>

<section class="page-title <?php echo $titleClasses; ?>" id="page-title">
	<div class="wrap">
		<h1>
			<?php 
				if(is_home() && !is_front_page()) {
					single_post_title();
				}elseif(is_category()){
                    single_term_title();
				}else{
					the_title();
                }
			?>
		</h1>

		<?php if($titleDescription){ ?>
			<span class="page-title-desc">
				ТЕРИТОРІЯ НОВИХ МОЖЛИВОСТЕЙ <span>ДЛЯ КОЖНОГО</span>
			</span>
		<?php } ?> 

		<?php if($titleBtns) { ?>
			<div class="page-title-btns">
				<a href="#" class="btn-light">ПОЧАТИ НАВЧАННЯ</a>
				<a href="#" class="btn-light-tr">ДІЗНАТИСЯ БІЛЬШЕ</a>
			</div>
		<?php } ?>
	</div>

</section>