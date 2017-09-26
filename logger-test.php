<?php
// require_once('./lib/SimpleLogger.php');
require_once __DIR__ . '/../vendor/autoload.php';

$logger = new akishkin\SimpleLogger('./log.txt', LOG_DEBUG);
$logger->setStdOutLevel(LOG_DEBUG);
// add email handler (it uses php mail() function, so mail system should be configured before)
// $logger->setEmailHandler('email@example.com', 'Warmup');

$logger->info('test');
$logger->critical('test crit');
$logger->debug('test debug');

// add process identificator
$logger->addProcessId('test-1234');
$logger->info('test process id');

$logger->addProcessId('User:Admin');
$logger->info('Added 2nd Id');

$logger->removeProcessId('User:Admin');
$logger->info('Removed process id');
?>
