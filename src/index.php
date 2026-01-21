<?php

header("Content-Type: application/json");
require_once 'TaskRepository.php';

$repository = new TaskRepository();

$method = $_SERVER['REQUEST_METHOD'];
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$pathParts = explode('/', trim($path, '/'));

if ($path === '/' || $path === '') {
    header("Content-Type: text/html");
    readfile('ui.html');
    exit;
}

try {
    if ($pathParts[0] === 'tasks') {
        $id = isset($pathParts[1]) ? $pathParts[1] : null;

        switch ($method) {
            case 'GET':
                if ($id) {
                    $task = $repository->getById($id);
                    if ($task) {
                        echo json_encode($task->toArray());
                    } else {
                        http_response_code(404);
                        echo json_encode(["error" => "Task not found"]);
                    }
                } else {
                    $tasks = $repository->getAll();
                    echo json_encode(array_map(function ($t) {
                        return $t->toArray();
                    }, $tasks));
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents("php://input"), true);
                if (!isset($data['username']) || !isset($data['title'])) {
                    http_response_code(400);
                    echo json_encode(["error" => "Username and title are required"]);
                    break;
                }
                $task = new Task(null, $data['username'], $data['title'], $data['description'] ?? '', $data['deadline'] ?? '');
                $newTask = $repository->create($task);
                http_response_code(201);
                echo json_encode($newTask->toArray());
                break;

            case 'PUT':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(["error" => "ID required for update"]);
                    break;
                }
                $data = json_decode(file_get_contents("php://input"), true);
                $existing = $repository->getById($id);
                if (!$existing) {
                    http_response_code(404);
                    echo json_encode(["error" => "Task not found"]);
                    break;
                }
                $task = new Task(
                    $id,
                    $data['username'] ?? $existing->username,
                    $data['title'] ?? $existing->title,
                    $data['description'] ?? $existing->description,
                    $data['deadline'] ?? $existing->deadline
                );
                $repository->update($task);
                echo json_encode($task->toArray());
                break;

            case 'DELETE':
                if ($id) {
                    if ($repository->delete($id)) {
                        http_response_code(204);
                    } else {
                        http_response_code(404);
                        echo json_encode(["error" => "Task not found"]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(["error" => "ID required for deletion"]);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Method not allowed"]);
                break;
        }
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Not Found"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error: " . $e->getMessage()]);
}
