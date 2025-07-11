<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KelembagaanModel;

class AdminDashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk mengakses dashboard.');
        }
        $userModel = new \App\Models\UserModel();
        $berkasModel = new \App\Models\BerkasKlasterModel();

        // Klaster models
        $klaster1 = new \App\Models\Klaster1Model();
        $klaster2 = new \App\Models\Klaster2Model();
        $klaster3 = new \App\Models\Klaster3Model();
        $klaster4 = new \App\Models\Klaster4Model();
        $klaster5 = new \App\Models\Klaster5Model();

        $desaList = $userModel->where('role', 'operator')->findAll();

        foreach ($desaList as &$desa) {
            $userId = $desa['id'];
            $desa['status_input'] = $desa['status_input'] ?? 'belum';
            $desa['status_approve'] = $desa['status_approve'] ?? 'pending';
            $desa['input_by'] = $desa['username'] ?? '-';

            // Ambil waktu input terakhir
            $timestamps = [];
            foreach ([$klaster1, $klaster2, $klaster3, $klaster4, $klaster5] as $klasterModel) {
                $entry = $klasterModel->where('user_id', $userId)->orderBy('created_at', 'desc')->first();
                if ($entry && isset($entry['created_at'])) {
                    $timestamps[] = $entry['created_at'];
                }
            }
            $desa['created_at'] = !empty($timestamps) ? max($timestamps) : null;

            // Klaster terisi
            $klasterTerisi = [];
            if ($klaster1->where('user_id', $userId)->first())
                $klasterTerisi[] = 'Klaster 1';
            if ($klaster2->where('user_id', $userId)->first())
                $klasterTerisi[] = 'Klaster 2';
            if ($klaster3->where('user_id', $userId)->first())
                $klasterTerisi[] = 'Klaster 3';
            if ($klaster4->where('user_id', $userId)->first())
                $klasterTerisi[] = 'Klaster 4';
            if ($klaster5->where('user_id', $userId)->first())
                $klasterTerisi[] = 'Klaster 5';

            $desa['klaster_isi'] = !empty($klasterTerisi) ? implode(', ', $klasterTerisi) : '-';
        }

        // Hitung status dari berkas_klaster
        $approved = $berkasModel->where('status', 'approved')->countAllResults(false);
        $rejected = $berkasModel->where('status', 'rejected')->countAllResults(false);

        // ✅ Hitung “perlu approve” dari semua klaster yang statusnya "pending"
        $perluApproveCount = $klaster1->where('status', 'pending')->countAllResults(false)
            + $klaster2->where('status', 'pending')->countAllResults(false)
            + $klaster3->where('status', 'pending')->countAllResults(false)
            + $klaster4->where('status', 'pending')->countAllResults(false)
            + $klaster5->where('status', 'pending')->countAllResults(false);

        $data = [
            'totalDesa' => count($desaList),
            'sudahInput' => count(array_filter($desaList, fn($d) => $d['status_input'] === 'sudah')),
            'belumInput' => count(array_filter($desaList, fn($d) => $d['status_input'] === 'belum')),
            'perluApprove' => $perluApproveCount,
            'totalApproved' => $approved,
            'totalRejected' => $rejected,
            'desaList' => $desaList,
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
        // $users = $userModel->findAll();
        $users = $userModel->where('role', 'operator')->findAll();



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
        $berkasModel = new \App\Models\BerkasKlasterModel();

        // Ambil data kelembagaan
        $kelembagaan = $kelembagaanModel->where('user_id', $id)->first();

        if (!$kelembagaan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data kelembagaan tidak ditemukan');
        }

        // Ambil data berkas (untuk tombol Approve/Reject)
        $berkas = $berkasModel->where('user_id', $id)->findAll();

        return view('pages/admin/review_kelembagaan', [
            'kelembagaan' => $kelembagaan,
            'berkas' => $berkas,
            'user_id' => $id
        ]);
    }

