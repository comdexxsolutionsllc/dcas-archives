<?php
/////////////////////////////////////////////////////////////
//  DCC::QuickSite Pro.
//  Copiright (C) 2003, 2004, Gregory A. Rozanoff
/////////////////////////////////////////////////////////////

define(PATH, 		dirname(__FILE__));
define(CACHE,		FALSE);		// Cache: Default=TRUE
define(LOGGING,		FALSE);		// Logging: Default=FALSE
define(FLOCKING,	FALSE);		// File Locking: Default=FALSE
define(CLEAR,		FALSE);		// Clear HTML SPAM: Default=TRUE
define(GZIP,		FALSE);		// gZip compression: Default=FALSE
define(MYSQL,		FALSE);		// MySQL enable: Default=FALSE

include "lib/dcc/class.root.inc";
include "lib/dcc/class.mysql.inc";
include "lib/dcc/class.parser.inc";
include "lib/dcc/class.dcc.inc";
include "lib/dcc/class.engine.inc";

include "lib/class.".ME.".inc";

$module = new module($ROOT->args());
$module->main();
$module->done();
?>
