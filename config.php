<?php

/** 
 * Your MySQL database name where you want PHPNotePad to store its data
 * Write the name of your current database
 * and PHPNotePad will store their tables there.
 */
define ('DB_NAME',     "notepad");
/** 
 * Your MySQL username.
 * This user must have grants to SELECT, INSERT, and UPDATE, tables.
 */
define ('DB_USER',     "root");
/** 
 * Your MySQL password. 
 */
define ('DB_PASSWORD', "pass");
/** 
 * Your MySQL server. 
 * If port number ### were needed, use 'servername:###'. 
 */
define ('DB_HOST',     "localhost");
/** 
 * Prefix for creating smt2 tables.
 * That's really useful if you have only one database.
 */
define ('TBL_PREFIX',  "notepad_");

?>
