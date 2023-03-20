<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password'];

    public function getEmployeeByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function ubah($id, $data)
    {
        $builder = $this->db->table($this->table);
        $builder->where('id', $id);
        $builder->update($data);
    }
}
