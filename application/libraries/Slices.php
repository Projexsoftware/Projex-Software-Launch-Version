<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Slice Callbacks
|--------------------------------------------------------------------------
|
| By default, any data you bind or send to the views using Stencil will already
| be available in your slices, however,this may have you rewriting code over and
| over again everytime you want to use a Slice that has a variable in it.
|
| Callbacks elimate that problem.
|
| Slice Callbacks are callbacks or class methods that are called when a Slice is created.
| If you have data that you want bound to a given view each time that view is created
| throughout your application, a Slice Callback can organize that code into a single 
| location. Therefore, view Slice Callbacks may function like "view models" or "presenters".
| This will maintain an MVC approach to your Views without you having to write redundant code.
| This is inspired by Laravel's View Composers.
|
| Example:
|
|
|		public function sidebar()
|		{
|			return array('recent_posts' => array('one', 'two', 'three', 'four'));
|		}
|
|		Makes $recent_posts available in /views/slices/sidebar.php
|
| The function name must be the same as the slice name. You must return an associative array.
|
| For more information, please visit the docs: http://scotch.io/development/stencil#callbacks
*/

class Slices {

	protected $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	//call back for agency_dashboard_menu dynamic data
	//this will run everytime agency_dashboard_menu slice is called
	
	

	
	//call back for header_top dynamic data
	//this will run everytime header_top slice is called
/*	function footer(){
	$this->CI->load->model('cms/mod_cms');
	
		//load data for top menu. Its being used in footer slice
		$data['footer1menu'] = $this->CI->mod_cms->get_menu_items(1,1);
		
			//load data for top menu. Its being used in footer slice
		$data['footer2menu'] = $this->CI->mod_cms->get_menu_items(4);
		return $data;
	}


	//call back for slider
	function slider(){
		$this->CI->load->model('slider/mod_slider');
		$data['slider_data'] =  $this->CI->mod_slider->get_slider_data();
		
		return $data;
		
	}*/
	
}
/* End of file Slices.php */
/* Location: ./application/libararies/Slices.php */