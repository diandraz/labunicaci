<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlatModel;
use App\Models\BahanModel;
use App\Models\InstrumenModel;
use App\Models\LogalatModel;
use App\Models\LogbahanModel;
use CodeIgniter\I18n\Time;

class Manajemen extends BaseController
{
    protected $alatModel;
    protected $bahanModel;
    protected $instrumenModel;
    protected $logalatModel;
    protected $logbahanModel;

    public function __construct()
    {
        $this->alatModel = new AlatModel();
        $this->bahanModel = new BahanModel();
        $this->instrumenModel = new InstrumenModel();
        $this->logalatModel = new LogalatModel();
        $this->logbahanModel = new LogbahanModel();
    }

    public function index()
    {
        $alat = $this->alatModel->findAll();
        $bahan = $this->bahanModel->findAll();
        $instrumen = $this->instrumenModel->findAll();

        $lokasi = array_unique(array_merge(
            array_column($alat, 'lokasi'),
            array_column($bahan, 'lokasi'),
            array_column($instrumen, 'lokasi')
        ));

        return view('Manajemen_form', [
            'alat' => $alat,
            'bahan' => $bahan,
            'instrumen' => $instrumen,
            'lokasi' => $lokasi
        ]);
    }

    // Halaman tambah
    public function tambahPage()
    {
        $alat = $this->alatModel->findAll();
        $bahan = $this->bahanModel->findAll();
        $instrumen = $this->instrumenModel->findAll();
        $lokasi = array_unique(array_merge(
            array_column($alat, 'lokasi'),
            array_column($bahan, 'lokasi'),
            array_column($instrumen, 'lokasi')
        ));
        return view('Manajemen_tambah', [
            'alat' => $alat,
            'bahan' => $bahan,
            'instrumen' => $instrumen,
            'lokasi' => $lokasi
        ]);
    }

    // Halaman kurang
    public function kurangPage()
    {
        $alat = $this->alatModel->findAll();
        $bahan = $this->bahanModel->findAll();
        $instrumen = $this->instrumenModel->findAll();
        $lokasi = array_unique(array_merge(
            array_column($alat, 'lokasi'),
            array_column($bahan, 'lokasi'),
            array_column($instrumen, 'lokasi')
        ));
        return view('Manajemen_kurang', [
            'alat' => $alat,
            'bahan' => $bahan,
            'instrumen' => $instrumen,
            'lokasi' => $lokasi
        ]);
    }

