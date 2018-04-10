<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('DROOT',$_SERVER['DOCUMENT_ROOT'].'/newbalcomm');
define('UPATH','/assets/uploads/');
define('PDFPATH',DROOT.'/assets/pdf/');
define('DT_FORMAT', 'd M, Y');
define('TIME_FORMAT', 'H:i');
define('SQL_FORMAT', 'Y-m-d H:i:s');
define('ENG_ID', 25);

/* ==================================== Table Name Define ================================= */
define('USER', 'users');
define('USERROLE', 'roles');
define('COMPANY', 'company');
define('CUSTOMER', 'customer');
define('CUSDETAILS', 'customer_details');
define('CUSSITES', 'customer_sites');
define('CUSCONSITE', 'customer_site_contacts');
define('PROJECTS', 'projects');
define('PROJURS', 'projects_users');
define('PROCESS', 'processcategory');
define('PROCESSLST', 'processlist');
define('PROCESSEC', 'processsection');
define('PROCESSECCAT', 'processsectioncategory');
define('PRJSHTSTS', 'project_sheet');
define('PRJSYS', 'project_systems');
define('PRJPRCLST', 'projectprocesslistmaster');
define('PRJREPORT', 'project_reports');

define('CASYSSCHE', 'ca_systemschematic');
define('CAPRECK', 'CA_precommissionchecksmaster');
define('CAPRECKDETAILS', 'ca_precommissioncheckdetail');
define('CAFANPERFTEST', 'ca_fandet_perftest');

define('CAGRILL', 'ca_grillebalance');
define('CAGRILLBAL', 'ca_grillebalancetest');

define('CADIRGRILLVLM', 'ca_directvolume');
define('CADIRGRILL', 'ca_directvolumegrille');

define('CASYSCERT', 'ca_system_witness_certificate');
define('CAPTVLMDGN', 'ca_pitotvolumetest_design');
define('CAPTMSDGN', 'ca_pitotvolumetest_measured_volumes');
define('CAAIRCTRL', 'ca_variable_air_volume_controbox_test');
define('CACONSCTRL', 'ca_constant_air_volume_controbox_test');
define('CAFCUCKLST', 'ca_fcu_validation_checklist');
define('CAREPORTSHEET', 'ca_report_sheet');

define('CWREPORTSHEET', 'cw_report_sheet');
define('CWSYSSCHE', 'cw_systemschematic');
define('CWSYSWTCRT', 'cw_system_witness_certificate');
define('CWPRECKDETAILS', 'cw_precommissioncheckDetail');
define('CWPUMPTEST', 'cw_pumpdet_perftest');
define('CWWATERDISTST', 'cw_waterdistritest');
define('CWWATERDISTPICV', 'cw_waterdistripicv');
define('CWHWSBLENDVLS', 'cw_hwsblendvalves');

define('CWTIMEMASTER', 'ts_timesheetmaster');
define('CWTIMEDATA', 'ts_timesheetdata');

define('WTSYSCERT', 'wt_system_witness_certificate');
define('WTREPORTSHEET', 'wt_report_sheet');
define('WTFLUSHVELO', 'wt_flushvelocities');
define('WTCHKLST', 'wt_checklist');
define('WTCHKLSTDATA', 'wt_checklistdata');
define('WTTEMPCERT', 'wt_tempcertificate');
define('WTCHLORINCERT', 'wt_mainchlorin');

define('RPZMASTER', 'rpz_master');
define('RPZVALVES', 'rpz_valves');
define('RPZCKVALV', 'rpz_checkvalve');
define('RPZDATA', 'rpz_data');

define('PRVPAGEOPT', 'prv_pageoptions');
define('PRVPAGES', 'prv_pages');
define('PRVPERMION', 'prv_permission');

define('OFFLINE', 'offline_form_uploads');

/* ==================================== Process Names Define ================================= */
define('SWC1', '1');
/*System Witness Certificate*/
define('RS1', '2');
/*first Report Sheet*/
define('SS', '3');
/*System Schematic*/
define('ASPCC', '4');
/*Air System Pre-Commissioning Checks*/
define('FDPTR', '5');
/*Fan Details & Performance Test Record*/
define('PVTR', '6');
/*Piot Volume Test Record*/
define('GBTR', '7');
/*Grilling Balance Test Record*/
define('DVGRS', '8');
/*Direct Volume Grilling Record Sheet*/
define('VAVCBTR', '9');
/*Variable Air Volume Control Box Test Record*/
define('CAVCBTR', '10');
/*Constant Air Volume Control Box Test Record*/
define('FCUVCL', '11');
/*FCU Validation Check List*/
define('SWC2', '12');
/*System Witness Certificate with catid 2*/
define('RS20', '13');
/*Report Sheet*/
define('SS20', '14');
/*System Schematic*/
define('WSPCC', '15');
/*Water System Pre-Commissioning Checks*/
define('PDPTR', '16');
/*Pump Details & Performance Test Record*/
define('WDTR', '17');
/*Water Distribution Test Record*/
define('WDPICV', '18');
/*Water Distribution - PICV */
define('HWSBV', '19');
/*HWS Blending Valves*/
define('SWC50', '20');
/*System Witness Certificate cat 5 pid 0*/
define('WTCL', '21');
/*Water Treatment Check List*/
define('WFV', '22');
/*Water Flushing Velocities*/
define('RS50', '23');
/*Report Sheet with cat 5 pid 0*/
define('TCDC', '24');
/*Temporary Certificate of Disinfection/Chlorination */
define('CMC', '25');
/*Certificate of Mains Chlorination*/
define('RPZ', '26');
/*RPZ */
define('TS40', '27');
/*Time Sheet with cat4 pageid 0*/
