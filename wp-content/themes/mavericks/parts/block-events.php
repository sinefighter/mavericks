<div class="col-6 col-md">
    <div class="card-square">
        <div class="card-square-inner">
            <div class="card-square-date">
                <span class="day">
                    <?php echo get_the_date('d'); ?>
                </span>
                <span class="month">
                    <?php echo get_the_date('F Y'); ?>
                </span>
            </div>
            <div class="card-square-title">
                <?php $event_taxes = wp_get_post_terms(get_the_ID(), 'event_type', ['fields' => 'names']); ?>
                <?php foreach($event_taxes as $tax) { ?>
                    <span># <?php echo $tax; ?></span>
                <?php } ?>
                <h2>
                    <a href="<?php the_permalink(); ?>" class="like-h3">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <span><?php echo get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name'); ?></span>
            </div>
        </div>
    </div>
</div>