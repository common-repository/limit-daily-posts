<?php
/*
Plugin Name: Limit Daily Posts
Description: Limit number of daily posts, useful specially when you are using any bot plugin to publish posts automatically (auto blog)
Version: 1.0.2
Author: Mihir Dhandha
License: GPL2
Author URI: http://www.mihir.info
Plugin URI: http://www.mihir.info/limit-daily-posts
*/

/*  Copyright 2010 Mihir Dhandha  (email : info@mihir.info)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


function LimitPosts($PostID)
{
	global $wpdb;
	$dailylimit = get_option('lp_num_limit');
	
	$date = date('Y-m-d');

	if(get_option('lp_per_author')==1)
	{
		global $current_user;
		get_currentuserinfo();
		$query = "SELECT count(*) FROM wp_posts WHERE post_status = 'publish' AND post_type = 'post' AND
		CAST(post_date as date) = '$date' AND post_author=$current_user->ID";
	}
	else
	{
		//$tdc = get_post_field ('post_date_gmt', $PostID);
		$query = "SELECT count(*) FROM wp_posts WHERE post_status = 'publish' AND post_type = 'post' AND
		CAST(post_date as date) = '$date'";
	}

	$tcount = $wpdb->get_var($wpdb->prepare($query));


	if ($tcount > $dailylimit)
	{
		if (is_min_wp('2.9'))
		{
			$forcedelete_val = get_option('lp_force_delete');
			wp_delete_post($PostID,$forcedelete_val);
		}
		else
		{
			wp_delete_post($PostID); 
		}
	}

}

function LimitPostsAdminMenu()
{
	add_options_page('Limit Daily Posts', 'Limit Daily Posts',9, 'LimitPostOptions', 'LimitPostOptions');
}

function LimitPostOptions()
{
  // variables for the field and option names 
    $numlimit = 'lp_num_limit';
	$perauthor = 'lp_per_author';
	$forcedelete = 'lp_force_delete';
    $hidden_field_name = 'lp_submit_hidden';
    $numlimit_data = 'lp_num_limit';
	$forcedelete_data = 'lp_force_delete';
	$perauthor_data = 'lp_per_author';

    // Read in existing option value from database
    $numlimit_val = get_option( $numlimit );
	$perauthor_val = get_option( $perauthor );
	$forcedelete_val = get_option( $forcedelete );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $numlimit_val = $_POST[ $numlimit_data ];
		$forcedelete_val = $_POST[ $forcedelete_data ];
		$perauthor_val = $_POST[ $perauthor_data ];

        // Save the posted value in the database
        update_option( $numlimit, $numlimit_val );
		update_option( $forcedelete,$forcedelete_val );
		update_option( $perauthor,$perauthor_val );

        // Put an options updated message on the screen

	?>
	<div class="updated"><p><strong><?php _e("Options saved.", 'lp_trans_domain' ); ?></strong></p></div>
	<?php

		}

		// Now display the options editing screen

		echo '<div class="wrap">';

		// header

		echo "<h2>" . __( 'Limit Daily Posts Options', 'lp_trans_domain' ) . "</h2>";

		// options form
		
		?>

	<form name="form1" method="post" action="">
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

	<p><?php _e("Daily Post Limit:", 'lp_trans_domain' ); ?> 
	<input type="text" name="<?php echo $numlimit_data; ?>" value="<?php echo $numlimit_val; ?>" size="20">
	</p>

	<p><?php _e("Force Delete:", 'lp_trans_domain' ); ?> 
	<input type="checkbox" name="<?php echo $forcedelete_data; ?>" value="1" <?php if($forcedelete_val==1) echo "checked"; ?>> (Delete without moving to trash, only for WP 2.9+)
	</p>
	
	<p><?php _e("Limit Per Author:", 'lp_trans_domain' ); ?> 
	<input type="checkbox" name="<?php echo $perauthor_data; ?>" value="1" <?php if($perauthor_val==1) echo "checked"; ?>> (If checked, post count will be counted seperated for each author/user.)
	</p><hr />

	<p class="submit">
	<input type="submit" name="Submit" value="<?php _e('Update Options', 'lp_trans_domain' ) ?>" />
	</p>

	</form>
	</div>

	<?php

}
function is_min_wp($version)
{
	return version_compare(	$GLOBALS['wp_version'],$version. 'alpha','>=');
}
function LimitPostActivate()
{
	add_option('lp_num_limit','2');
	add_option('lp_force_delete','1');
	add_option('lp_per_author','1');
}
//define('lp_num_limit', '2');
//define('lp_force_delete','1');
register_activation_hook( __FILE__, 'LimitPostActivate' );
add_action ('admin_menu', 'LimitPostsAdminMenu');
add_action ('publish_post', 'LimitPosts');
?>