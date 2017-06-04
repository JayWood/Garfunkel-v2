<?php

// Menu walker adding "has-children" class to menu li's with children menu items
class Garfunkel_Nav_Walker extends Walker_Nav_Menu {
	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$id_field = $this->db_fields['id'];
		if ( ! empty( $children_elements[ $element->$id_field ] ) ) {
			$element->classes[] = 'has-children';
		}
		Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}