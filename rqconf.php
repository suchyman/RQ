<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$odb = $_POST["group1"];
  update_option( 'todayCiteOption', $odb );

echo '<div class="notice notice-success is-dismissible">
	<p><strong>Settings saved.</strong></p>
</div>';

}

$option = get_option( 'todayCiteOption' );

echo '<div class="wrap">';
echo '<h1>Option for Random Citi.</h1>';
echo '<p>';
echo '
<form action="" method="POST">
<input type="radio" name="group1" value="d"'.(($option=='d')?'checked="checked"':"").'> One quote for one day (random quote for one day)<br>
<input type="radio" name="group1" value="v" '.(($option=='v')?'checked="checked"':"").'> One quote for visit (randomize citi in each visit)<br>
<input type="submit" class="btn btn-success" value="Submit" >
</form>
';
echo '</p>';
echo '</div>';
 ?>
