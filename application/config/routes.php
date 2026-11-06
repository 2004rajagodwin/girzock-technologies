<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = 'errors/not_found';
$route['translate_uri_dashes'] = FALSE;

/* ---- Legacy static URLs: permanent redirects to the clean URLs ---- */
$route['index8\.html'] = 'redirects/legacy/home';
$route['index\.html'] = 'redirects/legacy/home';
$route['(about|services|products|portfolio|case-studies|blog|careers|contact)\.html'] = 'redirects/legacy/$1';

/* ---- SEO endpoints ---- */
$route['sitemap\.xml'] = 'sitemap/index';
$route['robots\.txt'] = 'sitemap/robots';

/* ---- Public website ---- */
$route['about'] = 'home/about';
$route['areas-we-serve'] = 'home/areas';
$route['search'] = 'search/index';

$route['services'] = 'services/index';
$route['services/(:any)'] = 'services/detail/$1';

$route['products'] = 'products/index';
$route['products/(:any)'] = 'products/detail/$1';

$route['portfolio'] = 'portfolio/index';
$route['portfolio/(:any)'] = 'portfolio/detail/$1';

$route['case-studies'] = 'caseStudies/index';
$route['case-studies/(:any)'] = 'caseStudies/detail/$1';

$route['blog'] = 'blog/index';
$route['blog/page/(:num)'] = 'blog/index/$1';
$route['blog/category/(:any)/page/(:num)'] = 'blog/category/$1/$2';
$route['blog/category/(:any)'] = 'blog/category/$1';
$route['blog/tag/(:any)'] = 'blog/tag/$1';
$route['blog/(:any)'] = 'blog/detail/$1';

$route['careers'] = 'careers/index';
$route['careers/apply'] = 'careers/apply';
$route['careers/(:any)'] = 'careers/detail/$1';

$route['contact'] = 'contact/index';
$route['contact/submit'] = 'contact/submit';

/* ---- Admin ---- */
$route['admin'] = 'admin/dashboard/index';
$route['admin/login'] = 'admin/auth/login';
$route['admin/logout'] = 'admin/auth/logout';
$route['admin/forgot-password'] = 'admin/auth/forgot';
$route['admin/reset-password/(:any)'] = 'admin/auth/reset/$1';

$route['admin/case-studies'] = 'admin/caseStudies/index';
$route['admin/case-studies/(:any)/(:num)'] = 'admin/caseStudies/$1/$2';
$route['admin/case-studies/(:any)'] = 'admin/caseStudies/$1';

$route['admin/job-applications'] = 'admin/applications/index';
$route['admin/job-applications/(:any)/(:num)'] = 'admin/applications/$1/$2';
$route['admin/job-applications/(:any)'] = 'admin/applications/$1';

/* Any other public URL with a dash or unknown path is resolved by the 404 handler, which also
   checks the url_redirects table so changed slugs keep working. */

/* Internal controller paths answer 404, so each page has exactly one public URL. */
$route['(home|redirects|errors|sitemap|setup|caseStudies|casestudies)(/.*)?'] = is_cli() ? '$1$2' : 'errors/not_found';
$route['(services|products|portfolio|blog|careers|search)/(index|detail)(/.*)?'] = 'errors/not_found';
