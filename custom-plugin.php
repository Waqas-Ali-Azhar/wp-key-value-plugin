<?php
/**
 * Plugin Name:       My Custom Plugin
 * Plugin URI:        https://waqasali.pro/custom-plugin
 * Description:       This is a custom plugin to learn WordPress plugin development
 * Version:           1.0
 * Requires at least: 4.8
 * Requires PHP:      5.6
 * Author:            Waqas Ali
 * Author URI:        https://waqasali.pro
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */


define("PLUGIN_PATH",plugin_dir_path(__FILE__));
define("PLUGIN_URL",plugin_dir_url(__FILE__));


// Code to enter data into db
if(!empty($_POST)){
  global $wpdb;
  if(!empty($_GET['page']) and $_GET['page'] == 'add_enteries'){
        $wpdb->insert(
            "wp_listings",
            array(
              'name' => $_POST['key'],
              'value' => $_POST['value']
            )
        );

        

  }
  elseif($_GET['page'] == "all_enteries" and !empty($_GET["edit"]) ){
    $updated = $wpdb->update(
        'wp_listings',
        array(
          'name' => $_POST["key"],
          'value' => $_POST['value']
        ),
        array(
          'id' => $_GET['edit']
        )
    );


  }

  header('Location: '.admin_url( '/admin.php?page=all_enteries' ));
  exit;
}
else{

}


// Activation Callback
function my_plugin_activate() {

  global $wpdb;


  $charset_collate = $wpdb->get_charset_collate();
  $table_name = "wp_listings";

  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    time datetime DEFAULT current_timestamp NOT NULL,
    name varchar(255) NOT NULL,
    value varchar(255) NULL,
    PRIMARY KEY  (id)
  ) $charset_collate;";



  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  /* activation code here */
}
// Activation Hook

register_activation_hook( __FILE__, 'my_plugin_activate' );






// Deactivation Callback
function myplugin_deactivate(){

  add_option('Plugins Deactivated','Custom Plugin');

}

// Deactivation Hook
register_deactivation_hook( __FILE__, 'myplugin_deactivate' );





// function myplugin_save_post($content){

//   if(!empty($content)){
//     $content.=' '.date("j-n-y");
//   }
  
//   return $content;
// }




//add_filter('content_save_pre','myplugin_save_post',10,1);



// Menus 
function custom_plugin_admin_menu(){

  add_menu_page(
    'Custom Plugin',
    'Custom Plugin',
    'manage_options',
    'custom_plugin_slug',
    'custom_plugin_callback_function_main'
);


  add_submenu_page( 'custom_plugin_slug',
    'All Enteries',
    'All Enteries',
    'manage_options',
    'all_enteries',
    'custom_plugin_callback_all_enteries'
     );


  add_submenu_page( 'custom_plugin_slug',
    'New Entery',
    'Add New Entry',
    'manage_options',
    'add_enteries',
    'custom_plugin_callback_add_enteries'
  );

}


// Callback for Insert page
function custom_plugin_callback_add_enteries(){

  include 'admin/templates/add_entry.php';  

}



// Callback for all listings

function custom_plugin_callback_all_enteries(){


  if(!empty($_GET['page']) and $_GET['page'] == 'all_enteries' ){
   global $wpdb;

    if(!empty($_GET['edit'])){
      
      $row_number = $_GET['edit'];

      

      $entry = $wpdb->get_results("
      SELECT * from wp_listings where id = $row_number
        ");

      include 'admin/templates/edit_entry.php'; 
    
    }

    else{

      if($_GET['delete']){
        $row_number = $_GET['delete'];

        $deleted = $wpdb->delete(
          'wp_listings',
          array(
            'id' => $row_number
          )
        );
      } 
        

        $enteries = $wpdb->get_results("
            SELECT * from wp_listings
          ");

        include 'admin/templates/all_enteries.php';  

    }

  }

}


// Callback for Main Menu

function custom_plugin_callback_function_main(){
  ?>
   <div class="container">
      <div class="row">
        <h1> Custom Plugin</h1>
      </div>

      <div class="">
        <p>
          This is a WordPress Custom Plugin Callback Page and it is showing a paragraph.
        </p>
      </div>
   </div>
  <?php
}


// Menu Hook
add_action('admin_menu','custom_plugin_admin_menu');



// Styling
function wpdocs_theme_name_scripts() {


    wp_enqueue_style( 'custom-plugin', PLUGIN_URL.'admin/css/style.css');

    wp_enqueue_script( 'custom-plugin', PLUGIN_URL.'admin/js/script.js');
    
}
add_action( 'admin_enqueue_scripts', 'wpdocs_theme_name_scripts' );





// Customizing Job Listings plugin
function custom_plugin_single_job_listing_start(){

        remove_action('sjb_single_job_listing_start','sjb_job_listing_meta_display',20);
        
        get_simple_job_board_template('single-jobpost/job-features.php', array());

        get_simple_job_board_template('single-jobpost/content-single-job-listing-meta.php', array());

        

}


add_action('sjb_single_job_listing_start','custom_plugin_single_job_listing_start',15);


function custom_plugin_job_listing_features(){

        remove_action('sjb_single_job_listing_end','sjb_job_listing_features',20);
        
        

        

}

add_action('sjb_single_job_listing_end', 'custom_plugin_job_listing_features', 19);