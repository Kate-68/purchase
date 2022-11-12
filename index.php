<?php
session_start();

// function muj_autoloader($nazevTridy) {
//     require_once "class/{$nazevTridy}.php";
// }

// spl_autoload_register('muj_autoloader');

require_once("controllers/main.php");
require_once("models/main.php");
require_once("views/main.php");

$m = new Model();
$c = new Controller($m);
$v = new View($m, $c);

$v->show();