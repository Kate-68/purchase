<?php

require_once('config.php');

require_once("controllers/main.php");
require_once("models/main.php");
require_once("views/main.php");

$m = new Model();
$c = new Controller($m);
$v = new View($m, $c);

$v->show();