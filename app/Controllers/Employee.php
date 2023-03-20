<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Request;

class Employee extends Controller
{
    public function index()
    {
        // Membuat instance dari model EmployeeModel
        $model = new EmployeeModel();

        // Mengambil semua data pegawai dari tabel employees
        $employees = $model->findAll();

        // Menampilkan data pegawai ke view
        return view('employee/employee_list', ['employees' => $employees]);
    }

    public function login()
    {
        // Menangani form login
        if ($this->request->getMethod() === 'post') {
            // Membuat instance dari model EmployeeModel
            $model = new EmployeeModel();

            // Mendapatkan data dari form login
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Memeriksa apakah email dan password yang dimasukkan valid
            $employee = $model->getEmployeeByEmail($email);
            if ($employee && password_verify($password, $employee['password'])) {
                // Jika email dan password valid, maka buat sesi untuk pegawai
                $session = session();
                $session->set('employee_id', $employee['id']);
                return redirect()->to('/dashboard');
            } else {
                // Jika email dan password tidak valid, tampilkan pesan kesalahan
                $data['error'] = 'Invalid email or password';
            }
        }

        // Menampilkan halaman login
        return view('login', $data);
    }

    public function edit($id)
    {
        $employeeModel = new EmployeeModel();
        $employee = $employeeModel->find($id);

        if ($employee === null) {
            return redirect()->to('/employee')->with('error', 'Employee not found');
        }

        $data = [
            'title' => 'Edit Employee',
            'employee' => $employee,
        ];

        return view('employee/employee_edit', $data);
    }
    public function update($id)
    {
        // Validasi data yang diterima dari form
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'name' => 'required',
            'email' => 'required|valid_email',
            'password' => 'permit_empty|min_length[6]',
        ]);

        // Ambil data dari form
        $data = $this->request->getPost();

        // Cek apakah data valid
        if (!$validation->run($data)) {
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }

        // Update data pada database
        $employeeModel = new EmployeeModel();
        $employeeModel->ubah($id, $data);

        // Redirect ke halaman employee list
        return redirect()->to('/employee')->with('success', 'Employee updated successfully');
    }

    public function logout()
    {
        // Menghapus sesi pegawai dan mengalihkan ke halaman login
        $session = session();
        $session->remove('employee_id');
        return redirect()->to('/login');
    }
}
