#!/usr/local/bin/php
<?php
// Show all information, defaults to INFO_ALL
date_default_timezone_set('America/New_York'); 
phpinfo();

// Show just the module information.
// phpinfo(8) yields identical results.
phpinfo(INFO_MODULES);
?>