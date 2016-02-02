<?php
function e($shit)
{
    exit(var_dump($shit));
}

include '../src/karen.php';



Karen::initialize('../src/languages/');


_e('not_logged_in');

Karen::textDomain('template');

_e('welcome_title');

?>
