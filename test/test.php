<?php
function e($shit)
{
    exit(var_dump($shit));
}

include '../src/karen.php';



Karen::initialize('../src/languages/');

e(Karen::$library);

?>