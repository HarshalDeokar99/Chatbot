<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2019 - 2022, CodeIgniter Foundation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @copyright	Copyright (c) 2019 - 2022, CodeIgniter Foundation (https://codeigniter.com/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/userguide3/general/controllers.html
 */
#[\AllowDynamicProperties]
class CI_Controller {

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;

	/**
	 * CI_Loader
	 *
	 * @var	CI_Loader
	 */
	public $load;

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}
	
	public static function get_log_file()
	{
	    $date = date("Y-m-d");
	    $to_delete = date('Y-m-d', strtotime("-7 day", strtotime(date('Y-m-d'))));
	    if(file_exists("logs/".$to_delete.'.log'))
	    {
	        unlink("logs/".$to_delete.'.log');
	    }
	    return $date.'.log';
	}
	
	public function api_log_start()
	{
	    $filename = self::get_log_file();
	    $log_file = fopen("logs/".$filename, "a+") or die("Unable to open file!");
	    
	    $timestamp = date("d M Y H:i:s");
	    fwrite($log_file, "==================== [API REQUEST] ==================== \r\n\r\n");
	    fwrite($log_file, "[".$timestamp."] Request Details \r\n");
	    fwrite($log_file, "-----------------------------------------------------------");
	    
	    
	    $request_url = $_SERVER['REQUEST_URI'];
	    $server_protocol = $_SERVER['SERVER_PROTOCOL'];
	    $remote_address = $_SERVER['REMOTE_ADDR'];
	    $request_method = $_SERVER['REQUEST_METHOD'];
	    $query_string = $_SERVER['QUERY_STRING'];
	    
	    $headersArr = apache_request_headers();
	    $headers = json_encode($headersArr);
	    
	    /* if(strtoupper($request_method) == "POST" && stripslashes($headersArr['Content-Type']) == 'application/json')
	     {
	     $query_string = file_get_contents('php://input');
	     }
	     else if(strtoupper($request_method) == "POST")
	     {
	     $query_string = json_encode($_REQUEST);
	     } */
	    
	    if(!empty($_REQUEST))
	    {
	        $payload['REQUEST'] = $_REQUEST;
	    }
	    
	    $payload['Payload'] = json_decode(file_get_contents('php://input'));
	    
	    $query_string = json_encode($payload);
	    
	    fwrite($log_file, "\r\n[Request URL] : ".$request_url);
	    fwrite($log_file, "\r\n[Request Headers] : ".stripslashes($headers));
	    fwrite($log_file, "\r\n[Protocol Used] : ".$server_protocol);
	    fwrite($log_file, "\r\n[Request Method] : ".$request_method);
	    fwrite($log_file, "\r\n[Payload] : ".$query_string);
	    fwrite($log_file, "\r\n-----------------------------------------------------------\r\n");
	    fclose($log_file);
	}
	
	public function api_log($response)
	{
	    $filename = self::get_log_file();
	    $log_file = fopen("logs/".$filename, "a+") or die("Unable to open file!");
	    
	    $timestamp = date("d M Y H:i:s");
	    fwrite($log_file, "\r\n[".$timestamp."] API Response \r\n");
	    fwrite($log_file, "-----------------------------------------------------------\r\n");
	    fwrite($log_file, $response);
	    fwrite($log_file, " \r\n\r\n--------------- END OF API RESPONSE --------------------\r\n\r\n");
	    fclose($log_file);
	}

}
