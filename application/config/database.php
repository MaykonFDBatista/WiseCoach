<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'local';
$active_record = TRUE;

$db['local']['hostname'] = 'localhost';//labsoft.muz.ifsuldeminas.edu.br
$db['local']['username'] = 'wisecoach';
$db['local']['password'] = 'wisecoach';
$db['local']['database'] = 'wisecoach';
$db['local']['dbdriver'] = 'mysql';
$db['local']['dbprefix'] = '';
$db['local']['pconnect'] = FALSE; // fecha as conexões
$db['local']['db_debug'] = TRUE;
$db['local']['cache_on'] = FALSE;
$db['local']['cachedir'] = '';
$db['local']['char_set'] = 'utf8';
$db['local']['dbcollat'] = 'utf8_general_ci';
$db['local']['swap_pre'] = '';
$db['local']['autoinit'] = TRUE;
$db['local']['stricton'] = FALSE;

//Banco de desenvolvimento
$db['default']['hostname'] = '200.131.11.23';//labsoft.muz.ifsuldeminas.edu.br
$db['default']['username'] = 'claudia';
$db['default']['password'] = '';
$db['default']['database'] = 'wisecoach';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE; // fecha as conexões
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

//Banco servidor de homologação
$db['homologacao']['hostname'] = '200.131.11.23';//labsoft.muz.ifsuldeminas.edu.br
$db['homologacao']['username'] = 'wisecoach';
$db['homologacao']['password'] = 'wisecoach*2015';
$db['homologacao']['database'] = 'wisecoach';
$db['homologacao']['dbdriver'] = 'mysql';
$db['homologacao']['dbprefix'] = '';
$db['homologacao']['pconnect'] = FALSE;
$db['homologacao']['db_debug'] = TRUE;
$db['homologacao']['cache_on'] = FALSE;
$db['homologacao']['cachedir'] = '';
$db['homologacao']['char_set'] = 'utf8';
$db['homologacao']['dbcollat'] = 'utf8_general_ci';
$db['homologacao']['swap_pre'] = '';
$db['homologacao']['autoinit'] = TRUE;
$db['homologacao']['stricton'] = FALSE;

//Banco de desenvolvimento
$db['localhost']['hostname'] = 'localhost';
$db['localhost']['username'] = 'wisecoach';
$db['localhost']['password'] = 'wisecoach.2015';
$db['localhost']['database'] = 'wisecoach';
$db['localhost']['dbdriver'] = 'mysql';
$db['localhost']['dbprefix'] = '';
$db['localhost']['pconnect'] = FALSE; // fecha as conexões
$db['localhost']['db_debug'] = TRUE;
$db['localhost']['cache_on'] = FALSE;
$db['localhost']['cachedir'] = '';
$db['localhost']['char_set'] = 'utf8';
$db['localhost']['dbcollat'] = 'utf8_general_ci';
$db['localhost']['swap_pre'] = '';
$db['localhost']['autoinit'] = TRUE;
$db['localhost']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */
