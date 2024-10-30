<?php
/**
 * Plugin Name: Lemonade Stand Schedulable Call Out Bar
 * Plugin URI: 
 * Description: A Delicious Call Out Bar For Your Visitors to Devour
 * Version: 1.0.0
 * Author: pugly
 * Author URI:
 */

function lemonadestand_create_menu() {
	add_menu_page('Lemonade Stand', 'Lemonade Stand', 'administrator', __FILE__, 'lemonadestand_settings_page' , 'dashicons-palmtree', 10);
	add_action( 'admin_init', 'register_lemonadestand_settings' );
}
add_action('admin_menu', 'lemonadestand_create_menu');

function lemonadestand_front_enqueue() {
	wp_register_script( 'lemonadestand-front-script', plugin_dir_url( __FILE__ ) . '/js/frontend.js', array('jquery'), '3.5.1', true );
	wp_enqueue_script( 'lemonadestand-front-script' );
	
    wp_register_style( 'lemonadestand-front-styles', plugin_dir_url( __FILE__ ) . '/css/styles.css' );
	wp_enqueue_style( 'lemonadestand-front-styles' );
}
add_action( 'wp_enqueue_scripts', 'lemonadestand_front_enqueue' );

function lemonadestand_admin_enqueue() {
	wp_register_script( 'lemonadestand-admin-script', plugin_dir_url( __FILE__ ) . '/js/admin.js', array('jquery'), '3.5.1', true );
	wp_enqueue_script( 'lemonadestand-admin-script' );
	
    wp_register_style( 'lemonadestand-admin-stylesheet', plugin_dir_url( __FILE__ ) . '/css/styles.css' );
	wp_enqueue_style( 'lemonadestand-admin-stylesheet' );
}
add_action( 'admin_enqueue_scripts', 'lemonadestand_admin_enqueue' );

function lemonadestand_load_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'lemonadestand_load_media_files' );

function register_lemonadestand_settings() {
	register_setting( 'lemonadestand-settings-group', 'lemonadestand-code');
}

