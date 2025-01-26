<?php
require_once __DIR__ . '/../includes/Database.php';

abstract class Model {
    protected $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }
}