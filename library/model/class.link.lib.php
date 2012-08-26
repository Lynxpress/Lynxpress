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
	
	namespace Library\Model;
	use \Library\Model\Interfaces\Model as Model;
	use Exception;
	
	defined('FOOTPRINT') or die();
	
	/**
		* Link
		*
		* It represents an item of the associated database table
		* Usage:
		* <code>
		*	//load a link with all attributes filled out
		*	$link = new Link($id);
		*
		*	//create a new link in database
		*	$link = new Link();
		*	$link->_name = 'Some website';
		*	$link->_link = 'http://lynxpress.org';
		*	$link->create();
		*
		*	//read an attribute of a link and then access it
		*	$link = new Link();
		*	$link->_id = $id;
		*	$link->read('_name');
		*	echo $link->_name;
		*
		*	//update an attribute
		*	$link = new Link($id);
		*	$link->_name = 'Lynxpress';
		*	$link->update('_name');
		*
		*	//delete a link
		*	$link = new Link($id);
		*	$link->delete();
		* </code>
		*
		* @package		Library
		* @subpackage	Model
		* @author		Baptiste Langlade <lynxpressorg@gmail.com>
		* @version		1.1
		* @final
	*/
	
	final class Link extends Master implements Model{
	
		private $_id = null;
		private $_name = null;
		private $_link = null;
		private $_rss = null;
		private $_notes = null;
		private $_priority = null;
		
		/**
			* Class constructor
			*
			* @access	public
			* @param	int|string [$value] Value to search
			* @param	string [$attr] Attribute to search
			* @param	string [$type] Type of the value to search
		*/
		
		public function __construct($value = false, $attr = '_id', $type = 'str'){
		
			parent::__construct();
			
			$this->_sql_table = 'link';
			
			if($value !== false && $attr === '_id'){
			
				$this->_id = $value;
				$this->load();
			
			}elseif($value !== false && $attr !== '_id'){
			
				$this->$attr = $value;
				$this->load_from_column($attr, $type);
			
			}
		
		}
		
		/**
			* Load method read a set of attributes at a time
			*
			* @access	public
		*/
		
		public function load(){
		
			try{
			
				$this->read('_name');
				$this->read('_link');
				$this->read('_rss');
				$this->read('_notes');
				$this->read('_priority');
			
			}catch(Exception $e){
			
				throw new Exception(__CLASS__.' can\'t load because '.$e->getMessage());
			
			}
			
		}
		
		/**
			* Retrieve attributes from a specific column value
			*
			* @access	public
			* @param	string [$attr] Attribute to search
			* @param	string [$type] Type of the value to search
		*/
		
		public function load_from_column($attr, $type){
		
			try{
			
				$this->_id = parent::get_from_column('_id', $this->$attr, $attr, $type);
				$this->_name = parent::get_from_column('_name', $this->$attr, $attr, $type);
				$this->_link = parent::get_from_column('_link', $this->$attr, $attr, $type);
				$this->_rss = parent::get_from_column('_rss', $this->$attr, $attr, $type);
				$this->_notes= parent::get_from_column('_notes', $this->$attr, $attr, $type);
				$this->_priority = parent::get_from_column('_priority', $this->$attr, $attr, $type);
			
			}catch(Exception $e){
			
				throw new Exception(__CLASS__.' can\'t load because '.$e->getMessage());
			
			}
		
		}
		
		/**
			* Create method to add a row in link table
			*
			* After creation success, the id of the row is inserted in id attribute
			*
			* @access	public
		*/
		
		public function create(){
		
			$to_create['table'] = $this->_sql_table;
			$to_create['columns'] = array(':name' => '_name', 
										  ':link' => '_link', 
										  ':rss' => '_rss', 
										  ':notes' => '_notes', 
										  ':lvl' => '_priority');
			$to_create['values'] = array(':name' => $this->_name, 
										 ':link' => $this->_link, 
										 ':rss' => $this->_rss, 
										 ':notes' => $this->_notes,
										 ':lvl' => $this->_priority);
			$to_create['types'] = array(':name' => 'str',
										':link' => 'str',
										':rss' => 'str',
										':notes' => 'str',
										':lvl' => 'int');
			
			$is_int = $this->_db->create($to_create);
			
			if(is_int($is_int)){
			
				$this->_id = $is_int;
				$this->_result_action = true;
			
			}else{
			
				throw new Exception('There\'s a problem creating your '.__CLASS__);
			
			}
		
		}
		
		/**
			* Read an attribute via a given id
			*
			* @access	public
			* @param	string [$attr] Link attribute
		*/
		
		public function read($attr){
		
			$this->$attr = parent::m_read($this->_id, $attr);
		
		}
		
		/**
			* Update the item via its id
			*
			* @access	public
			* @param	string [$attr] Link attribute
			* @param	string [$type] Link attribute data type
		*/
		
		public function update($attr, $type = 'str'){
		
			parent::m_update($this->_id, $attr, $type);
		
		}
		
		/**
			* Delete the item in the database
			*
			* @access	public
		*/
		
		public function delete(){
		
			parent::m_delete($this->_id);
		
		}
		
		/**
			* Method to check if data passed via __set method are good for the object
			*
			* @access	private
			* @param	string [$attr] Link attribute
			* @param	string [$value] Link attribute value
			* @return	mixed true if no errors, otherwise return an error string
		*/
		
		private function check_data($attr, $value){
		
			switch($attr){
			
				case '_name':
					if(empty($value))
						$error = 'Name missing';
					elseif(strlen($value) > 20)
						$error = 'Name too long';
					break;
				
				case '_link':
					if(!empty($value) && substr($value, 0, 7) != 'http://')
						$error = 'Url has to begin with "http://"';
					break;
				
				case '_rss_link':
					if(!empty($value) && substr($value, 0, 7) != 'http://')
						$error = 'RSS url has to begin with "http://"';
					break;
				
				case '_priority':
					if(empty($value))
						$error = 'Priority level is missing';
					elseif(!in_array($value, range(1, 5)))
						$error = 'Priority level not existing';
					break;
			
			}
			
			if(isset($error))
				return $error;
			else
				return true;
		
		}
		
		/**
			* Set method to update an attribute value in the object
			*
			* @access	public
			* @param	string [$attr] Link attribute
			* @param	string [$value] Link attribute value
			* @return	mixed true if no errors, otherwise return an error string
		*/
		
		public function __set($attr, $value){
		
			$checked = $this->check_data($attr, $value);
			
			if($checked === true){
			
				$this->$attr = stripslashes($value);
				return true;
			
			}else{
			
				return $checked;	//contain the error message
			
			}
		
		}
		
		/**
			* Get method to return an object attribute value
			*
			* @access	public
			* @param	string [$attr] Link attribute
		*/
		
		public function __get($attr){
		
			if(isset($this->$attr))
				return $this->$attr;
			else
				return false;
		
		}
	
	}

?>