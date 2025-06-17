<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminDashboard extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        $totalDesa = $userModel->where('role', 'operator')->countAllResults();
        $sudahInput = $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults();
        $belumInput = $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults();
        $perluApprove = $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults();

        $data = [
            'title' => 'Dashboard Admin',
            'totalDesa' => $totalDesa,
            'sudahInput' => $sudahInput,
            'belumInput' => $belumInput,
            'perluApprove' => $perluApprove,
        ];

        return view('pages/admin/dashboard', $data);
    }

    public function users()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('errors', ['Akses tidak diizinkan']);
        }

        $userModel = new UserModel();
        $users = $userModel->findAll();

        $data = [
            'users' => $users,
            'title' => 'Kelola User',
            'status' => 'status_input',
        ];

        return view('pages/admin/users', $data);
    }

    public function storeUser()
    {
        $userModel = new UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'desa' => $this->request->getPost('desa'),
            'status_input' => 'belum',
            'status_approve' => 'pending',
        ];

        $userModel->save($data);

        return redirect()->to('/dashboard/users')->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/dashboard/users')->with('error', 'User tidak ditemukan.');
        }

        return view('pages/admin/edit_user', ['user' => $user, 'title' => 'Edit User']);
    }

    public function updateUser($id)
    {
        $userModel = new UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'desa' => $this->request->getPost('desa'),
            'status_input' => $this->request->getPost('status_input'),
            'status_approve' => $this->request->getPost('status_approve'),
        ];

        // Optional: jika password diisi, update juga password
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($id, $data);

        return redirect()->to('/dashboard/users')->with('success', 'User berhasil diperbarui.');
    }

    public function delete($id)
    {
        $userModel = new \App\Models\UserModel();

        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        $userModel->delete($id);

        return redirect()->to('/dashboard/users')->with('success', 'Pengguna berhasil dihapus.');
    }
    public function approveAction()
    {
        $userId = $this->request->getPost('user_id');
        $table = $this->request->getPost('table');
        $action = $this->request->getPost('action'); // 'approved' or 'rejected'

        if (!in_array($action, ['approved', 'rejected'])) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        // Dynamic model call
        $modelClass = '\\App\\Models\\' . ucfirst($table) . 'Model';
        if (!class_exists($modelClass)) {
            return redirect()->back()->with('error', 'Model tidak ditemukan.');
        }

        $model = new $modelClass();
        $model->where('user_id', $userId)->set(['status' => $action])->update();

        return redirect()->back()->with('success', ucfirst($table) . ' berhasil di-' . $action);
    }
    public function reviewKelembagaan($id)
    {
        $kelembagaanModel = new \App\Models\KelembagaanModel();
        $data = $kelembagaanModel->where('user_id', $id)->first();

        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('pages/admin/review_kelembagaan', [
            'kelembagaan' => $data,
            'user_id' => $id
        ]);
    }
    public function reviewKlaster1($id)
    {
        $klaster1Model = new \App\Models\Klaster1Model();
        $data = $klaster1Model->where('user_id', $id)->first();

        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('pages/admin/review_klaster1', [
            'klaster1' => $data,
            'user_id' => $id
        ]);
    }


    public function submitReviewKelembagaan()
    {
        $model = new \App\Models\KelembagaanModel();

        $user_id = $this->request->getPost('user_id');
        $status = $this->request->getPost('status'); // approved / rejected

        if (!in_array($status, ['approved', 'rejected'])) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $model->where('user_id', $user_id)->set(['status' => $status])->update();

        return redirect()->to('dashboard/admin/approve/' . $user_id)->with('success', 'Status kelembagaan diperbarui.');
    }

    public function desa()
    {
        return view('pages/admin/desa');
    }


    public function approval()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('errors', ['Akses tidak diizinkan']);
        }

        $userModel = new UserModel();
        $desasPendingApproval = $userModel->where('role', 'operator')
            ->where('status_input', 'sudah')
            ->where('status_approve', 'pending')
            ->findAll();

        $data = [
            'title' => 'Approval Data Desa',
            'desas' => $desasPendingApproval,
        ];

        return view('pages/admin/approval', $data);
    }

    public function approve($id)
    {
        // Panggil semua model klaster
        $kelembagaanModel = new \App\Models\KelembagaanModel();
        $klaster1Model = new \App\Models\Klaster1Model();
        $klaster2Model = new \App\Models\Klaster2Model();
        $klaster3Model = new \App\Models\Klaster3Model();
        $klaster4Model = new \App\Models\Klaster4Model();
        $klaster5Model = new \App\Models\Klaster5Model();

        // Ambil data masing-masing klaster berdasarkan user_id
        $kelembagaanData = $kelembagaanModel->where('user_id', $id)->first();
        $klaster1Data = $klaster1Model->where('user_id', $id)->first();
        $klaster2Data = $klaster2Model->where('user_id', $id)->first();
        $klaster3Data = $klaster3Model->where('user_id', $id)->first();
        $klaster4Data = $klaster4Model->where('user_id', $id)->first();
        $klaster5Data = $klaster5Model->where('user_id', $id)->first();

        // Siapkan data array untuk view
        $data = [
            'user_id' => $id,
            'kelembagaan' => $kelembagaanData ? [$kelembagaanData] : [],
            'klaster1' => $klaster1Data ? [$klaster1Data] : [],
            'klaster2' => $klaster2Data ? [$klaster2Data] : [],
            'klaster3' => $klaster3Data ? [$klaster3Data] : [],
            'klaster4' => $klaster4Data ? [$klaster4Data] : [],
            'klaster5' => $klaster5Data ? [$klaster5Data] : [],
        ];

        return view('pages/admin/approve', $data);
    }

    public function downloadFile()
    {
        $filename = $this->request->getGet('file');
        $filepath = FCPATH . 'uploads/kelembagaan/' . $filename;

        if (file_exists($filepath)) {
            return $this->response->download($filepath, null);
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }
    public function rejectDesa($userId)
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('errors', ['Akses tidak diizinkan']);
        }

        $userModel = new UserModel();
        $userModel->update($userId, ['status_approve' => 'rejected']);

        return redirect()->to('/admin/approval')->with('success', 'Data desa berhasil ditolak.');
    }


    public function laporan()
    {
        return view('pages/admin/laporan');
    }

    public function approveList()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();

        return view('pages/admin/approve_list', $data);
    }

    public function settings()
    {
        return view('pages/admin/settings');
    }


}
