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

//used with Admin\DefaultPage\Controllers\Manage

$(document).ready(function() {

	homepage = {
	
		types: $('#homepage > .label .check_label > input'),
		lists: $('#homepage_lists > select'),
		
		init: function() {
		
			this.types.on('click', this.show_list);
		
		},
		
		show_list: function() {
		
			var $this = $(this);
			
			homepage.lists.hide();
			
			$('#hl_'+$this.val()).show();
		
		}
	
	};
	
	homepage.init();

});