<?php

$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
$today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$yesterday = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));

// echo 'dzisiaj: ' . $today . '<br>';
// echo 'jutro: ' . $tomorrow . '<br>';
// echo 'wczoraj: ' . $yesterday . '<hr>';

if (get_option( 'todayCite' ) == $today) {
  $post = get_post( get_option( 'todayCiteContent' ) );
  echo '<div class="quote_content">"' . $post->post_content . '"</div><div class="quote_author">Autor: ' . $post->post_title . '</div>';

}
else {

  $args = array( 'post_type' => 'quote', 'orderby'=> 'rand', 'posts_per_page' => 1 );
  $loop = new WP_Query( $args );
  while ( $loop->have_posts() ) : $loop->the_post();
    update_option( 'todayCite', $today );
    update_option( 'todayCiteContent', get_the_id() );
       echo '<div class="quote_content">"' . get_the_content() . '"</div><div class="quote_author">Autor: ' . get_the_title() . '</div>';

  endwhile;


};

 ?>
