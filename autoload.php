<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

spl_autoload_register(function($className) {
    $classPath = __DIR__.'/Class/'.$className.'.php';
    if (file_exists($classPath))
        require_once __DIR__.'/Class/'.$className.'.php';
});