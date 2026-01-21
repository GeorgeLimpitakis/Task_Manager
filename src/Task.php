<?php

class Task {
    public $id;
    public $username;
    public $title;
    public $description;
    public $deadline;

    public function __construct($id = null, $username = '', $title = '', $description = '', $deadline = '') {
        $this->id = $id;
        $this->username = $username;
        $this->title = $title;
        $this->description = $description;
        $this->deadline = $deadline;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline
        ];
    }
}
