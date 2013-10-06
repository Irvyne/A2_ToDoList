<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

class TodoManager
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * @param Todo $todo
     * @return bool
     */
    public function add(Todo $todo) {
        $sql = 'INSERT INTO todo (id, name, content) VALUES (NULL, :name, :content)';
        $prepare = $this->pdo->prepare($sql);
        $query = $prepare->execute(array(
            'name'      => $todo->getName(),
            'content'   => $todo->getContent(),
        ));
        if ($query) {
            $todo->setId($this->pdo->lastInsertId());
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function findAll() {
        $sql = "SELECT * FROM todo ORDER BY id DESC";
        $query = $this->pdo->query($sql);
        if ($query) {
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $todoList = array();
            foreach ($results as $attributes) {
                $todoList[] = new Todo($attributes);
            }
            return $todoList;
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool|Todo
     */
    public function find($id) {
        $sql = "SELECT * FROM todo WHERE id = :id";
        $prepare = $this->pdo->prepare($sql);
        $prepare->execute(array(
            'id' => $id,
        ));
        $attributes = $prepare->fetch(PDO::FETCH_ASSOC);
        if ($attributes)
            return new Todo($attributes);
        else
            return false;
    }

    /**
     * @param Todo $todo
     * @return bool
     */
    public function update(Todo $todo) {
        $sql = "UPDATE todo SET name = :name, content = :content WHERE id = :id";
        $prepare = $this->pdo->prepare($sql);
        return $prepare->execute(array(
            'id'        => $todo->getId(),
            'name'      => $todo->getName(),
            'content'   => $todo->getContent(),
        ));
    }

    /**
     * @param $parameter
     * @return PDOStatement
     */
    public function delete($parameter) {
        if ($parameter instanceof Todo) {
            $id = $parameter->getId();
        } else {
            $id = (int) $parameter;
        }
        $sql = "DELETE FROM todo WHERE id = ".$this->pdo->quote($id);
        return $this->pdo->query($sql);
    }
}