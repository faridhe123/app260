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
//$route['default_controller'] = 'dashboard';
//if(isset($_SESSION['nama'])){
	$route['default_controller'] = 'home';
	$route['404_override'] = '';
	$route['translate_uri_dashes'] = FALSE;
	$route['wp_per_klu/list/(:any)/(:any)'] = 'wp_per_klu/klu/$1/$2';
	$route['wp_per_klu_20/list/(:any)/(:any)'] = 'wp_per_klu_20/klu/$1/$2';
	$route['wp_per_klu/list/(:any)'] = 'wp_per_klu/kat/$1';	
	$route['wp_per_klu_20/list/(:any)'] = 'wp_per_klu_20/kat/$1';	
	$route['pagu20/desa/(:any)'] = 'pagu20/desa2/$1';
	$route['pagu20/desa/(:any)/(:any)'] = 'pagu20/desa3/$1/$2';
	$route['pagu20/apbn/(:any)'] = 'pagu20/apbn2/$1';
	
	$route['pagu19/desa/(:any)'] = 'pagu19/desa2/$1';
	$route['pagu19/desa/(:any)/(:any)'] = 'pagu19/desa3/$1/$2';
	$route['pagu19/apbn/(:any)'] = 'pagu19/apbn2/$1';
	
	$route['pagu18/desa/(:any)'] = 'pagu18/desa2/$1';
	$route['pagu18/desa/(:any)/(:any)'] = 'pagu18/desa3/$1/$2';
	$route['pagu18/apbn/(:any)'] = 'pagu18/apbn2/$1';

	$route['/(:any)'] = '/index.php/$1';
	//}
//else{
	//$route['/(:any)'] = 'login';
	//$route['default_controller'] = 'home';
//}
