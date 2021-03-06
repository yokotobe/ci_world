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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['category'] = 'blog/category_index';												// www.exaple.com/category/
$route['category/(:any)'] = 'blog/category_lookup/$1';								// www.exaple.com/category/travel/
$route['category/(:any)/(:num)'] = 'blog/category_lookup_date/$1/$2';	// www.exaple.com/category/travel/2015

$route['world'] = 'world/world_index';														// www.example.com/world/
$route['world/continent'] = 'world/continent_lookup';							// www.example.com/world/continent


//$route['world/continent/(:any)/[p](?!0+$)\d+$'] = 'world/continent_countries/$1/$2'; //www.example.com/world/continent/europe/p2  page=2

$route['world/continent/(:any)/(:num)'] = 'world/continent_countries/$1/$2'; //www.example.com/world/continent/europe/p2  page=2

$route['world/country/search/(:any)'] = 'world/country_search/$1';
$route['world/continent/(:any)'] = 'world/continent_countries/$1';				// www.example.com/world/continent/europe/

$route['world/(:any)/(:num)'] = 'world/world_lookup_country/$1/$2';		// www.example.com/world/europe/belgium
$route['world/country/(:any)'] = 'world/world_lookup_country/$1';		// www.example.com//world/country/croatia
$route['world/country/(:any)/edit'] = 'world/country_edit/$1';			// www.example.com//world/country/croatia/edit

//$route['category/(:any)'] = 'blog/category_lookup';

//$route['subjects/(:num)/(:any)'] = 'subjects/view/$1/$2';
