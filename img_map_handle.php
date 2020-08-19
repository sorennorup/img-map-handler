<?php
/*
    Plugin Name: didaktik
    Plugin URI: 
    Description: Didaktik
    Author: Soren Norup
    Version: 1.0
    Author URI: EUK
*/

    // *******Puts the css file in the wp_header************* //
    
include("img_map_handle_admin.php");
    
function didaktik_styles() {
    wp_register_style('img_map_handler', plugins_url( 'wp-image-map-handler/css/style.css'), array(), '1.0', 'all' );
    wp_enqueue_style( 'img_map_handler');
    wp_enqueue_script( 'jequery_script', plugins_url('wp-image-map-handler/js/jquery.rwdImageMaps.min.js'),array('jquery'), '1.0', 'all');
    wp_enqueue_script( 'script', plugins_url('wp-image-map-handler/js/img_map_handler.js'),array('jquery'), '1.0', 'all');
    wp_enqueue_script( 'hilight_script', plugins_url('wp-image-map-handler/js/maphilight.js'),array('jquery'), '1.0', 'all');
    wp_enqueue_style( 'prefix-font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.1/css/font-awesome.min.css', array(), '4.6.1' );
}

function create_posts() {
    $emner = array(
        'Evalueringer',
        'Den unges meddesign',
        'Ungeprofil plan og mål',
        'Delmål og aktiviteter',
        'Fagprofessionellle metoder',
        'Ledelsesansvar',
        'Ungeinddragelse',
        'Afklaring af tilgange',
        'Afdækning af ressourcer',
        'Fagprofessionelle roller',
        'Ungeprogression',
        'Kontaktperson\+',
        'Kædeansvar'
    );

    for( $i = 0; $i < count($emner); $i++ ) { 
        $args = array(
            'post_title'    => $didaktik_emner[$i],
            'post_type'     => 'project',
            'post_status'   => 'publish',
            'post_content'  => '<p>Tekst om'.$didaktik_emner[$i].'</p>'
        );
        //If posttitle does not exist
    wp_insert_post( $args );
    }
}

function getIdsOffPosts() {
    $id_arr = array();
     $args = array(
         'post_type'     => 'project',
         'numberposts' => -1,
     );
     $all_posts = get_posts( $args) ;
     foreach($all_posts as $my_post) {
        array_push($id_arr,$my_post->ID);
     }
    return $id_arr;
}   

add_action('init','getIdsOffPosts');
register_activation_hook( __FILE__, 'create_posts' );

function add_didaktik_model() { 
    $id_array = getIdsOffPosts();
    
    $html = '
    <div id = "overlay">
        <div id = text-wrapper>
        </div>
    </div>';
    $html.= 
    '<img id = "image-dimension" class = "src-image" src = "'.plugin_dir_url(__FILE__).'/img/Forløbsdidaktik0.1.0.png" usemap="#image-map"/>';
    
    $html .= '
    <map name="image-map">
    <area class = "area-content" id = '.$id_array[12].' target="" alt="evalueringer" title="evalueringer" href="https://uudanmark.dk" coords="464,130,284,228" shape="rect">

    <area class = "area-content" id = '.$id_array[11].' target="" alt="den unges meddesign" title="den unges meddesign" href="http://toolbox.test/kontaktperson/" coords="640,71,500,161" shape="rect">

    <area class = "area-content" id = '.$id_array[10].' target="" alt="ungeprofil plan og maal" title="ungeprofil plan og maal" href="" coords="680,136,846,225" shape="rect">

    <area class = "area-content" id = '.$id_array[9].' target="" alt="delmaal og aktiviteter" title="delmaal og aktiviteter" href="" coords="790,259,938,337" shape="rect">

    <area class = "area-content" id = '.$id_array[8].' target="" alt="Fagprofessionellle metoder" title="Fagprofessionellle metoder" href="" coords="200,257,465,331" shape="rect">

    <area class = "area-content" id = '.$id_array[7].' target="" alt="ledelsesansvar" title="ledelsesansvar" href="" coords="409,683,198,632" shape="rect">

    <area class = "area-content" id = '.$id_array[6].' target="" alt="ungeinddragelse" title="ungeinddragelse" href="" coords="252,733,470,777" shape="rect">

    <area class = "area-content" id = '.$id_array[5].' target="" alt="afklaring af tilgange" title="afklaring af tilgange" href="" coords="739,625,902,710" shape="rect">

    <area class = "area-content" id = '.$id_array[4].' target="" alt="afdaekning af ressourcer" title="afdaekning af ressourcer" href="" coords="660,723,844,822" shape="rect">

    <area class = "area-content" id = '.$id_array[3].' target="" alt="fagprofessionelle roller" title="fagprofessionelle roller" href="" coords="440,825,678,907" shape="rect">

    <area class = "area-content" id = '.$id_array[2].' target="" alt="ungeprogression" title="ungeprogression" href="" coords="359,343,752,414" shape="rect">

    <area class = "area-content" id = '.$id_array[1].' alt="kontaktperson+" title="kontaktpreson+" href="" coords="124,666,59,290" shape="rect">

    <area class = "area-content" id = '.$id_array[0].' alt="kædeansvar" title="kædeansvar" href="" coords="710,631,424,570" shape="rect">


</map>';

    return $html;
 }

add_shortcode('diaktik_model','add_didaktik_model');
//ajax functionallity
add_action( 'wp_ajax_my_action', 'my_action' );
add_action( 'wp_ajax_nopriv_my_action', 'my_action' );
add_action( 'wp_enqueue_scripts', 'didaktik_styles' );

function my_action() {
     // Query Arguments
     global $post;
     $post_id = $_REQUEST['post_id'];
    
     echo '<div class = "subject-title">'.get_post_field('post_title',$post_id).'</div><br/>'.get_post_field('post_content', $post_id);
     exit; // exit ajax call(or it will return useless information to the response)
 }
?>