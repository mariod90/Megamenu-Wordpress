<?php

/**
 *
 * This theme uses PSR-4 and OOP logic instead of procedural coding
 * Every function, hook and action is properly divided and organized inside related folders and files
 * Use the file `inc/Custom/Custom.php` to write your custom functions
 *
 * @package awps
 */

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) :
	require_once dirname(__FILE__) . '/vendor/autoload.php';
endif;

if (class_exists('Awps\\Init')) :
	Awps\Init::register_services();
endif;

//************************ Megamenu custom fields ***************************//

//Create fields
function field_list()
{
	return array(
		'mm-megamenu' => 'Activate Megamenu',
		'mm-column-divider' => 'Column Divider',
		'mm-divider' => 'Inline Divider',
		'mm-featured-image' => 'Featured Image',
		'mm-description' => 'Description'
	);
}

//Setup fields
function megamenu_fields($id, $item, $depth, $args)
{
	$fields =  field_list();
	foreach ($fields as $_key => $label) {
		$key = sprintf('menu-item-%s', $_key);
		$id = sprintf('edit-%s-%s', $key, $item->ID);
		$name = sprintf('%s[%s]', $key, $item->ID);
		$value = get_post_meta($item->ID, $key, true);
		$class = sprintf('field%s', $_key);

		?>

		<p class="description description-wide <?php echo esc_attr($class) ?>">
			<label for="<?php echo esc_attr($id) ?>">
				<input type="checkbox" id="<?php echo esc_attr($id) ?>" name="<?php echo esc_attr($name) ?>" value="1" <?php echo ($value == 1) ? 'checked="checked"' : ''; ?> />
				<?php echo esc_attr($label) ?>
			</label>
		</p>

<?php

	}
}
add_action("wp_nav_menu_item_custom_fields", 'megamenu_fields', 10, 4);

//Show columns
function megamenu_columns($columns)
{
	$fields = field_list();
	$columns = array_merge($columns, $fields);
	return $columns;
}
add_filter('manage_nav-menus_columns', 'megamenu_columns', 99);

//Save/update fields
function megamenu_save($menu_id, $menu_item_db_id, $menu_item_args)
{

	$fields =  field_list();
	foreach ($fields as $_key => $label) {
		$key = sprintf('menu-item-%s', $_key);
		//Sanitize
		if (!empty($_POST[$key][$menu_item_db_id])) {
			$value = $_POST[$key][$menu_item_db_id];
		} else {
			$value = null;
		}
		//Save or update
		if (!is_null($value)) {
			update_post_meta($menu_item_db_id, $key, $value);
		} else {
			delete_post_meta($menu_item_db_id, $key, $value);
		}
	}
}
add_action('wp_update_nav_menu_item', 'megamenu_save', 10, 3);

//Update the walker Nav Class
function megamenu_walkernav($walker)
{
	$walker = 'MegaMenu_Walker_Edit';
	if (!class_exists($walker)) {
		require_once dirname(__FILE__) . '/inc/walker-nav-menu-edit.php';
	}
	return $walker;
}

add_filter('wp_edit_nav_menu_walker', 'megamenu_walkernav', 99);
