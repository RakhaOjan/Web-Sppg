<div class="sidebar">
    <div class="sidebar-logo">
        <div class="nama-logo">SPPG Bekasi</div>
        <div class="sub-logo">Kota Bekasi</div>
    </div>
    <div class="sidebar-menu">
        <div class="menu-judul">Menu Utama</div>
        <a href="<?php echo $base_admin; ?>dashboard.php" class="<?php echo ($menu_aktif == 'dashboard') ? 'aktif' : ''; ?>">
            &#9632; Dashboard
        </a>

        <div class="menu-judul">Data Master</div>
        <a href="<?php echo $base_admin; ?>kecamatan/index.php" class="<?php echo ($menu_aktif == 'kecamatan') ? 'aktif' : ''; ?>">
            &#9670; Kecamatan
        </a>
        <a href="<?php echo $base_admin; ?>sppg/index.php" class="<?php echo ($menu_aktif == 'sppg') ? 'aktif' : ''; ?>">
            &#9632; SPPG
        </a>

        <div class="menu-judul">Akun</div>
        <a href="<?php echo $base_admin; ?>../auth/logout.php" onclick="return confirm('Yakin Logout?')">
            &#10006; Logout
        </a>
    </div>
</div>
