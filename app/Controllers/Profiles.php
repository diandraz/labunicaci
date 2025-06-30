<?php

namespace App\Controllers;

use App\Models\ProfilesModel;

class Profiles extends BaseController
{
    public function index()
    {
        $model = new ProfilesModel();
        $userId = session()->get('id_regis'); // Pastikan user login
        $data['user'] = $model->find($userId);
        return view('Profiles_form', $data);
    }

    public function update()
    {
        $model = new ProfilesModel();
        $userId = session()->get('id_regis');

        // Ambil user dari database
        $user = $model->find($userId);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Ambil inputan dari form
        $oldPassword = $this->request->getPost('old_password');
        $newPassword = $this->request->getPost('password');
        $repassword  = $this->request->getPost('repassword');
        $foto        = $this->request->getFile('foto_profil');

        $data = [];

        // Jika user mengisi password baru, wajib validasi password lama
        if (!empty($newPassword) || !empty($repassword)) {
            if (!password_verify($oldPassword, $user['password'])) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai.');
            }

            if ($newPassword !== $repassword) {
                return redirect()->back()->with('error', 'Password baru dan ulangi password tidak cocok.');
            }

            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // Proses upload foto profil jika ada
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaBaru = $foto->getRandomName();
            $foto->move('uploads/', $namaBaru);
            $data['foto_profil'] = $namaBaru;
        }

        // Update data di database
        if (!empty($data)) {
            $model->update($userId, $data);
            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Tidak ada data yang diubah.');
    }
}
