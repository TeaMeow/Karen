<?php
function e($shit)
{
    exit(var_dump($shit));
}

include '../src/karen.php';



Karen::initialize('../src/languages/');

?>


<div><?= __('welcome_title'); ?></div>