<?php
/*
Plugin Name: 	Widget Disabler
Plugin URI: 	http://slopjong.de/2009/05/16/widget-disabler/
Description:  	It removes the widgets of deactivated plugins from the sidebars. This is required if some widgets are causing errors that don't let you remove them by yourself.
Author: 		Romain Schmitz
Author URI: 	http://slopjong.de
License:     	GNU General Public License
Last Change: 	16.5.2009
Version: 		0.1

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

function widget_disabler_admin()
{
	if (function_exists('add_submenu_page'))
		add_submenu_page( 'tools.php', 'Widget Disabler', 'Widget Disabler', 5, "widget-disabler", 'widget_disabler' );
}

function widget_disabler()
{
	?>
	<div class="wrap">

		<h2>Widget Disabler</h2>

		<?php
		global $wp_registered_widgets, $wp_registered_sidebars;
		$sidebars_widgets = get_option('sidebars_widgets');

		foreach ( (array) $wp_registered_sidebars as $index => $sidebar ) 
		{
			if ( count($sidebars_widgets[$index]) ) 
			{
				$i = 0;
				$no_unset = true;
				$output = '';
				
				foreach ( (array) $sidebars_widgets[$index] as $widget )
				{
					if ( !array_key_exists($widget, $wp_registered_widgets) )
					{
						unset( $sidebars_widgets[$index][$i] );
						$no_unset = true;
						$output .= "The plugin with the id <em>". $widget ."</em> was removed from the sidebar. <br/>"; 
					}
					$i++;
				}
				
				if ( $output )
					echo $output;
				else
					echo "No widget was removed from the sidebar.";
			}
		}	
		
		update_option( "sidebars_widgets", $sidebars_widgets );
		?>

	</div>
	<?php
}

add_action('admin_menu', 'widget_disabler_admin' );

?>
