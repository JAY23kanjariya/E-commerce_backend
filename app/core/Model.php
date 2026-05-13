<?php

/*
|--------------------------------------------------------------------------
| Base Model Class
|--------------------------------------------------------------------------
|
| This class acts as the parent/base model for all database models
| in the application. It provides common database operations
| that can be reused by child models.
|
| Purpose:
| - Manage database interaction
| - Reduce repeated SQL code
| - Provide reusable CRUD helper methods
| - Connect models with the database layer
|
| Main Features:
| - Automatic database connection using PDO
| - Find single record by column value
| - Insert new records into database
| - Reusable for all application models
|
| How It Works:
|
| 1. When model object is created:
|    -> Database connection is initialized
|
| 2. Child models define table name:
|
|    protected $table = 'users';
|
| 3. Base methods automatically use that table
|
| Example Child Model:
|
| class User extends Model
| {
|     protected $table = 'users';
| }
|
| Example Usage:
|
| $userModel = new User();
|
| Find User:
| $user = $userModel->findBy('email', 'jay@example.com');
|
| Create User:
| $userModel->create([
|     'name' => 'Jay',
|     'email' => 'jay@example.com'
| ]);
|
| Methods:
|
| findBy($column, $value)
| -> Fetch single record using WHERE condition
|
| create($data)
| -> Insert new record into database
|
| Security:
|
| PDO Prepared Statements are used to:
| - Prevent SQL Injection
| - Safely bind user input values
|
| Important PDO Functions:
|
| prepare()
| -> Prepares SQL query securely
|
| execute()
| -> Executes prepared query
|
| fetch(PDO::FETCH_ASSOC)
| -> Returns result as associative array
|
*/

namespace App\core;

use PDO;

class Model
{
    protected $table;
    protected $db;

    public function __construct()
    {
        $this->db =  Database::connect();
    }

    public function findBy($column, $value)
    {
        $query = "SELECT * FROM {$this->table} WHERE {$column} =:value LIMIT 1";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            'value' => $value
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";

        $stmt = $this->db->prepare($query);

        return $stmt->execute($data);
    }

    public function updateBy($column, $value, $data)
    {
        $fields = [];

        foreach ($data as $key => $val) {
            $fields[] = "{$key} = :{$key}";
        }

        $fields = implode(', ', $fields);

        $query = "UPDATE {$this->table} SET {$fields} WHERE {$column} =:whereValue";

        $stmt = $this->db->prepare($query);

        $data['whereValue'] = $value;

        return $stmt->execute($data);
    }
}
