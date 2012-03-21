<?php 
/*
Plugin Name: CJ Change Howdy
Plugin URI: http://www.shibulijack.wordpress.com/cj-change-howdy
Version: 3.3.1
Author: Shibu Lijack a.k.a CyberJack
Author URI: http://shibulijack.wordpress.com/
Description: Don't like <strong>Howdy</strong>? Change it to whatever you want. Wordpress <strong>3.3+</strong> compatible!
*/

/*  Copyright 2012 Shibu Lijack (email: shibulijack@gmail.com)

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

if (!function_exists("cjPluginSeriesHowdy_ap")) 
{ 
function cjPluginSeriesHowdy_ap() {
global $cj_pluginSeries_howdy;
if (!isset($cj_pluginSeries_howdy)) {
return; 
}

if (function_exists('add_options_page')) 
{
add_options_page('CJ Change Howdy | Shibu Lijack', 'CJ Change Howdy', 9, basename(__FILE__), array(&$cj_pluginSeries_howdy, 'printAdminPage')); }
} 
}

if (!class_exists("cjPluginSeriesHowdy")) 
{ 
class cjPluginSeriesHowdy 
{
	var $adminOptionsName = "cjPluginSeriesHowdyAdminOptions";
	function cjPluginSeriesHowdy() { 
		} 
	function cjPluginSeriesHowdy_settings_link($links) {
	$links[] = '<a href="'.admin_url('options-general.php?page=cj-change-howdy').'">'.__('Settings', 'CJ Change Howdy').'</a>';
	return $links;
	}
	function cj_rep_howdy($wp_admin_bar) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $cjopt = get_option($this->adminOptionsName);
	$opt_value = $cjopt['howdy_text'];
	if($opt_value==null)
		$opt_value="Welcome";
    $newtitle = str_replace( 'Howdy,', $opt_value, $my_account->title );            
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
    ) );
	}
	function getAdminOptions() {
	$cjAdminOptions = array('howdy_text' => '');
	$cjOptions = get_option($this->adminOptionsName); 
	if (!empty($cjOptions)) {
	foreach ($cjOptions as $key => $option) $cjAdminOptions[$key] = $option;
	}
	update_option($this->adminOptionsName, $cjAdminOptions); return $cjAdminOptions;
	}
	
	function init() { $this->getAdminOptions();
	}
	
	function printAdminPage() {
	$cjOptions = $this->getAdminOptions();
	if (isset($_POST['update_cjPluginSeriesHowdySettings'])) 
	{ 
	if (isset($_POST['cjHowdy'])) { $cjOptions['howdy_text'] = $_POST['cjHowdy']; }
	update_option($this->adminOptionsName, $cjOptions);
	?>
	<div class="updated"><p><strong><?php _e("Settings Updated.","cjPluginSeriesHowdy");?></strong></p></div>
	<?php } ?>
<div class=wrap>
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<?php screen_icon( 'plugins' ); ?><h2>CJ Change Howdy</h2>
<br><a href="http://shibulijack.wordpress.com/2012/02/03/cj-change-howdy/" target="_blank" class="button-secondary">Visit Plugin Page</a> <a href="https://www.facebook.com/shibu.lijack" target="_blank" class="button-secondary">Facebook</a><br>
<br>Plugin developed by <a href="mailto:shibulijack@gmail.com">Shibu Lijack</a></br>
<br>
<strong>Custom Howdy text:</strong> <input type="text" name="cjHowdy" size="20" value="<?php
_e(apply_filters('format_to_edit',$cjOptions['howdy_text']),
'cjPluginSeriesHowdy') ?>"><p><i>Replaces the word 'Howdy' in the admin bar.</i></p>
<div class="submit">
<input type="submit" class="button-primary" name="update_cjPluginSeriesHowdySettings" value="<?php _e('Change Howdy', 'cjPluginSeriesHowdy') ?>" /></div></form></div>
<?php
 }

}
}

if (class_exists("cjPluginSeriesHowdy")) 
{ 
	$cj_pluginSeries_howdy = new cjPluginSeriesHowdy();
}

//Actions and Filters
if (isset($cj_pluginSeries_howdy)) {
add_action('activate_cj-change-howdy/cj-change-howdy.php', array(&$cj_pluginSeries_howdy, 'init'));
add_filter('admin_bar_menu', array(&$cj_pluginSeries_howdy, 'cj_rep_howdy'), 25);
add_action('admin_menu', 'cjPluginSeriesHowdy_ap');
add_filter('plugin_action_links_'.plugin_basename(__FILE__), array(&$cj_pluginSeries_howdy, 'cjPluginSeriesHowdy_settings_link'), 10, 1);
}
?>