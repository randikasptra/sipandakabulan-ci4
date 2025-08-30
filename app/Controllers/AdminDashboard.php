<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KelembagaanModel;
use App\Models\BerkasKlasterModel;
use App\Models\Klaster1Model;
use App\Models\Klaster2Model;
use App\Models\Klaster3Model;
use App\Models\Klaster4Model;
use App\Models\Klaster5Model;

class AdminDashboard extends BaseController
{
 public function index()
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login')->with('error', 'Silakan login untuk mengakses dashboard.');
    }

    $userModel      = new UserModel();
    $kelembagaan    = new KelembagaanModel();
    $klaster1       = new Klaster1Model();
    $klaster2       = new Klaster2Model();
    $klaster3       = new Klaster3Model();
    $klaster4       = new Klaster4Model();
    $klaster5       = new Klaster5Model();

    $desaList = $userModel->where('role', 'operator')->findAll();

    foreach ($desaList as &$desa) {
        $userId = $desa['id'];
        $desa['status_input'] = $desa['status_input'] ?? 'belum';
        $desa['status_approve'] = $desa['status_approve'] ?? 'pending';
        $desa['input_by'] = $desa['username'] ?? '-';

        $timestamps = [];
        foreach ([$klaster1, $klaster2, $klaster3, $klaster4, $klaster5] as $klasterModel) {
            $entry = $klasterModel->where('user_id', $userId)->orderBy('created_at', 'desc')->first();
            if ($entry && isset($entry['created_at'])) {
                $timestamps[] = $entry['created_at'];
            }
        }
        $desa['created_at'] = !empty($timestamps) ? max($timestamps) : null;

        $klasterTerisi = [];
        if ($klaster1->where('user_id', $userId)->first()) $klasterTerisi[] = 'Klaster 1';
        if ($klaster2->where('user_id', $userId)->first()) $klasterTerisi[] = 'Klaster 2';
        if ($klaster3->where('user_id', $userId)->first()) $klasterTerisi[] = 'Klaster 3';
        if ($klaster4->where('user_id', $userId)->first()) $klasterTerisi[] = 'Klaster 4';
        if ($klaster5->where('user_id', $userId)->first()) $klasterTerisi[] = 'Klaster 5';

        $desa['klaster_isi'] = !empty($klasterTerisi) ? implode(', ', $klasterTerisi) : '-';
    }

    // Hitung total input (semua tabel ada isinya)
    $totalInput =
        $kelembagaan->countAll() +
        $klaster1->countAll() +
        $klaster2->countAll() +
        $klaster3->countAll() +
        $klaster4->countAll() +
        $klaster5->countAll();

    // Approved
    $totalApproved =
        $kelembagaan->where('status', 'approved')->countAllResults() +
        $klaster1->where('status', 'approved')->countAllResults() +
        $klaster2->where('status', 'approved')->countAllResults() +
        $klaster3->where('status', 'approved')->countAllResults() +
        $klaster4->where('status', 'approved')->countAllResults() +
        $klaster5->where('status', 'approved')->countAllResults();

    // Rejected
    $totalRejected =
        $kelembagaan->where('status', 'rejected')->countAllResults() +
        $klaster1->where('status', 'rejected')->countAllResults() +
        $klaster2->where('status', 'rejected')->countAllResults() +
        $klaster3->where('status', 'rejected')->countAllResults() +
        $klaster4->where('status', 'rejected')->countAllResults() +
        $klaster5->where('status', 'rejected')->countAllResults();

    // Perlu Approve
    $perluApproveCount =
        $klaster1->where('status', 'pending')->countAllResults() +
        $klaster2->where('status', 'pending')->countAllResults() +
        $klaster3->where('status', 'pending')->countAllResults() +
        $klaster4->where('status', 'pending')->countAllResults() +
        $klaster5->where('status', 'pending')->countAllResults();

    // Ambil 5 data terbaru dari semua tabel
    $combined = [];
    $tables = [
        ['model' => $kelembagaan, 'label' => 'Kelembagaan'],
        ['model' => $klaster1, 'label' => 'Klaster 1'],
        ['model' => $klaster2, 'label' => 'Klaster 2'],
        ['model' => $klaster3, 'label' => 'Klaster 3'],
        ['model' => $klaster4, 'label' => 'Klaster 4'],
        ['model' => $klaster5, 'label' => 'Klaster 5'],
    ];

    foreach ($tables as $tbl) {
        $rows = $tbl['model']->orderBy('created_at', 'desc')->findAll(5);
        foreach ($rows as $r) {
            $combined[] = [
                'nama_klaster' => $tbl['label'],
                'user_id' => $r['user_id'],
                'tahun' => $r['tahun'] ?? '-',
                'bulan' => $r['bulan'] ?? '-',
                'status' => $r['status'] ?? '-',
                'created_at' => $r['created_at'] ?? '-',
            ];
        }
    }

    usort($combined, fn($a, $b) => strtotime($b['created_at']) <=> strtotime($a['created_at']));
    $latestCombined = array_slice($combined, 0, 5);

    foreach ($latestCombined as &$item) {
        $user = $userModel->find($item['user_id']);
        $item['nama_desa'] = $user['desa'] ?? 'Unknown';
    }

    $data = [
        'totalDesa' => count($desaList),
        'sudahInput' => $totalInput,
        'belumInput' => count(array_filter($desaList, fn($d) => $d['status_input'] === 'belum')),
        'totalApproved' => $totalApproved,
        'totalRejected' => $totalRejected,
        'perluApprove' => $perluApproveCount,
        'desaList' => $desaList,
        'latestCombined' => $latestCombined,
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
       
    ];

    try {
        $userModel->save($data);
        return redirect()->to('/dashboard/users')->with('success', 'User berhasil ditambahkan.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menambahkan user. Silakan coba lagi.');
    }
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

    
    return redirect()->to('dashboard/admin/approve/' . $userId)->with('success', 'Data di Tolak.');

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


  public function hapusSemuaPengajuan()
{
    $db = \Config\Database::connect();

    // Hapus semua data 'pending' dari masing-masing tabel
    $tables = ['kelembagaan', 'klaster1', 'klaster2', 'klaster3', 'klaster4', 'klaster5'];

    foreach ($tables as $table) {
        $db->table($table)->where('status', 'pending')->delete();
    }

    // Setelah dihapus, ambil ulang data untuk halaman approve
    $data = [
        'title' => 'Pending Approvals',
        'kelembagaan' => $db->table('kelembagaan')->where('status', 'pending')->get()->getResult(),
        'klaster1' => $db->table('klaster1')->where('status', 'pending')->get()->getResult(),
        'klaster2' => $db->table('klaster2')->where('status', 'pending')->get()->getResult(),
        'klaster3' => $db->table('klaster3')->where('status', 'pending')->get()->getResult(),
        'klaster4' => $db->table('klaster4')->where('status', 'pending')->get()->getResult(),
        'klaster5' => $db->table('klaster5')->where('status', 'pending')->get()->getResult(),
        'success' => 'Semua data pending berhasil dihapus.'
    ];

    return view('pages/admin/approve', $data);
}


