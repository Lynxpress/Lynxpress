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
	
	namespace Library\Curl;
	use Exception;
	
	defined('FOOTPRINT') or die();
	
	/**
		* Curl
		*
		* Used to retrieve content from other websites
		* There is two ways to load a website:
		* <code>
		*	$curl = new Curl('http://lynxpress.org');
		*
		*	//or
		*	$curl = new Curl();
		*	$curl->_url = 'http://lynxpress.org';
		*	$curl->connect();
		* </code>
		* With the second one in addition to specify url you can change two other settings.
		* _follow attribute says if you want two follow redirection made by your wished website.
		* _post attribute can be set to true or false (boolean) to specify connection type HTTP POST if true, otherwise it's HTTP GET.
		* To pass data in HTTP POST use _data attribute array.
		*
		* @package		Library
		* @subpackage	Curl
		* @author		Baptiste Langlade <lynxpressorg@gmail.com>
		* @version		1.1
	*/
	
	class Curl{
	
		private $_c = null;
		private $_url = null;
		private $_follow = null;
		private $_content = null;
		private $_post = null;
		private $_data = array();
		private $_http_code = null;
		
		/**
			* Class Constructor
			*
			* @access	public
			* @param	string [$url] If a url is passed, the connection will automatically be done
		*/
		
		public function __construct($url = false){
		
			self::check_ext();
			
			$this->_c = curl_init();
			$this->_follow = true;
			
			if($url !== false){
			
				$this->_url = $url;
				$this->connect();
			
			}
		
		}
		
		/**
			* Connect to the specified url
			*
			* @access	public
		*/
		
		public function connect(){
		
			if(empty($this->_url))
				throw new Exception('Please mention a url');
			
			curl_setopt($this->_c, CURLOPT_URL, $this->_url);
			curl_setopt($this->_c, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($this->_c, CURLOPT_HEADER, false);
			curl_setopt($this->_c, CURLOPT_FOLLOWLOCATION, $this->_follow);
			
			if($this->_post === true){
			
				curl_setopt($this->_c, CURLOPT_POST, true);
				curl_setopt($this->_c, CURLOPT_POSTFIELDS, $this->_data);
			
			}else{
			
				curl_setopt($this->_c, CURLOPT_HTTPGET, true);
			
			}
			
			$this->_content = curl_exec($this->_c);
			
			$this->_http_code = curl_getinfo($this->_c, CURLINFO_HTTP_CODE);
			
			if($this->_content === false)
				throw new Exception('Error trying to connect to "'.$this->_url.'" (Error: "'.curl_error($this->_c).'")');
		
		}
		
		/**
			* Retrieve http headers for a website, url has to be pre registered
			* Usage:
			* <code>
			*	$curl = new Curl();
			*	$curl->_url = 'http://lynxpress.org';
			*	$curl->http_headers();
			*	//Now $curl->_content contains an array with http informations
			* </code>
			*
			* @access	public
		*/
		
		public function http_headers(){
		
			if(empty($this->_url))
				throw new Exception('Please mention a url');
			
			$this->_content = @get_headers($this->_url, 1);
			
			if($this->_content === false)
				throw new Exception('Error trying to connect to "'.$this->_url.'"');
		
		}
		
		/**
			* Check if curl extension is loaded
			*
			* @static
			* @access	private
		*/
		
		private static function check_ext(){
		
			if(!extension_loaded('curl'))
				throw new Exception('Curl extension not loaded!');
		
		}
		
		/**
			* Method to set data in the object
			*
			* @access	public
			* @param	string [$attr]
			* @param	mixed [$value]
		*/
		
		public function __set($attr, $value){
		
			$this->$attr = $value;
		
		}
		
		/**
			* Method to get value of an attribute
			*
			* @access	public
			* @param	string [$attr]
		*/
		
		public function __get($attr){
		
			return $this->$attr;
		
		}
		
		/**
			* Class destructor close url connection
			*
			* @access	public
		*/
		
		public function __destruct(){
		
			curl_close($this->_c);
		
		}
	
	}

?>