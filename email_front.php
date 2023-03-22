<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://rohanray.com
 * @since             1.0.0
 * @package           Email_front
 *
 * @wordpress-plugin
 * Plugin Name:       email_front
 * Plugin URI:        https://email_front.com
 * Description:       Email for forntend
 * Version:           1.0.0
 * Author:            Rohan Ray
 * Author URI:        https://rohanray.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       email_front
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EMAIL_FRONT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-email_front-activator.php
 */
function activate_email_front() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-email_front-activator.php';
	Email_front_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-email_front-deactivator.php
 */
function deactivate_email_front() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-email_front-deactivator.php';
	Email_front_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_email_front' );
register_deactivation_hook( __FILE__, 'deactivate_email_front' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-email_front.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

//  function enqueu_scripts()
//  {
// 	wp_enqueue_script('em_ajax', plugin_dir_url(__FILE__).'ajax.js', 'jQuery', 1.0, false);
// 	wp_localize_script('em_ajax', 'em_ajax_url', array(
// 		'ajax_url' => admin_url('admin-ajax.php')
// 	));
//  }

//  add_action('wp_enqueue_scripts', 'enqueu_scripts');



 function email_frontend()
 {  

	add_menu_page('email_front', 'email_subscribe', 'manage_options', 'email_front', 'email_front_cb');

 }

 add_action('admin_menu', 'email_frontend');


 function email_front_cb()
 {
   ?>
   
   <div class="input_form">
	<form  method="post">
      <?php
	  settings_fields('email_front');
	 do_settings_sections('email_front');
	
	  submit_button('Subscribe');
	  ?>




	 
	  


	</form>
 </div>
<?php

if(isset($_POST['email']))
{
	$email=$_POST['email'];
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		
      if(isset($_POST['submit']))
	  {
		$new_emails=get_option('new_emails');

		if(!$new_emails)
		{
			$new_emails=array();
		}


		if(in_array($email,$new_emails))
		{
			echo '<script>alert("Hey Folk you are all ready subscribed!");</script>';
		}
		else{
			$new_emails[]=$email;
			update_option('new_emails', $new_emails);

			echo '<script>alert("Hooray Subcribed Successfully!");</script>';
		}
	  }

	} 
}

 }


 function callback()
 {
	email_front_cb();
	if(isset($_POST['email']))
	{
	  echo "helo";
	}


	

 }

 add_action('wp_head','callback');

 


 function email_register_settings()
 {
	
	register_setting('email_front', 'email_id');
	add_settings_section('email_front_section', "Email_id_section", 'email_section_cb', 'email_front');
	add_settings_field('email_id_label', 'Email Id', 'email_label_cb', 'email_front','email_front_section');
	
 }

 add_action('admin_init', 'email_register_settings');

 function email_section_cb()
 {
	echo"<p>Enter your email for subscrption</p>";
 }


 function email_label_cb()
 {
	$setting = get_option('email_id');
	// output the field
	?>
	<label for="email_id"></label>
	<input type="email" name="email" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <?php
 }


 

















function run_email_front() {

	$plugin = new Email_front();
	$plugin->run();

}
run_email_front();
