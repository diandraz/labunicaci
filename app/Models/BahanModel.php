<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanModel extends Model
{
    protected $table = 'bahan';
    protected $primaryKey = 'id_bahan';
    protected $allowedFields = ['nama_bahan', 'jumlah_bahan', 'satuan_bahan', 'lokasi'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    // PERBAIKAN: Pastikan satuan_bahan selalu diambil dengan debug
    public function getAllBahan($search = null, $location = null, $limit = null, $offset = null)
    {
        // SELALU SELECT SEMUA KOLOM YANG DIPERLUKAN
        $builder = $this->select('id_bahan, nama_bahan, jumlah_bahan, satuan_bahan, lokasi');
        
        if ($search) {
            $builder->like('nama_bahan', $search);
        }
        
        if ($location && $location !== 'Semua Lokasi') {
            $builder->where('lokasi', $location);
        }
        
        if ($limit) {
            $builder->limit($limit, $offset);
        }
        
        $builder->orderBy('nama_bahan', 'ASC');
        
        $result = $builder->get()->getResultArray();
        
        // DEBUG: Log setiap item untuk memastikan satuan_bahan ada
        foreach ($result as $item) {
            log_message('debug', 'BahanModel::getAllBahan - ' . $item['nama_bahan'] . ' - Satuan: ' . ($item['satuan_bahan'] ?? 'NULL_VALUE'));
        }
        
        return $result;
    }

    // PERBAIKAN: Method khusus untuk mengambil bahan dengan satuan
    public function getBahanWithSatuan($nama_bahan)
    {
        $result = $this->select('id_bahan, nama_bahan, jumlah_bahan, satuan_bahan, lokasi')
                       ->where('nama_bahan', $nama_bahan)
                       ->first();
        
        // DEBUG: Log hasil
        if ($result) {
            log_message('debug', 'BahanModel::getBahanWithSatuan - ' . $nama_bahan . ' - Satuan: ' . ($result['satuan_bahan'] ?? 'NULL_VALUE'));
        } else {
            log_message('debug', 'BahanModel::getBahanWithSatuan - ' . $nama_bahan . ' - NOT_FOUND');
        }
        
        return $result;
    }

    // TAMBAHAN: Method untuk memastikan satuan ada
    public function fixMissingSatuan()
    {
        // Update semua bahan yang tidak punya satuan
        $this->set('satuan_bahan', 'gram')
             ->where('satuan_bahan IS NULL OR satuan_bahan = ""')
             ->update();
        
        return $this->countAllResults();
    }
}