public function deleteKelembagaan()
{
    $userId = $this->request->getPost('user_id');

    if (!$userId) {
        return redirect()->back()->with('error', 'User ID tidak valid.');
    }

    $kelembagaanModel = new \App\Models\KelembagaanModel();

    // Ambil data rejected terbaru
    $data = $kelembagaanModel
        ->where('user_id', $userId)
        ->where('status', 'rejected')
        ->orderBy('id', 'desc')
        ->first();

    if (!$data) {
        return redirect()->back()->with('error', 'Data tidak ditemukan atau tidak berstatus rejected.');
    }

    // Hapus semua file terkait jika ada
    $fields = ['peraturan_file', 'anggaran_file', 'forum_anak_file', 'data_terpilah_file', 'dunia_usaha_file'];
    foreach ($fields as $field) {
        if (!empty($data[$field])) {
            $filePath = ROOTPATH . 'public/uploads/kelembagaan/' . $data[$field];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    // Hapus data dari DB secara permanen
    $kelembagaanModel->where('id', $data['id'])->delete(null, true);

    // Redirect ke halaman approve per user
    return redirect()->to(base_url('dashboard/admin/approve/' . $userId))
        ->with('success', 'Data kelembagaan berhasil dihapus permanen.');
}

public function deleteKlaster1()
{
    $userId = $this->request->getPost('user_id');

    if (!$userId) {
        return redirect()->back()->with('error', 'User ID tidak valid.');
    }

    $klaster1Model = new \App\Models\Klaster1Model();

    $data = $klaster1Model
        ->where('user_id', $userId)
        ->where('status', 'rejected')
        ->orderBy('id', 'desc')
        ->first();

    if (!$data) {
        return redirect()->back()->with('error', 'Data tidak ditemukan atau tidak berstatus rejected.');
    }

    if (!empty($data['file'])) {
        $filePath = ROOTPATH . 'public/uploads/klaster1/' . $data['file'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    $klaster1Model->delete($data['id'], true);

    return redirect()->to('dashboard/admin/approve/' . $userId)->with('success', 'Data Klaster1 berhasil dihapus.');
}



    public function reviewKlaster1($id)
    {
        return $this->reviewKlaster($id, 1);
    }

    public function reviewKlaster2($id)
    {
        return $this->reviewKlaster($id, 2);
    }

    public function reviewKlaster3($id)
    {
        return $this->reviewKlaster($id, 3);
    }

    public function reviewKlaster4($id)
    {
        return $this->reviewKlaster($id, 4);
    }

    public function reviewKlaster5($id)
    {
        return $this->reviewKlaster($id, 5);
    }

    // ✅ Fungsi reusable untuk klaster 1–5
    private function reviewKlaster($id, $klasterNumber)
    {
        $modelClass = "\\App\\Models\\Klaster{$klasterNumber}Model";
        if (!class_exists($modelClass)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Model Klaster {$klasterNumber} tidak ditemukan.");
        }

        $model = new $modelClass();
        $data = $model->where('user_id', $id)->first();

        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data Klaster {$klasterNumber} tidak ditemukan.");
        }

        return view("pages/admin/review_klaster{$klasterNumber}", [
            "klaster{$klasterNumber}" => $data,
            'user_id' => $id
        ]);
    }



    public function submitReviewKelembagaan()
    {
        $model = new KelembagaanModel();

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
    public function berkas()
    {
        return view('pages/admin/berkas');
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

        // Siapkan struktur data klaster untuk ditampilkan di view
        $data = [
            'user_id' => $id,
            'kelembagaan' => [],
            'klaster1' => [],
            'klaster2' => [],
            'klaster3' => [],
            'klaster4' => [],
            'klaster5' => [],
            'status' => [], // akan diisi berdasarkan masing-masing data
        ];

        // Kelembagaan
        if (!empty($kelembagaanData) && is_array($kelembagaanData)) {
            $data['kelembagaan'][] = $kelembagaanData;
            $data['status']['kelembagaan'] = $kelembagaanData['status'] ?? 'pending';
        }

        // Klaster 1
        if (!empty($klaster1Data) && is_array($klaster1Data)) {
            $data['klaster1'][] = $klaster1Data;
            $data['status']['klaster1'] = $klaster1Data['status'] ?? 'pending';
        }

        // Klaster 2
        if (!empty($klaster2Data) && is_array($klaster2Data)) {
            $data['klaster2'][] = $klaster2Data;
            $data['status']['klaster2'] = $klaster2Data['status'] ?? 'pending';
        }

        // Klaster 3
        if (!empty($klaster3Data) && is_array($klaster3Data)) {
            $data['klaster3'][] = $klaster3Data;
            $data['status']['klaster3'] = $klaster3Data['status'] ?? 'pending';
        }

        // Klaster 4
        if (!empty($klaster4Data) && is_array($klaster4Data)) {
            $data['klaster4'][] = $klaster4Data;
            $data['status']['klaster4'] = $klaster4Data['status'] ?? 'pending';
        }

        // Klaster 5
        if (!empty($klaster5Data) && is_array($klaster5Data)) {
            $data['klaster5'][] = $klaster5Data;
            $data['status']['klaster5'] = $klaster5Data['status'] ?? 'pending';
        }

        return view('pages/admin/approve', $data);
    }

    public function setujui($id)
    {
        $userModel = new \App\Models\UserModel();

        $userModel->update($id, [
            'status_approve' => 'approved'
        ]);

        return redirect()->to('/dashboard/admin/approval')->with('success', 'Data desa berhasil disetujui.');
    }

    public function downloadFile()
    {
        $filename = $this->request->getGet('file');
        $folder = $this->request->getGet('folder');

        // Validasi folder agar hanya yang diizinkan
        $allowedFolders = ['kelembagaan', 'klaster1', 'klaster2', 'klaster3', 'klaster4', 'klaster5']; // tambahkan sesuai kebutuhan

        if (!in_array($folder, $allowedFolders)) {
            return redirect()->back()->with('error', 'Folder tidak valid.');
        }

        $filepath = FCPATH . 'uploads/' . $folder . '/' . $filename;

        if (file_exists($filepath)) {
            return $this->response->download($filepath, null);
        }

        return redirect()->back()->with('error', message: 'File tidak ditemukan.');
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

        $data['users'] = $userModel->where('role', 'operator')->findAll();

        return view('pages/admin/approve_list', $data);
    }


    public function settings()
    {
        return view('pages/admin/settings');
    }


}
