# simple-logger

Logger Class, has ability to email alerts and/or echo them to stdout, for email and stdout min loglevels are configured.

Install with composer (latest version from master):

```
{
    "require": {
        "akishkin/simple-logger": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:akishkin/simple-logger.git"
        }
    ]
}
```

Common use:

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

$logger = new akishkin\SimpleLogger('./log.txt', LOG_DEBUG);
$logger->setStdOutLevel(LOG_DEBUG);
// add email handler (it uses php mail() function, so mail system should be configured before)
// $logger->setEmailHandler('email@example.com', 'Warmup');

$logger->info('test');
$logger->critical('test crit');
$logger->debug('test debug');

// add process identificator (I use it for identifying users/threads/processes, log can be grepped with needed id to get info about some user/process/thread)
// all future messages will have it, once it was set, so no need to keep it in mind and put in every log message
$logger->addProcessId('test-1234');
$logger->info('test process id');

$logger->addProcessId('User:Admin');
$logger->info('Added 2nd Id');

$logger->removeProcessId('User:Admin');
$logger->info('Removed process id');
?>
```

log file and output will look like:
```
[2017-09-26 15:49:08] INFO test
[2017-09-26 15:49:08] CRITICAL test crit
[2017-09-26 15:49:08] DEBUG test debug
[2017-09-26 15:49:08] INFO [test-1234] test process id
[2017-09-26 15:49:08] INFO [test-1234] [User:Admin] Added 2nd Id
[2017-09-26 15:49:08] INFO [test-1234] Removed process id

```
