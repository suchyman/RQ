<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              suchyman.cloud
 * @since             1.0.0
 * @package           Random_quote
 *
 * @wordpress-plugin
 * Plugin Name:       RandQuot
 * Plugin URI:        suchyman.pl
 * Description:       Plugin create Custom Post type i admin area. You can add new widget with author and text of citie...
 * Version:           1.0.0
 * Author:            Suchyman
 * Author URI:        suchyman.cloud
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       random_quote
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
define('WP_DEBUG', true);
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RANDOM_QUOTE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-random_quote-activator.php
 */
function activate_random_quote() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-random_quote-activator.php';
	Random_quote_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-random_quote-deactivator.php
 */
function deactivate_random_quote() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-random_quote-deactivator.php';
	Random_quote_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_random_quote' );
register_deactivation_hook( __FILE__, 'deactivate_random_quote' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-random_quote.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_random_quote() {

	$plugin = new Random_quote();
	$plugin->run();

}
global $wpdb;
global $db;

add_action( 'wp_enqueue_scripts', 'prefix_add_my_stylesheet' );

/**
 * Enqueue plugin style-file
 */
function prefix_add_my_stylesheet() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'prefix-style', plugins_url('quote_style.css', __FILE__) );
    wp_enqueue_style( 'prefix-style' );
}

function wpfstop_change_default_title( $title ){
    $screen = get_current_screen();
    if ( 'quote' == $screen->post_type ){
        $title = 'Author';
    }
    return $title;
}
add_filter( 'enter_title_here', 'wpfstop_change_default_title' );

///////////////////////////settings page//////////////////////////////////////

function plugin_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=RandQuot">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );
add_action( 'admin_menu', 'my_plugin_menu' );
function my_plugin_menu() {
	add_options_page( 'My Plugin Options', 'Random Quote', 'manage_options', 'RandQuot', 'my_plugin_options' );
}
function my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	require plugin_dir_path( __FILE__ ) . 'rqconf.php';
}

/////////////////////////////////////////////////////////////////////////////////

add_action( 'init', 'randomQuotes' );

function randomQuotes() {

register_post_type( 'quote', array(
  'labels' => array(
    'name' => 'List of quotes',
    'singular_name' => 'quotation2',
		'add_new_item' => 'Add new citie',
		'add_new' => 'Add new citie',
   ),
  'description' => 'quotation22.',
  'public' => true,
  'menu_position' => 20,
  'supports' => array( 'title', 'editor', 'custom-fields' )
));
}

$args = array(
    'post_type' => 'quote',
    'post_status'   => 'publish',
    'orderby' => 'data',
    'order'   => 'asc',
    'posts_per_page' => -1,
);

class class_random_quote extends WP_Widget {

	function __construct() {
		parent::__construct(

		'random_quote',

		__('Random quote', 'random_quote'),


		array( 'description' => __( 'Random quote widget - one day one cities from list of quotes in admin area', 'random_quote' ), )
		);
	}

	public function widget( $args, $instance ) {
		global $wpdb;
		global $db;
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];


$option = get_option( 'todayCiteOption' );
if ($option=='d') {
require plugin_dir_path( __FILE__ ) . 'oneDay.php';	// code...
} else {
require plugin_dir_path( __FILE__ ) . 'oneVisit.php';
}

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = '';
		}

		?>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input 	class="widefat"
					id="<?php echo $this->get_field_id( 'title' ); ?>"
					name="<?php echo $this->get_field_name( 'title' ); ?>"
					type="text" value="<?php echo esc_attr( $title ); ?>"
			/>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}


function init_widget() {
	register_widget( 'class_random_quote' );
}
add_action( 'widgets_init', 'init_widget' );



run_random_quote();
