<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

require __DIR__.'/autoload.php';
require __DIR__.'/config/config.php';

$myPDO = new MyPDO($config);
$todoManager = new TodoManager($myPDO->getPDO());
$todoList = $todoManager->findAll();

include 'templates/_header.php';

foreach ($todoList as $todo) {
    echo '<article>';
        echo '<h1><em>'.$todo->getId().'</em> - '.$todo->getName().'</h1>';
        echo '<p>'.$todo->getContent().'</p>';
        echo '<a href="edit.php?id='.$todo->getId().'">Edit</a>';
        echo ' | ';
        echo '<a href="delete.php?id='.$todo->getId().'">Delete</a>';
    echo '</article>';
}

include 'templates/_footer.php';