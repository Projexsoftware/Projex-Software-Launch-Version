<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = 'nopage';
$route['translate_uri_dashes'] = FALSE;
$route['admin'] = 'admin/login';
$route['buildz'] = 'scheduling/projects';
$route['buildz/edit_buildz/(:num)'] = 'scheduling/projects/edit_project/$1';
$route['buildz/templates'] = 'scheduling/templates';
$route['buildz/templates/add_template'] = 'scheduling/templates/add_template';
$route['buildz/templates/edit_template/(:num)'] = 'scheduling/templates/edit_template/$1';
$route['buildz/templates/delete_template'] = 'scheduling/templates/delete_template';
$route['buildz/templates/download_image/(:any)'] = 'scheduling/templates/download_image/$1';
$route['buildz/checklists'] = 'scheduling/checklists';
$route['buildz/checklists/add_checklist'] = 'scheduling/checklists/add_checklist';
$route['buildz/checklists/edit_checklist/(:num)'] = 'scheduling/checklists/edit_checklist/$1';
$route['buildz/checklists/delete_checklist'] = 'scheduling/checklists/delete_checklist';
$route['buildz/tasks'] = 'scheduling/tasks';
$route['buildz/tasks/add_task'] = 'scheduling/tasks/add_task';
$route['buildz/tasks/edit_task/(:num)'] = 'scheduling/tasks/edit_task/$1';
$route['buildz/tasks/delete_task'] = 'scheduling/tasks/delete_task';
$route['buildz/reset_project/(:num)'] = 'scheduling/projects/delete_project/$1';
$route['buildz/reports'] = 'scheduling/reports';

