<?php

function load($class_name) {
    $paths = array(
        'C:\xampp\htdocs\Groovy\includes',
        'C:\xampp\htdocs\Groovy\includes\classes',
    );
    foreach($paths as $path) {
        $file = $path.'\\'.$class_name.'.php';
        if(file_exists($file)) {
            include_once($file);
            return;
        }
    }
}

spl_autoload_register('load');

?>