public function hapusSemuaApprove()
{
    $db = \Config\Database::connect();
    $tables = ['kelembagaan', 'klaster1', 'klaster2', 'klaster3', 'klaster4', 'klaster5'];

    foreach ($tables as $table) {
        try {
            $db->table($table)->where('LOWER(status)', 'approve')->delete();
        } catch (\Exception $e) {
            log_message('error', "Gagal hapus di $table: " . $e->getMessage());
        }
    }

    $data = [
        'title' => 'Pending Approvals',
        'kelembagaan' => $db->table('kelembagaan')->where('status', 'approve')->get()->getResult(),
        'klaster1' => $db->table('klaster1')->where('status', 'approve')->get()->getResult(),
        'klaster2' => $db->table('klaster2')->where('status', 'approve')->get()->getResult(),
        'klaster3' => $db->table('klaster3')->where('status', 'approve')->get()->getResult(),
        'klaster4' => $db->table('klaster4')->where('status', 'approve')->get()->getResult(),
        'klaster5' => $db->table('klaster5')->where('status', 'approve')->get()->getResult(),
        'success' => 'Semua data yang sudah di-approve berhasil dihapus.'
    ];

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
    $userModel = new \App\Models\UserModel();
    $kelembagaanModel = new \App\Models\KelembagaanModel();
    $klaster1Model = new \App\Models\Klaster1Model();
    $klaster2Model = new \App\Models\Klaster2Model();
    $klaster3Model = new \App\Models\Klaster3Model();
    $klaster4Model = new \App\Models\Klaster4Model();
    $klaster5Model = new \App\Models\Klaster5Model();

    // Ambil semua operator
    $users = $userModel->where('role', 'operator')->findAll();

    foreach ($users as &$user) {
        $progress = 0;
        $total = 6; // 5 klaster + kelembagaan
        $statuses = [];

        // Klaster 1
        $k1 = $klaster1Model->where('user_id', $user['id'])->first();
        if ($k1) {
            $progress++;
            $statuses[] = strtolower($k1['status'] ?? 'pending');
        }

        // Klaster 2
        $k2 = $klaster2Model->where('user_id', $user['id'])->first();
        if ($k2) {
            $progress++;
            $statuses[] = strtolower($k2['status'] ?? 'pending');
        }

        // Klaster 3
        $k3 = $klaster3Model->where('user_id', $user['id'])->first();
        if ($k3) {
            $progress++;
            $statuses[] = strtolower($k3['status'] ?? 'pending');
        }

        // Klaster 4
        $k4 = $klaster4Model->where('user_id', $user['id'])->first();
        if ($k4) {
            $progress++;
            $statuses[] = strtolower($k4['status'] ?? 'pending');
        }

        // Klaster 5
        $k5 = $klaster5Model->where('user_id', $user['id'])->first();
        if ($k5) {
            $progress++;
            $statuses[] = strtolower($k5['status'] ?? 'pending');
        }

        // Kelembagaan
        $kel = $kelembagaanModel->where('user_id', $user['id'])->first();
        if ($kel) {
            $progress++;
            $statuses[] = strtolower($kel['status'] ?? 'pending');
        }

        // Simpan progress
        $user['progress'] = $progress . '/' . $total;
        $user['progress_percent'] = ($progress / $total) * 100;

        // ✅ Cek selesai: harus 6/6 dan semua status "approved"
        $user['is_complete'] = (
            $progress === $total &&
            count(array_filter($statuses, fn($s) => $s === 'approved')) === $total
        );
    }

    $data['users'] = $users;
    return view('pages/admin/approve_list', $data);
}





    public function settings()
    {
        return view('pages/admin/settings');
    }


}
