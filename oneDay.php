<?php

$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
$today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
$yesterday = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));

echo 'dzisiaj: ' . $today . '<br>';
echo 'jutro: ' . $tomorrow . '<br>';
echo 'wczoraj: ' . $yesterday . '<hr>';
// add_option( 'todayCiteContent', 'tresc', '', 'yes' );
//add_option( 'todayCiteOption', 'd', '', 'yes' );

// //update_option( 'default_comment_status', 'closed' );
// //(get_option( 'todayCite' )
//
//
if (get_option( 'todayCite' ) == $today) {
	//echo get_option( 'todayCiteContent' ) . '<br>ads<br>';
  $post = get_post( get_option( 'todayCiteContent' ) );
// let's get a post title by ID
  // echo $post->post_title . '<br>' . $post->post_content;
  echo '<div class="quote_content">"' . $post->post_content . '"</div><div class="quote_author">Autor: ' . $post->post_title . '</div>';
  // $args = array( 'post_type' => 'quote', 'ID'=> get_option( 'todayCiteContent' ), 'posts_per_page' => 1 );
  // $loop = new WP_Query( $args );
  // while ( $loop->have_posts() ) : $loop->the_post();
  //      echo 'dzisiejszy id: ' . get_option('todayCiteContent') . '  <div class="quote_content">"' . get_the_content() . '"</div><div class="quote_author">Autor: ' . get_the_title() . '</div>';
  // 		// echo get_the_id() . '<div class="quote_content">"' . get_the_content() . '"</div><div class="quote_author">Autor: ' . get_the_title() . '</div>';
  // endwhile;
}
else {
	// echo 'niet <br>'; inny dzien niz ten w bazie

  $args = array( 'post_type' => 'quote', 'orderby'=> 'rand', 'posts_per_page' => 1 );
  $loop = new WP_Query( $args );
  while ( $loop->have_posts() ) : $loop->the_post();
    update_option( 'todayCite', $today );
    // $idek = get_the_id();
    // echo $idek . '<br><hr>';
    update_option( 'todayCiteContent', get_the_id() );
       echo '<div class="quote_content">"' . get_the_content() . '"</div><div class="quote_author">Autor: ' . get_the_title() . '</div>';
  		// echo get_the_id() . '<div class="quote_content">"' . get_the_content() . '"</div><div class="quote_author">Autor: ' . get_the_title() . '</div>';
  endwhile;

	// update_option( 'default_comment_status', 'closed' );
};
//
// echo get_option( 'todayCite' ) . '<br><hr>';

 ?>
