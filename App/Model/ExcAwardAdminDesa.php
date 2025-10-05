<?php
// Model untuk operasi award admin desa
class ExcAwardAdminDesa {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    // Get award detail by ID
    public function getAwardDetail($IdAward) {
        $IdAward = mysqli_real_escape_string($this->db, $IdAward);
        
        // Check if MasaPenjurian columns exist
        $checkColumns = mysqli_query($this->db, "SHOW COLUMNS FROM master_award_desa LIKE 'MasaPenjurianMulai'");
        $hasPenjurianColumns = mysqli_num_rows($checkColumns) > 0;
        
        if ($hasPenjurianColumns) {
            $selectColumns = "IdAward, JenisPenghargaan, TahunPenghargaan, Deskripsi, MasaAktifMulai, MasaAktifSelesai, MasaPenjurianMulai, MasaPenjurianSelesai, StatusAktif";
        } else {
            $selectColumns = "IdAward, JenisPenghargaan, TahunPenghargaan, Deskripsi, MasaAktifMulai, MasaAktifSelesai, StatusAktif";
        }
        
        $query = "SELECT $selectColumns FROM master_award_desa WHERE IdAward = '$IdAward'";
        $result = mysqli_query($this->db, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            // Set default values for missing columns
            if (!$hasPenjurianColumns) {
                $data['MasaPenjurianMulai'] = null;
                $data['MasaPenjurianSelesai'] = null;
            }
            return $data;
        }
        
        return false;
    }
    
