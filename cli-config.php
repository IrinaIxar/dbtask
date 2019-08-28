<?php
// cli-config.php
require_once "src/DoctrineEM.php";

$em = DoctrineEM::getInstance();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($em);