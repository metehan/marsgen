<?php

require 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use Marsgen\Commands\GreetCommand;
use Marsgen\Commands\GenerateCommand;
use Marsgen\Commands\TestCommand;

$console = new Application('MarsGen', '.');
$console->add(new GreetCommand);
$console->add(new GenerateCommand);
$console->run();