    // Get kategori by award ID
    public function getKategoriByAward($IdAward) {
        $IdAward = mysqli_real_escape_string($this->db, $IdAward);
        
        $query = "SELECT 
            IdKategoriAward,
            NamaKategori,
            DeskripsiKategori
            FROM master_kategori_award 
            WHERE IdAwardFK = '$IdAward'
            ORDER BY NamaKategori ASC";
            
        $result = mysqli_query($this->db, $query);
        $kategori = [];
        
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $kategori[] = $row;
            }
        }
        
        return $kategori;
    }
    
    // Check if desa sudah mendaftar ke award ini
    public function cekDesaSudahDaftar($IdDesa, $IdAward) {
        $IdDesa = mysqli_real_escape_string($this->db, $IdDesa);
        $IdAward = mysqli_real_escape_string($this->db, $IdAward);
        
        // Check if table exists first
        $checkTable = mysqli_query($this->db, "SHOW TABLES LIKE 'desa_award'");
        if (!$checkTable || mysqli_num_rows($checkTable) == 0) {
            return false; // Table doesn't exist, so desa hasn't registered
        }
        
        $query = "SELECT COUNT(*) as total 
            FROM desa_award da 
            JOIN master_kategori_award mk ON da.IdKategoriAwardFK = mk.IdKategoriAward
            WHERE da.IdDesaFK = '$IdDesa' AND mk.IdAwardFK = '$IdAward'";
            
        $result = mysqli_query($this->db, $query);
        
        if ($result) {
            $data = mysqli_fetch_assoc($result);
            return $data['total'] > 0;
        }
        
        return false;
    }
    
    // Get statistik award untuk desa
    public function getStatistikAwardDesa($IdDesa) {
        $IdDesa = mysqli_real_escape_string($this->db, $IdDesa);
        
        $stats = [];
        
        // Total award tersedia
        $query1 = "SELECT COUNT(*) as total FROM master_award_desa WHERE StatusAktif = 'Aktif'";
        $result1 = mysqli_query($this->db, $query1);
        $stats['total_tersedia'] = $result1 ? mysqli_fetch_assoc($result1)['total'] : 0;
        
        // Total karya terdaftar desa ini
        $checkTable = mysqli_query($this->db, "SHOW TABLES LIKE 'desa_award'");
        if ($checkTable && mysqli_num_rows($checkTable) > 0) {
            $query2 = "SELECT COUNT(*) as total FROM desa_award WHERE IdDesaFK = '$IdDesa'";
            $result2 = mysqli_query($this->db, $query2);
            $stats['total_terdaftar'] = $result2 ? mysqli_fetch_assoc($result2)['total'] : 0;
        } else {
            $stats['total_terdaftar'] = 0;
        }
        
        // Award sedang berlangsung (check if columns exist first)
        $checkColumns = mysqli_query($this->db, "SHOW COLUMNS FROM master_award_desa LIKE 'MasaPenjurianMulai'");
        if (mysqli_num_rows($checkColumns) > 0) {
            $query3 = "SELECT COUNT(*) as total FROM master_award_desa 
                WHERE StatusAktif = 'Aktif' 
                AND MasaPenjurianMulai IS NOT NULL 
                AND MasaPenjurianSelesai IS NOT NULL 
                AND CURDATE() BETWEEN MasaPenjurianMulai AND MasaPenjurianSelesai";
            $result3 = mysqli_query($this->db, $query3);
            $stats['berlangsung'] = $result3 ? mysqli_fetch_assoc($result3)['total'] : 0;
        } else {
            $stats['berlangsung'] = 0;
        }
        
        // Award tahun ini
        $tahunIni = date('Y');
        $query4 = "SELECT COUNT(*) as total FROM master_award_desa 
            WHERE StatusAktif = 'Aktif' AND TahunPenghargaan = '$tahunIni'";
        $result4 = mysqli_query($this->db, $query4);
        $stats['tahun_ini'] = $result4 ? mysqli_fetch_assoc($result4)['total'] : 0;
        
        return $stats;
    }
    
    // Get award list dengan filter
    public function getAwardList($filters = []) {
        $whereConditions = ["StatusAktif = 'Aktif'"]; // Default hanya aktif
        
        // Status filter
        if (!empty($filters['status'])) {
            if ($filters['status'] == 'Berlangsung') {
                // Check if penjurian columns exist
                $checkColumns = mysqli_query($this->db, "SHOW COLUMNS FROM master_award_desa LIKE 'MasaPenjurianMulai'");
                if (mysqli_num_rows($checkColumns) > 0) {
                    $whereConditions[] = "MasaPenjurianMulai IS NOT NULL AND MasaPenjurianSelesai IS NOT NULL AND CURDATE() BETWEEN MasaPenjurianMulai AND MasaPenjurianSelesai";
                } else {
                    // If columns don't exist, no awards can be "berlangsung"
                    $whereConditions[] = "1=0"; // This will return no results
                }
            } else {
                $status = mysqli_real_escape_string($this->db, $filters['status']);
                $whereConditions[] = "StatusAktif = '$status'";
            }
        }
        
        // Tahun filter
        if (!empty($filters['tahun'])) {
            $tahun = mysqli_real_escape_string($this->db, $filters['tahun']);
            $whereConditions[] = "TahunPenghargaan = '$tahun'";
        }
        
        // Search filter
        if (!empty($filters['search'])) {
            $search = mysqli_real_escape_string($this->db, $filters['search']);
            $whereConditions[] = "JenisPenghargaan LIKE '%$search%'";
        }
        
        $whereClause = implode(' AND ', $whereConditions);
        
        // Check if MasaPenjurian columns exist
        $checkColumns = mysqli_query($this->db, "SHOW COLUMNS FROM master_award_desa LIKE 'MasaPenjurianMulai'");
        $hasPenjurianColumns = mysqli_num_rows($checkColumns) > 0;
        
        if ($hasPenjurianColumns) {
            $selectColumns = "IdAward, JenisPenghargaan, TahunPenghargaan, MasaAktifMulai, MasaAktifSelesai, MasaPenjurianMulai, MasaPenjurianSelesai, StatusAktif";
        } else {
            $selectColumns = "IdAward, JenisPenghargaan, TahunPenghargaan, MasaAktifMulai, MasaAktifSelesai, StatusAktif";
        }
        
        $query = "SELECT $selectColumns FROM master_award_desa WHERE $whereClause ORDER BY TahunPenghargaan DESC, JenisPenghargaan ASC";
            
        $result = mysqli_query($this->db, $query);
        $awards = [];
        
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Set default values for missing columns
                if (!$hasPenjurianColumns) {
                    $row['MasaPenjurianMulai'] = null;
                    $row['MasaPenjurianSelesai'] = null;
                }
                $awards[] = $row;
            }
        }
        
        return $awards;
    }
    
    // Get award status untuk display
    public function getAwardStatus($award) {
        $currentDate = date('Y-m-d');
        
        if ($award['StatusAktif'] != 'Aktif') {
            return [
                'badge' => 'badge-secondary',
                'text' => 'Nonaktif'
            ];
        }
        
        // Check masa penjurian
        if ($award['MasaPenjurianMulai'] && $award['MasaPenjurianSelesai']) {
            if ($currentDate >= $award['MasaPenjurianMulai'] && $currentDate <= $award['MasaPenjurianSelesai']) {
                return [
                    'badge' => 'badge-warning',
                    'text' => 'Masa Penjurian'
                ];
            } elseif ($currentDate > $award['MasaPenjurianSelesai']) {
                return [
                    'badge' => 'badge-secondary',
                    'text' => 'Selesai'
                ];
            }
        }
        
        return [
            'badge' => 'badge-success',
            'text' => 'Pendaftaran'
        ];
    }
}
?>