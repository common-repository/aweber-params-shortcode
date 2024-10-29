<?php
/*
Plugin Name: Aweber Params Shortcode - Schogini
Plugin Script: awber_params.php
Plugin URI: http://sree.cc/plugins/aweber_params.zip
Description: You can use these shortcodes:
[awber_params] will embed the name parameter
[awber_params email="1"] will embed the email parameter

1. Install and activate the plugin
2. Admin->Settings->Schogini Aweber Params-> enter the page as given in the examples
3. Activate parameter passing in Aweber form advanced settings
4. Use shortcodes [awber_params], [awber_params email="1"] in your blog or page (in text mode)

Version: 1.4
License: GPL
Author: Sreeprakash Neelakantan
Author URI: http://sree.cc

=== RELEASE NOTES ===
2013-03-18 - v1.4 - Decoded .
2013-03-17 - v1.3 - typo correction
2013-03-17 - v1.2 - added admin interface to save values to .htaccess
2013-03-16 - v1.1 - second version
2013-03-15 - v1.0 - first version
*/

/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
Online: http://www.gnu.org/licenses/gpl.txt
*/
$AWVersion = 1.4;
// ------------------
// function_awber_params is the hook for shortcode
function function_aweber_params($atts){

	extract(shortcode_atts(array(
		'from' => '',
		'email' => '',
	), $atts));
	if($from == '' && $email == '') return str_replace('%20', ' ', htmlentities(mysql_real_escape_string($_GET['fullname'])));
	if ($from) $a .= mysql_real_escape_string($_GET['fullname']);
	if($a != '') {
		if ($email) $a .= '(' . mysql_real_escape_string($_GET['email']) . ')';
	}else{
		if ($email) $a = mysql_real_escape_string($_GET['email']);
	}
	
	return str_replace('%2e', '.', str_replace('%40', '@', str_replace('%20', ' ', htmlentities($a))));
}

add_shortcode('aweber_params','function_aweber_params');

