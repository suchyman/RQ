<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
	$odb = $_POST["group1"]; //set PHP variables like this so we can use them anywhere in code below
  update_option( 'todayCiteOption', $odb );

echo '<div class="notice notice-success is-dismissible">
	<p><strong>Settings saved.</strong></p>
</div>';

}

$option = get_option( 'todayCiteOption' );

echo '<div class="wrap">';
echo '<h1>Option for Random Citi.</h1>';
echo '<p>';
//echo $option;
// echo ($option == 'v') ? 'hehehe' : 'false';
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
