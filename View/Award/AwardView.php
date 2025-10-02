<?php
// Main view page untuk list award dalam format card
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Data Award/Penghargaan Lomba Desa</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?pg=SAdmin">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Award Desa</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-4">
        <br>
        <div class="title-action">
            <a href="?pg=AwardAdd" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Award
            </a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <!-- Filter Section -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form method="GET" action="">
                        <input type="hidden" name="pg" value="AwardView">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Semua Status</option>
                                        <option value="Aktif" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                        <option value="Nonaktif" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <select name="tahun" class="form-control">
                                        <option value="">Semua Tahun</option>
                                        <?php for($i = date('Y'); $i >= 2015; $i--): ?>
                                            <option value="<?php echo $i; ?>" <?php echo (isset($_GET['tahun']) && $_GET['tahun'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Cari Penghargaan</label>
                                    <input type="text" name="search" class="form-control" placeholder="Nama penghargaan..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fa fa-search"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <!--
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Total Penghargaan</h5>
                    <h1 class="no-margins"><?php include "../App/Control/StatistikAward.php"; echo $TotalAward; ?></h1>
                    <small>Semua penghargaan</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Status Aktif</h5>
                    <h1 class="no-margins text-success"><?php echo $AwardAktif; ?></h1>
                    <small>Penghargaan aktif</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Status Nonaktif</h5>
                    <h1 class="no-margins text-warning"><?php echo $AwardNonaktif; ?></h1>
                    <small>Penghargaan nonaktif</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Penghargaan <?php echo date('Y'); ?></h5>
                    <h1 class="no-margins text-info"><?php echo $AwardTahunIni; ?></h1>
                    <small>Tahun ini</small>
                </div>
            </div>
        </div>
    </div>
    -->

    <!-- Award List Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="fa fa-list"></i> Daftar Award</h5>
                </div>
                <div class="ibox-content">
                    <?php include "../App/Control/FunctionAwardList.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.award-card {
    transition: transform 0.2s;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.award-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}
.award-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1;
}
.award-year {
    font-size: 24px;
    font-weight: bold;
    color: #1ab394;
}
.award-actions {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 1;
}
.award-actions .btn {
    margin-right: 5px;
    opacity: 0.8;
}
.award-actions .btn:hover {
    opacity: 1;
}
</style>
