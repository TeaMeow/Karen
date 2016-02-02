<?php
function e($shit)
{
    exit(var_dump($shit));
}

include '../src/karen.php';



Karen::initialize('../src/languages/', 'en_us');

_ef(__('not_logged_in'), ['nickname' => 'Yami Odymel']);

?>
