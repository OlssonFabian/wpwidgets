<?php
/**
 * Plugin Name: My Second Widget
 * Plugin URI:  https://thehiveresistance.com/mysecondwidget
 * Description: This plugin adds my second widget.
 * Version:     0.1
 * Author:      Fabioso
 * Author URI:  https://thehiveresistance.com
 * License:     WTFPL
 * License URI: http://www.wtfpl.net/
 * Text Domain: mysecondwidget
 * Domain Path: /languages
 */
require("class.MySecondWidget.php");
function msw_widgets_init() {
	register_widget('MySecondWidget');
}
add_action('widgets_init', 'msw_widgets_init');
