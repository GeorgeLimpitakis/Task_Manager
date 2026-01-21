<?php

require_once 'Task.php';

class TaskRepository
{
    private $pdo;

    public function __construct($dbPath = 'database.sqlite')
    {
        $this->pdo = new PDO("sqlite:" . $dbPath);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->init();
    }

    private function init()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS tasks (
            id TEXT PRIMARY KEY,
            username TEXT NOT NULL,
            title TEXT NOT NULL,
            description TEXT,
            deadline TEXT
        )");
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM tasks");
        $tasks = [];
        while ($row = $stmt->fetch()) {
            $tasks[] = new Task($row['id'], $row['username'], $row['title'], $row['description'], $row['deadline']);
        }
        return $tasks;
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row)
            return null;
        return new Task($row['id'], $row['username'], $row['title'], $row['description'], $row['deadline']);
    }

    public function create(Task $task)
    {
        // Generate ID based on creation date: YYYYMMDD-HHMMSS-microseconds
        $task->id = date('Ymd-His-') . substr(str_replace('0.', '', microtime()), 0, 4);

        $stmt = $this->pdo->prepare("INSERT INTO tasks (id, username, title, description, deadline) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$task->id, $task->username, $task->title, $task->description, $task->deadline]);
        return $task;
    }

    public function update(Task $task)
    {
        $stmt = $this->pdo->prepare("UPDATE tasks SET username = ?, title = ?, description = ?, deadline = ? WHERE id = ?");
        $stmt->execute([$task->username, $task->title, $task->description, $task->deadline, $task->id]);
        return $stmt->rowCount() > 0;
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