function lemonadestand_settings_page() {
?>
<div class="lemonadestand-main" style="opacity:0.2;">
	<form method="post" action="options.php">
		<?php settings_fields( 'lemonadestand-settings-group' ); ?>
		<?php do_settings_sections( 'lemonadestand-settings-group' ); ?>
		<textarea class="lemonadestand-code" style="display: none;" name="lemonadestand-code">
			<?php $lemonadestand_allowed_html = array(
				'div' => array(
					'class' => array(),
					'style' => array(),
					'data-url' => array()
				),
				'img' => array(
					'class' => array(),
					'style' => array(),
					'src' => array()
				)
			);
			$lscode = get_option('lemonadestand-code');
			echo wp_kses($lscode, $lemonadestand_allowed_html ); ?>
		</textarea>
<div class="lemonadestand-full">
	<div class="lemonadestand-board"></div>
	<div class="lemonadestand-tools">
		<div class="lemonadestand-insertimage button button-secondary" style="width:48%;">+ Image</div>
		<div class="lemonadestand-insertclipart button button-secondary" style="width:48%;">+ Clipart</div>
		<input class="lemonadestand-directory" style="display: none;" value="<?php echo plugin_dir_url( __FILE__ ); ?>">
		<hr>
		<label>Color Sets</label>
		<select class="lemonadestand-control lemonadestand-control-background" data-name="LSBACKGROUND">
			<option value="lemonadestand-backgroundcolor1">Tint Solid</option>
			<option value="lemonadestand-backgroundcolor2">Tint Gradient</option>
			<option value="lemonadestand-backgroundcolor9">Analogous Solid</option>
			<option value="lemonadestand-backgroundcolor10">Analogous Gradient</option>
			<option value="lemonadestand-backgroundcolor5">Complimentary Solid</option>
			<option value="lemonadestand-backgroundcolor6">Complimentary Gradient</option>
			<option value="lemonadestand-backgroundcolor3">Groovy Solid</option>
			<option value="lemonadestand-backgroundcolor4">Groovy Gradient</option>
			<option value="lemonadestand-backgroundcolor7">Dark Solid</option>
			<option value="lemonadestand-backgroundcolor8">Dark Gradient</option>
			<option value="lemonadestand-backgroundcolor11">Light Solid</option>
			<option value="lemonadestand-backgroundcolor12">Light Gradient</option>
		</select>
		<input class="lemonadestand-control lemonadestand-control-hue" type="range" min="0" max="360" step="18" data-name="LSHUE">
		<hr>
		<label>Image Animation</label>
		<select class="lemonadestand-control lemonadestand-control-animation" data-name="LSANIMATION">
			<option value="lemonadestand-noanimation">No Animation</option>
			<option value="lemonadestand-rotating">Rotate</option>
			<option value="lemonadestand-wobble">Wobble</option>
		</select>
		<label>Button Style</label>
		<select class="lemonadestand-control lemonadestand-control-radius" data-name="LSRADIUS">
			<option value="lemonadestand-norounding">Sharp Edges</option>
			<option value="lemonadestand-halfrounding">Half Rounding</option>
			<option value="lemonadestand-fullrounding">Rounded</option>
			<option value="lemonadestand-tilted">Tilted</option>
		</select>
		<hr>
		<label>Call Out</label>
		<textarea class="lemonadestand-control lemonadestand-control-subheader" data-name="LSSUBHEADER"></textarea>
		<label>Button Text</label>
		<input class="lemonadestand-control lemonadestand-control-solidbutton" data-name="LSBUTTONTEXT">
		<label>Button Link</label>
		<input class="lemonadestand-control lemonadestand-control-url" data-name="LSURL">
		<hr>
		<button class="lemonadestand-done button button-primary" id="submit">Done Editing</button>
		<button class="lemonadestand-delete button button-secondary" id="submit">Delete Bar</button>
	</div>
	<div class="lemonadestand-gallery"></div>
	<div class="lemonadestand-scheduler">
		<input class="lemonadestand-control-date" type="date">
		<div class="lemonadestand-insertdate button button-secondary">Schedule Date</div>
		<div class="lemonadestand-scheduleitems"></div>
		<div class="lemonadestand-deletedate button button-secondary" style="opacity:0.2;">Delete Date</div>
	</div>
</div>
<div class="lemonadestand-mobilemessage">Please use a larger screen to use the editor.</div>	
<button class="lemonadestand-insertbutton button button-primary" id="submit">Insert New Bar</button>

<div class="lemonadestand-container">
	<?php $lemonadestand_allowed_html = array(
		'div' => array(
			'class' => array(),
			'style' => array(),
			'data-url' => array()
		),
		'img' => array(
			'class' => array(),
			'style' => array(),
			'src' => array()
		)
	);
	$lscode = get_option('lemonadestand-code');
	echo wp_kses($lscode, $lemonadestand_allowed_html ); ?>
</div>
<div class="lemonadestand-insert">
	<div class="lemonadestand-box lemonadestand-notactive">
		<div class="lemonadestand-edit button button-secondary">Edit</div>
		<div class="lemonadestand-boxcontainer lemonadestand-backgroundcolor4 lemonadestand-norounding lemonadestand-noanimation lemonadestand-hue324" data-url="">
			<div class="lemonadestand-column lemonadestand-imagepanel">
				<img class="lemonadestand-imagebox" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/clipart40.png'; ?>">
			</div>
			<div class="lemonadestand-column">
				<div class="lemonadestand-subheader">Call Out Goes Here</div>
			</div>
			<div class="lemonadestand-column lemonadestand-buttonpanel">
				<div class="lemonadestand-solidbutton">Click Here</div>
			</div>
		</div>
		<div class="lemonadestand-data"><div class="LSBACKGROUND">lemonadestand-backgroundcolor4</div><div class="LSRADIUS">lemonadestand-norounding</div><div class="LSANIMATION">lemonadestand-noanimation</div><div class="LSHUE">324</div><div class="LSURL"></div><div class="LSSUBHEADER">Call Out Goes Here</div><div class="LSBUTTONTEXT">Click Here</div></div><div class="lemonadestand-schedule"></div>
	</div>
</div>
	</form>
</div>
<?php }
function lemonadestand_header() {
	$lemonadestand_allowed_html = array(
		'div' => array(
			'class' => array(),
			'style' => array(),
			'data-url' => array()
		),
		'img' => array(
			'class' => array(),
			'style' => array(),
			'src' => array()
		)
	);
	$lscode = get_option('lemonadestand-code');
	echo '<div class="lemonadestand-frontend">'.wp_kses($lscode, $lemonadestand_allowed_html ).'</div>';
}
add_action('wp_head', 'lemonadestand_header');
?>