    public function tambah()
    {
        try {
            $jenis = $this->request->getPost('jenis');
            $nama = $this->request->getPost('nama');
            $jumlah = $this->request->getPost('jumlah');
            $satuan = $this->request->getPost('satuan');
            $lokasi = strtolower($this->request->getPost('lokasi'));
            $now = Time::now();

            if ($jenis === 'alat') {
                $alat = $this->alatModel
                    ->where('nama_alat', $nama)
                    ->where('lokasi', $lokasi)
                    ->first();

                if ($alat) {
                    $this->alatModel->update($alat['id_alat'], [
                        'jumlah_alat' => $alat['jumlah_alat'] + (int)$jumlah
                    ]);
                } else {
                    $this->alatModel->insert([
                        'nama_alat' => $nama,
                        'jumlah_alat' => (int)$jumlah,
                        'lokasi' => $lokasi
                    ]);
                    $alat = $this->alatModel
                        ->where('nama_alat', $nama)
                        ->where('lokasi', $lokasi)
                        ->first();
                }

                if ($alat) {
                    $this->logalatModel->insert([
                        'id_regis' => session('id_regis'),
                        'id_alat' => $alat['id_alat'],
                        'penambahan' => $jumlah,
                        'tujuan_pemakaian' => 'manajemen penambahan alat',
                        'tanggal_dipinjam' => $now,
                        'tanggal_kembali' => $now,
                        'status' => 'approve'
                    ]);
                }

            } elseif ($jenis === 'bahan') {
                $bahan = $this->bahanModel
                    ->where('nama_bahan', $nama)
                    ->where('lokasi', $lokasi)
                    ->first();

                if ($bahan) {
                    $this->bahanModel->update($bahan['id_bahan'], [
                        'jumlah_bahan' => $bahan['jumlah_bahan'] + (float)$jumlah
                    ]);
                } else {
                    $this->bahanModel->insert([
                        'nama_bahan' => $nama,
                        'jumlah_bahan' => (float)$jumlah,
                        'satuan_bahan' => $satuan,
                        'lokasi' => $lokasi
                    ]);
                    $bahan = $this->bahanModel
                        ->where('nama_bahan', $nama)
                        ->where('lokasi', $lokasi)
                        ->first();
                }

                if ($bahan) {
                    $this->logbahanModel->insert([
                        'id_regis' => session('id_regis'),
                        'id_bahan' => $bahan['id_bahan'],
                        'penambahan' => $jumlah,
                        'tujuan_pemakaian' => 'manajemen penambahan bahan',
                        'tanggal' => $now,
                        'status' => 'approve'
                    ]);
                }

            } elseif ($jenis === 'instrumen') {
                $instrumen = $this->instrumenModel
                    ->where('nama_instrumen', $nama)
                    ->where('lokasi', $lokasi)
                    ->first();

                if ($instrumen) {
                    $this->instrumenModel->update($instrumen['id_instrumen'], [
                        'jumlah_instrumen' => $instrumen['jumlah_instrumen'] + (int)$jumlah
                    ]);
                } else {
                    $this->instrumenModel->insert([
                        'nama_instrumen' => $nama,
                        'jumlah_instrumen' => (int)$jumlah,
                        'lokasi' => $lokasi
                    ]);
                }
            }

            // PERBAIKAN: Redirect ke halaman tambah dengan success message
            return redirect()->to('/manajemen/tambah')->with('success', "✅ Berhasil menambah {$jenis}: {$nama}");

        } catch (\Exception $e) {
            log_message('error', 'Manajemen tambah error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function kurang()
    {
        try {
            $jenis = $this->request->getPost('jenis');
            $nama = $this->request->getPost('nama');
            $jumlah = $this->request->getPost('jumlah');
            $now = Time::now();

            if ($jenis === 'alat') {
                $alat = $this->alatModel->where('nama_alat', $nama)->first();
                if ($alat && $alat['jumlah_alat'] >= $jumlah) {
                    $this->alatModel->update($alat['id_alat'], [
                        'jumlah_alat' => $alat['jumlah_alat'] - $jumlah
                    ]);
                    $this->logalatModel->insert([
                        'id_regis' => session('id_regis'),
                        'id_alat' => $alat['id_alat'],
                        'pengurangan' => $jumlah,
                        'tujuan_pemakaian' => 'manajemen pengurangan alat',
                        'tanggal_dipinjam' => $now,
                        'tanggal_kembali' => $now,
                        'status' => 'approve'
                    ]);
                } else {
                    return redirect()->back()->with('error', '❌ Jumlah tidak mencukupi atau item tidak ditemukan');
                }
            } elseif ($jenis === 'bahan') {
                $bahan = $this->bahanModel->where('nama_bahan', $nama)->first();
                if ($bahan && $bahan['jumlah_bahan'] >= $jumlah) {
                    $this->bahanModel->update($bahan['id_bahan'], [
                        'jumlah_bahan' => $bahan['jumlah_bahan'] - $jumlah
                    ]);
                    $this->logbahanModel->insert([
                        'id_regis' => session('id_regis'),
                        'id_bahan' => $bahan['id_bahan'],
                        'pengurangan' => $jumlah,
                        'tujuan_pemakaian' => 'manajemen pengurangan bahan',
                        'tanggal' => $now,
                        'status' => 'approve'
                    ]);
                } else {
                    return redirect()->back()->with('error', '❌ Jumlah tidak mencukupi atau item tidak ditemukan');
                }
            } elseif ($jenis === 'instrumen') {
                $instrumen = $this->instrumenModel->where('nama_instrumen', $nama)->first();
                if ($instrumen && $instrumen['jumlah_instrumen'] >= $jumlah) {
                    $this->instrumenModel->update($instrumen['id_instrumen'], [
                        'jumlah_instrumen' => $instrumen['jumlah_instrumen'] - $jumlah
                    ]);
                } else {
                    return redirect()->back()->with('error', '❌ Jumlah tidak mencukupi atau item tidak ditemukan');
                }
            }

            // PERBAIKAN: Redirect ke halaman kurang dengan success message
            return redirect()->to('/manajemen/kurang')->with('success', "✅ Berhasil mengurangi {$jenis}: {$nama}");

        } catch (\Exception $e) {
            log_message('error', 'Manajemen kurang error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
