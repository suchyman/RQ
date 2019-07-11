<?php
$args = array( 'post_type' => 'quote', 'orderby'=> 'rand', 'posts_per_page' => 1 );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
    echo '<div class="quote_content">"' . get_the_content() . '"</div><div class="quote_author">Autor: ' . get_the_title() . '</div>';
		// echo get_the_id() . '<div class="quote_content">"' . get_the_content() . '"</div><div class="quote_author">Autor: ' . get_the_title() . '</div>';
endwhile;

 ?>
