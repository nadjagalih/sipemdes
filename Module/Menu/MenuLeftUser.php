<?php
include "../App/Control/FunctionSession.php";
include "../App/Control/FunctionProfilePegawaiUser.php";

$pg = isset($_GET['pg']) ? $_GET['pg'] : '';

echo '<style>
    .sidebar-collapse {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 220px;
        overflow-y: auto;
        background: #fff;
        z-index: 1000;
        box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);
        transition: all 0.3s ease;
    }

    body.mini-navbar .sidebar-collapse {
        width: 70px;
        overflow: visible;
    }

    body.mini-navbar .nav-header {
        padding: 0.5rem;
    }

    body.mini-navbar .profile-element {
        display: none;
    }

    body.mini-navbar .sidebar-collapse .logo-element {
        display: block !important;
    }

    body.mini-navbar .nav-label,
    body.mini-navbar .fa.arrow {
        display: none !important;
    }

    body.mini-navbar .nav > li > a {
        padding: 0.75rem;
        justify-content: center;
    }

    body.mini-navbar .nav > li > a i {
        margin-right: 0;
        font-size: 1.1rem;
    }

    body.mini-navbar .metismenu .collapse {
        position: absolute;
        left: 70px;
        top: 0;
        width: 220px;
        background: #fff;
        border-radius: 0.375rem;
        box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);
    }
    
    .nav-header {
        position: sticky;
        top: 0;
        padding: 1.5rem;
        text-align: center;
        background: linear-gradient(87deg, rgba(17, 205, 239, 0.1) 0, rgba(17, 113, 239, 0.1) 100%) !important;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        z-index: 1;
        transition: padding 0.3s ease;
    }

    .logo-element {
        text-align: center;
        font-size: 18px;
        font-weight: 600;
        color: #5e72e4;
        display: none;
        padding: 10px 0;
    }
    .nav-header img {
        width: 80px;
        height: 80px;
        border: 3px solid #fff;
        border-radius: 50%;
        box-shadow: 0 0 20px rgba(0,0,0,.08);
        transition: transform 0.3s ease;
    }
    .nav-header img:hover {
        transform: scale(1.05);
    }
    .profile-element {
        text-align: center;
    }
    .block {
        display: block;
        color: #32325d;
        margin-top: 0.75rem;
        font-weight: 600;
    }
    .nav.metismenu {
        background: #fff;
        padding: 0.5rem;
    }
    .nav > li {
        margin: 0.25rem 0;
        border-radius: 0.375rem;
        overflow: hidden;
    }
    .nav > li > a {
        padding: 0.75rem 1rem;
        color: #525f7f;
        display: flex;
        align-items: center;
        border-radius: 0.375rem;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.15s ease;
        position: relative;
        overflow: hidden;
    }
    .nav > li > a:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(87deg, #11cdef 0, #1171ef 100%);
        opacity: 0;
        transition: opacity 0.15s ease;
        z-index: -1;
    }
    .nav > li > a:hover, .nav > li > a:focus {
        color: #fff;
        background: transparent;
    }
    .nav > li > a:hover:before, .nav > li > a:focus:before {
        opacity: 1;
    }
    .nav > li.active > a {
        color: #fff;
        background: linear-gradient(87deg, #11cdef 0, #1171ef 100%);
        box-shadow: 0 4px 6px rgba(50,50,93,.11), 0 1px 3px rgba(0,0,0,.08);
    }
    .nav > li > a i {
        margin-right: 0.75rem;
        width: 1.25rem;
        font-size: 1rem;
        text-align: center;
        opacity: 0.8;
        transition: all 0.15s ease;
    }
    
    .fa.arrow {
        float: right;
        font-size: 12px;
        margin-left: auto;
        transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        line-height: 1.5;
        opacity: 0.5;
        transform-origin: center;
        will-change: transform;
    }
    
    .nav > li.active > a .fa.arrow {
        transform: rotate(90deg);
        opacity: 1;
    }
    
    .nav-second-level {
        padding: 0.5rem 0.5rem 0.5rem 0.5rem;
        margin: 0.5rem 1rem;
        border-radius: 0.5rem;
        background: #f4f7fa;
        border: 1px solid #e3e6ed;
        box-shadow: 0 4px 16px rgba(50,50,93,.08);
        visibility: hidden;
        opacity: 0;
        height: 0;
        transform: translateY(-8px);
        transition: opacity 0.25s cubic-bezier(.4,0,.2,1), transform 0.25s cubic-bezier(.4,0,.2,1), visibility 0s linear 0.25s, height 0s linear 0.25s;
        will-change: transform, opacity;
    }
    
    .nav-second-level.collapse.in {
        visibility: visible;
        opacity: 1;
        height: auto;
        transform: translateY(0);
        transition: opacity 0.25s cubic-bezier(.4,0,.2,1), transform 0.25s cubic-bezier(.4,0,.2,1);
    }

    .nav-second-level li {
        position: relative;
        margin: 6px 0;
    }

    .nav-second-level li:before {
        content: "";
        position: absolute;
        left: 25px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, transparent, #5e72e4, transparent);
        opacity: 0.2;
    }

    .nav-second-level li a {
        padding: 0.5rem 1.2rem 0.5rem 48px;
        color: #5a6782;
        display: block;
        font-size: 0.95rem;
        font-weight: 400;
        transition: background 0.18s, color 0.18s, box-shadow 0.18s;
        position: relative;
        border-radius: 0.35rem;
    }

    .nav-second-level li a:before {
        content: "";
        position: absolute;
        left: 28px;
        top: 50%;
        transform: translateY(-50%);
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #cbd5e0;
        transition: all .18s;
        box-shadow: 0 0 0 0 rgba(94,114,228,0.18);
    }

    .nav-second-level li a:hover {
        color: #2c7be5;
        background: #e8f0fe;
        box-shadow: 0 2px 8px rgba(44,123,229,0.07);
        padding-left: 52px;
    }

    .nav-second-level li a:hover:before {
        background: #2c7be5;
        width: 9px;
        height: 9px;
        box-shadow: 0 0 0 4px rgba(44,123,229,0.18);
    }

    .nav-second-level li.active a {
        color: #2c7be5;
        background: #e0eaff;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(44,123,229,0.09);
    }

    .nav-second-level li.active a:before {
        background: #2c7be5;
        width: 9px;
        height: 9px;
        box-shadow: 0 0 0 4px rgba(44,123,229,0.18);
    }
    
    .badge-notif {
        background: #f5365c;
        color: #fff;
        padding: 3px 6px;
        font-size: 11px;
        border-radius: 4px;
        margin-left: 5px;
    }
    .special_link a {
        background: #f5365c !important;
        color: #fff !important;
    }
    .special_link a i {
        color: #fff !important;
    }
</style>';
?>
<div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
            <div class="dropdown profile-element">
                <?php
                if (empty($Foto)) {
                ?>
                    <img style="width:80px; height:auto" alt="image" class="rounded-circle" src="../Vendor/Media/Pegawai/no-image.jpg">
                <?php } else { ?>
                    <img style="width:80px; height:auto" alt="image" class="rounded-circle" src="../Vendor/Media/Pegawai/<?php echo $Foto; ?>" />
                <?php } ?>

                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="block m-t-xs font-bold">
                        <?php echo $NamaPegawai; ?></span>
                    <span class="text-muted text-xs block"><?php echo $Level; ?></span>
                </a>
            </div>
            <div class="logo-element"></div>
        </li>
        <li class="<?php echo ($_GET['pg'] == 'User') ? 'active' : ''; ?>">
            <a href="?pg=User"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span></a>
        </li>

        <li class="<?php echo ($_GET['pg'] == 'Pass') ? 'active' : ''; ?>">
            <a href="?pg=Pass"><i class="fa fa-terminal"></i> <span class="nav-label">Ganti Password</span></a>
        </li>
        <li class="special_link">
            <a href="../Auth/SignOut"><i class="fa fa-power-off"></i> <span class="nav-label">Keluar</span></a>
        </li>
    </ul>

</div>