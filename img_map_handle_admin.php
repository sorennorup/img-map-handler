<?php
    //*********** ADDS PLUGIN ADMINPAGE THE ADMIN MENU***********//
    
function test_plugin_setup_menu(){
        add_menu_page( 'Display Projects Setup', 'Display projects', 'manage_options', 'Projects', 'plugin_options_page' );
}
 
//*********** display the admin options page*********//
function plugin_options_page() {
    ?>
	<div>
    <h2>My custom plugin</h2>
    Options relating to the Custom Plugin.
    <form action="options.php" method="post">
    	<?php settings_fields('plugin_options'); ?>
        <?php do_settings_sections('plugin'); ?>
        <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
	</div>
	<?php
}

function plugin_admin_init(){
    register_setting( 'plugin_options', 'plugin_options', 'plugin_options_validate' );
    add_settings_section('plugin_main', 'Main Settings', 'plugin_section_text', 'plugin');
    add_settings_field('plugin_text_string', 'Plugin Text Input', 'plugin_setting_string', 'plugin', 'plugin_main');
}

function plugin_setting_string() {
    $options = get_option('plugin_options');
    echo "<input id='plugin_text_string' name='plugin_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
} 

function plugin_section_text() {
    echo '<p>Main description of this section here.</p>';
} 

function plugin_options_validate($input) {
    $newinput['text_string'] = trim($input['text_string']);
    if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
     $newinput['text_string'] = '';
}
    return $newinput;
}

function custom_post_type() {

	$labels = array(
		'name'                => _x( 'Didaktik', 'Post Type General Name', 'pro' ),
		'singular_name'       => _x( 'didaktikemne', 'Post Type Singular Name', 'pro' ),
		'menu_name'           => __( 'Didaktik emner', 'pro' ),
		'parent_item_colon'   => __( 'Parent Item:', 'pro' ),
		'all_items'           => __( 'All Emner', 'pro' ),
		'view_item'           => __( 'Se didaktikemne', 'pro' ),
		'add_new_item'        => __( 'Tilføj nyt emne', 'pro' ),
		'add_new'             => __( 'Tilføj nyt', 'pro' ),
		'edit_item'           => __( 'Rediger emne', 'pro' ),
		'update_item'         => __( 'Opdater emne ', 'pro' ),
		'search_items'        => __( 'Search efter emner', 'pro' ),
		'not_found'           => __( 'Ikke fundet', 'pro' ),
		'not_found_in_trash'  => __( 'Ikke fundet i emner', 'pro' ),
	);
	$args = array(
		'label'               => __( 'Didaktik emne' ),
		'description'         => __( 'Et nyt emne til didaktisk forløb', 'pro' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail'),
		'taxonomies'          => array( 'didaktik_category' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'show_in_rest' => true, // turns on the new blockeditor
		'supports' => array('title','editor') //  turns on the new blockeditor
	);
	register_post_type( 'project', $args );
	flush_rewrite_rules();    // Fixes the permalink bug for custom posts
	
	 // "project Categories" Custom Taxonomy
    $labels = array(
        'name' => __( 'Didaktik Categories', 'taxonomy general name' ),
        'singular_name' => __( 'didaktik Category', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Didkatik Categories' ),
    	'all_items' => __( 'All Didkatik Categories' ),
        'parent_item' => __( 'Parent Didaktik Category' ),
        'parent_item_colon' => __( 'Parent Didaktik Category:' ),
        'edit_item' => __( 'Edit Didaktik Category' ),
        'update_item' => __( 'Update Didaktik Category' ),
        'add_new_item' => __( 'Add New Didaktik Category' ),
        'new_item_name' => __( 'New Didaktik Category Name' ),
        'menu_name' => __( 'Didaktik Categories')
    );

    $args = array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column'   => false,
                'query_var' => true,
				'rewrite' => array( 'slug' => 'project-category' ),
				
    );

    register_taxonomy( 'didaktik-category', array( 'didaktik' ), $args );
}

add_action('admin_init', 'plugin_admin_init');
  //******CREATES A CUSTOM POST TEMPLATE
add_action( 'init', 'custom_post_type' );

?>