// ------------------
// function_aweber_params_admin is the admin interface section
function function_aweber_params_admin() {  
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	//include_once('aweber_params_admin.php');  

	   if($_POST['awber_params_hidden'] == 'Y') {  
	        //Form data sent  
	        $awber_params_url1 = $_POST['awber_params_url1'];  
	        update_option('awber_params_url1', $awber_params_url1);  

	        $awber_params_url2 = $_POST['awber_params_url2'];  
	        update_option('awber_params_url2', $awber_params_url2);  

	        $awber_params_url3 = $_POST['awber_params_url3'];  
	        update_option('awber_params_url3', $awber_params_url3);  

	        $awber_params_url4 = $_POST['awber_params_url4'];  
	        update_option('awber_params_url4', $awber_params_url4);  

	        $awber_params_url5 = $_POST['awber_params_url5'];  
	        update_option('awber_params_url5', $awber_params_url5);   

			global $wp_rewrite;
			$wp_rewrite->flush_rules(); //writes to .htaccess

	        ?>  
	        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>  
	        <?php  
	    } else {  
	        //Normal page display  
	        $awber_params_url1 = get_option('awber_params_url1');  
	        $awber_params_url2 = get_option('awber_params_url2');  
	        $awber_params_url3 = get_option('awber_params_url3');  
	        $awber_params_url4 = get_option('awber_params_url4');  
	        $awber_params_url5 = get_option('awber_params_url5');   
	?>
	<div class="wrap">  
	    <?php    echo "<h2>" . __( 'Schogini - Aweber Parameter Display', 'aweber_params_hdg' ) . "</h2>"; ?>  

	    <form name="aweber_params_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
	        <input type="hidden" name="awber_params_hidden" value="Y">  
	        <?php    echo "<h4>" . __( 'List of URLs Where Aweber Will Come. (Confirmation, Thank you etc.)', 'awber_params_url1' ) . "</h4>";         		 
		             echo "<h4>" . __( 'If you have only one URL enter just that one and leave the other fields empty.', 'awber_params_url2' ) . "</h4>"; 
	?>  
	    <p><?php _e("URL-1: " ); ?><input type="text" name="awber_params_url1" value="<?php echo $awber_params_url1; ?>" size="40"><?php _e(" ex: confirmation-page/  (if your URL is http://www.domain.com/confirmation-page/)" ); ?></p>  
	   <p><?php _e("URL-2: " ); ?><input type="text" name="awber_params_url2" value="<?php echo $awber_params_url2; ?>" size="40"><?php _e(" ex: confirmation-page/  (if your URL is http://www.domain.com/confirmation-page/)" ); ?></p>  
		<p><?php _e("URL-3: " ); ?><input type="text" name="awber_params_url3" value="<?php echo $awber_params_url3; ?>" size="40"><?php _e(" ex: confirmation-page/  (if your URL is http://www.domain.com/confirmation-page/)" ); ?></p>  
		<p><?php _e("URL-4: " ); ?><input type="text" name="awber_params_url4" value="<?php echo $awber_params_url4; ?>" size="40"><?php _e(" ex: confirmation-page/  (if your URL is http://www.domain.com/confirmation-page/)" ); ?></p>  
		<p><?php _e("URL-5: " ); ?><input type="text" name="awber_params_url5" value="<?php echo $awber_params_url5; ?>" size="40"><?php _e(" ex: confirmation-page/  (if your URL is http://www.domain.com/confirmation-page/)" ); ?></p>  
	        <hr />  
	        <?php    echo "<h3>" . __( 'IMPORTANT: No leading slash', 'aweber_params_important1' ) . "</h3>"; ?>  
	       <?php    echo "<h3>" . __( 'if the URL is http://www.domain.com/confirmation-page.html enter confirmation-page.html', 'aweber_params_important' ) . "</h3>"; ?>  
	 	   <?php    echo "<h3>" . __( 'if the URL is http://www.domain.com/confirmation-page enter confirmation-page', 'aweber_params_important1' ) . "</h3>"; ?>  
		   <?php    echo "<h3>" . __( 'if the URL is http://www.domain.com/confirmation-page/ enter confirmation-page/', 'aweber_params_important2' ) . "</h3>"; ?>  

	        <?php    echo "<h3>" . __( 'Ensure that the values you enter are unique for your Aweber URLs and do not clash
	with anyother folders or pages within your site.', 'aweber_params_important3' ) . "</h3>"; ?>  
	        <?php    echo "<h3>" . __( 'Usage short codes: [awber_params] will embed the name parameter
			[awber_params email="1"] will embed the email parameter', 'aweber_params_important4' ) . "</h3>"; ?>  

	        <?php    echo "<h4>" . __( 'Should you have any suggestions or modifications, please contact <a href="http://sree.cc" target="_blank">Sree</a> at 
		<a href="http://schogini.com" target="_blank">Schogini, Inc.</a>
		', 'aweber_params_sree' ) . "</h4>"; ?>  

	        <p class="submit">  
	        <input type="submit" name="Submit" value="<?php _e('Update Awebr URLs', 'awber_params_urls' ) ?>" />  
	        </p>  
	    </form>  
	</div>
	<?php
	}


}

function function_aweber_params_admin_actions() {  
	add_options_page("Aweber Params", "Aweber Params", 'manage_options', "aweber-params", "function_aweber_params_admin");   
}  

add_action('admin_menu', 'function_aweber_params_admin_actions');

// ------------------
// function_aweber_params_flush_rewrites is the section that writes to .htaccess
//function function_aweber_params_flush_rewrites() { global $wp_rewrite;
//	$wp_rewrite->flush_rules();
//}

function function_aweber_params_add_rewrites( $rules ) {
	$awber_params_url1 = get_option('awber_params_url1');  
	$awber_params_url2 = get_option('awber_params_url2');  
	$awber_params_url3 = get_option('awber_params_url3');  
	$awber_params_url4 = get_option('awber_params_url4');  
	$awber_params_url5 = get_option('awber_params_url5');
	$temp = array();
	if (isset($awber_params_url1) && $awber_params_url1 != '') $temp[$awber_params_url1] = true;
	if (isset($awber_params_url2) && $awber_params_url2 != '') $temp[$awber_params_url2] = true;
	if (isset($awber_params_url3) && $awber_params_url3 != '') $temp[$awber_params_url3] = true;
	if (isset($awber_params_url4) && $awber_params_url4 != '') $temp[$awber_params_url4] = true;
	if (isset($awber_params_url5) && $awber_params_url5 != '') $temp[$awber_params_url5] = true;
	$new_rules = '';
	foreach($temp as $k => $v){
		if (isset($k) && $k != ''){
			$no_leading = preg_replace("/^\//","", $k); //strip leading slash 

			$no_leading_no_trailing = preg_replace("/\/$/","", $no_leading); //strip leading and training slashes in a2
			$a = str_replace('/', '\/', $no_leading_no_trailing); //escape middle slashes
			$new_rules .= <<<EOD
			
RewriteCond %{REQUEST_URI} /$a/
RewriteCond %{QUERY_STRING} (.+?)&name=(.+)
RewriteRule ^$no_leading /$no_leading?%1&fullname=%2 [R,NC,L]

EOD;
		}
	}
	if ($new_rules != ''){
		$temp1 = <<<EOD
\n# BEGIN AWEBER PARAMS SHORTCODE
<IfModule mod_rewrite.c>
RewriteEngine On
EOD;
		$temp2 = <<<EOD
	
</IfModule>
# END AWEBER PARAMS SHORTCODE\n\n
EOD;
		$new_rules = $temp1 . $new_rules . $temp2;
	}
	return $new_rules. $rules;
}
add_filter('mod_rewrite_rules', 'function_aweber_params_add_rewrites');
//NOT NEEDED AS WE ARE SAVING IN THE SETTINGS SUBMIT add_action('admin_init', 'function_aweber_params_add_rewrites');
