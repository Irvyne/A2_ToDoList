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
$todo = $todoManager->find($id);

if (isset($_POST['submit'])) {
    if (!empty($_POST['name']) && !empty($_POST['content'])) {
        $todo->setName($_POST['name']);
        $todo->setContent($_POST['content']);
        if ($todoManager->update($todo)) {
            header('Location: index.php');
        } else {
            $error_msg = 'Erreur lors de la mise à jour de la todo !';
        }
    } else {
        $error_msg = 'Tous les champs sont obligatoires';
    }
}

include 'templates/_header.php';
?>
    <h1>Edit todo n°<?php echo $todo->getId(); ?></h1>
    <?php if (!empty($error_msg)) echo '<p style="color: red;">'.$error_msg.'</p>'; ?>
    <form method="post">
        <label for="name">Nom de la tâche :</label>
            <input type="text" name="name" id="name" value="<?php echo $todo->getName(); ?>" required><br>
        <label for="content">Contenu de la tâche :</label>
            <textarea name="content" id="content" placeholder="contenu..." required><?php echo $todo->getContent(); ?></textarea><br>
        <input type="submit" name="submit" value="Créer la tâche !">
    </form>
<?php
include 'templates/_footer.php';