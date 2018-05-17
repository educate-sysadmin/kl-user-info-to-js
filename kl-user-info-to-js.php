<?php
/*
Plugin Name: KL User Info to JS
Plugin URI: https://github.com/educate-sysadmin/kl-user-info-to-js
Description: Wordpress plugin to populate JavaScript variables with user, roles
Version: 0.2
Author: b.cunningham@ucl.ac.uk
Author URI: https://educate.london
License: GPL2
*/

function kl_user_info_to_js() {
    echo '<script id = "kl_user_info_to_js">'."\n";;
    // get
    $user;
    $roles = array();
    //$groups = array(); // todo?
    if (!is_user_logged_in()) {
        $user = 'Visitor';
        $roles[] = 'visitor';
    } else {
        // roles
        $user_object = wp_get_current_user();
        $user = $user_object->user_login;
        foreach ($user_object->roles as $role) {
            $roles[] = $role;
        }
    }
    // output
    // user
    echo 'var kl_user = "'.$user.'";'."\n";    
    // roles
    $roles_output = 'var kl_user_roles = [';    
    foreach ($roles as $role) {
       $roles_output .= '"'.$role.'"'.',';
    }
    if (substr($roles_output,strlen($roles_output)-1) == ',') {
        $roles_output = substr($roles_output,0,strlen($roles_output)-1); // remove final comma
    }
    $roles_output .= '];';
    echo $roles_output."\n"; 
    // groups
    
    echo '</script>'."\n";
}
add_action('wp_head','kl_user_info_to_js');
add_action('admin_head','kl_user_info_to_js');
