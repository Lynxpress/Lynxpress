<?php

	/**
		* @author		Baptiste Langlade
		* @copyright	2011-2012
		* @license		http://www.gnu.org/licenses/gpl.html GNU GPL V3
		* @package		Lynxpress
		*
		* This file is part of Lynxpress.
		*
		*   Lynxpress is free software: you can redistribute it and/or modify
		*   it under the terms of the GNU General Public License as published by
		*   the Free Software Foundation, either version 3 of the License, or
		*   (at your option) any later version.
		*
		*   Lynxpress is distributed in the hope that it will be useful,
		*   but WITHOUT ANY WARRANTY; without even the implied warranty of
		*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		*   GNU General Public License for more details.
		*
		*   You should have received a copy of the GNU General Public License
		*   along with Lynxpress.  If not, see http://www.gnu.org/licenses/.
	*/
	
	namespace Site\Videos\Html;
	use \Library\Url\Url;
	use \Library\Variable\Get as VGet;
	
	defined('FOOTPRINT') or die();
	
	/**
		* Views for videos category controller
		*
		* @package		Site
		* @subpackage	Videos\Html
		* @author		Baptiste Langlade <lynxpressorg@gmail.com>
		* @version		1.0
		* @abstract
	*/
	
	abstract class Category extends Home{
	
		/**
			* Display videos categories list
			*
			* @static
			* @access	public
			* @param	array	[$cats] Array of categories objects
		*/
		
		public static function categories($cats){
		
			$id = VGet::id();
			
			echo '<div id=videos_cats class=categories>'.
					'<h3>Categories</h3>'.
					'<ul>';
			
					foreach($cats as $c)
						echo '<li '.(($id == $c->_id)?'class=selected':'').'>'.
								'<a href="'.Url::_(array('ns' => 'videos', 'ctl' => 'category', 'id' => $c->_id)).'">'.
									$c->_name.
								'</a>'.
							 '</li>';
			
			echo 	'</ul>'.
				 '</div>';
		
		}
	
	}

?>