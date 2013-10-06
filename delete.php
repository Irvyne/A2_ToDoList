<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

require __DIR__.'/autoload.php';
require __DIR__.'/config/config.php';

$myPDO = new MyPDO($config);
$todoManager = new TodoManager($myPDO->getPDO());

if (empty($_GET['id']))
    header('Location: index.php');

$id = (int) $_GET['id'];

if ($todo = $todoManager->find($id))
    $todoManager->delete($todo);

header('Location: index.php');