# README

# DATABASE CONNECTION

The database connection settings are git ignored. As such, please create your own file at /include/constants.php with the following content with your own settings:

```
<?php
if (!defined('DB_SERVER')) define('DB_SERVER', 'X');
if (!defined('DB_USER')) define('DB_USER', 'X');
if (!defined('DB_PASS')) define('DB_PASS', 'X');
if (!defined('DB_NAME')) define('DB_NAME', 'X');
?>
```
