<?php 

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

if (!defined('EG')) die('Direct access not allowed!');



//RESRICTED ACCESS PARAMETERS

//define the hash algoritm to be used in order to protect your password
//only md5 and sha1 are supported
if (!defined('PASSWORD_HASH'))
	define('PASSWORD_HASH','sha256');



//ADMINISTRATOR USERS LOGIN DIRECTIVES:

//set ADMIN_ALLOW_MULTIPLE_ACCESSES to true if you want that the same user could be logged from different clients at the same time.
//If it is false, when a user makes the login with a client all the other sessions of the same users will be deleted
define("ADMIN_ALLOW_MULTIPLE_ACCESSES", true);

//only valid if ADMIN_ALLOW_MULTIPLE_ACCESSES is equal to true
//set the maximum number of sessions that could be active using the same account (for admin users)
//if the number of session is greater that ADMIN_MAX_CLIENT_SESSIONS then the oldest are deleted
//set it to 0 if you want no limits in the number of sessions
define("ADMIN_MAX_CLIENT_SESSIONS", 2);

//time that has to pass after a login failure before the user is allowed to try to login another time (in seconds)
define('ADMIN_TIME_AFTER_FAILURE','5');

//redirect to panel when successfully logged in:
define('ADMIN_PANEL_CONTROLLER', 'panel');
define('ADMIN_PANEL_MAIN_ACTION', 'main');

//redirect to login form if access not allowed:
define('ADMIN_USERS_CONTROLLER', 'utenti');
define('ADMIN_USERS_LOGIN_ACTION', 'login');

//admin cookie:
define('ADMIN_COOKIE_NAME','uid');
define('ADMIN_SESSION_EXPIRE', '86400');
define('ADMIN_COOKIE_PATH', '/');
define('ADMIN_COOKIE_DOMAIN', '');
define('ADMIN_COOKIE_SECURE', false);

//if the COOKIE is permanent for the admin user
//life equal to ADMIN_COOKIE_NAME
define('ADMIN_COOKIE_PERMANENT', true);

//tables:
define('ADMIN_USERS_TABLE','utenti');
define('ADMIN_GROUPS_TABLE','permessi');
define('ADMIN_SESSIONS_TABLE','sessioni');
define('ADMIN_MANYTOMANY_TABLE','utenti_permessi');
define('ADMIN_ACCESSES_TABLE','');

//hijacking checks
define('ADMIN_HIJACKING_CHECK',true); //can be true or false
//session hijacking
//set ADMIN_ON_HIJACKING_EVENT equal to 'forceout' if you want to cause the logout of the user if there is the suspect of a session hijacking
//set ADMIN_ON_HIJACKING_EVENT equal to 'redirect' if you want to redirect the user to the ADMIN_HIJACKING_ACTION (see later) if there is the suspect of a session hijacking
define('ADMIN_ON_HIJACKING_EVENT','forceout');  //it can be 'forceout' or 'redirect'
//only if ADMIN_ON_HIJACKING_EVENT = 'redirect'
//redirect the user to ADMIN_USERS_CONTROLLER/ADMIN_HIJACKING_ACTION if there is the suspect of a session hijacking
define('ADMIN_HIJACKING_ACTION','retype');




//REGISTERED USERS LOGIN DIRECTIVES:

//time that has to pass after a login failure before the user is allowed to try to login another time (in seconds)
define('REG_TIME_AFTER_FAILURE','5');

//redirect to home when successfully logged in:
define('REG_PANEL_CONTROLLER', 'home');
define('REG_PANEL_MAIN_ACTION', 'index');

//redirect to login form if access not allowed:
define('REG_USERS_CONTROLLER', 'personal');
define('REG_USERS_LOGIN_ACTION', 'login');

//registered cookie:
//NB: REG_COOKIE_NAME must be different from ADMIN_COOKIE_NAME!!!
define('REG_COOKIE_NAME','uidr');
define('REG_SESSION_EXPIRE', '3600');
define('REG_COOKIE_PATH', '/');
define('REG_COOKIE_DOMAIN', '');
define('REG_COOKIE_SECURE', false);

//tables:
define('REG_USERS_TABLE','regusers');
define('REG_GROUPS_TABLE','reggroups');
define('REG_SESSIONS_TABLE','regsessions');
define('REG_MANYTOMANY_TABLE','regusers_groups');
define('REG_ACCESSES_TABLE','regaccesses');

//hijacking checks
define('REG_HIJACKING_CHECK',true); //can be true or false
//session hijacking
//set ADMIN_ON_HIJACKING_EVENT equal to 'forceout' if you want to cause the logout of the user if there is the suspect of a session hijacking
//set ADMIN_ON_HIJACKING_EVENT equal to 'redirect' if you want to redirect the user to the ADMIN_HIJACKING_ACTION (see later) if there is the suspect of a session hijacking
define('REG_ON_HIJACKING_EVENT','forceout');  //it can be 'forceout' or 'redirect'
//only if ADMIN_ON_HIJACKING_EVENT = 'redirect'
//redirect the user to ADMIN_USERS_CONTROLLER/ADMIN_HIJACKING_ACTION if there is the suspect of a session hijacking
define('REG_HIJACKING_ACTION','retype');
