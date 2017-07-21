# simple-logger

Logger Class, has ability to email alerts and/or echo them to stdout, for email and stdout min loglevels are configured. 

Common use:

```php
<?php
require_once('./SimpleLogger.php');

$logger = new SimpleLogger('./log.txt');
$logger->setStdOutLevel(LOG_CRIT);
$logger->setEmailHandler('email@example.com', 'Warmup');

$logger->log('test');
$logger->log('test crit', LOG_CRIT);
$logger->log('test debug', LOG_DEBUG);
?>
```
