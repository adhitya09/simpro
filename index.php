<?php
include_once __DIR__ . '/koneksi.php';

// Tambahkan fungsi cekURL di sini
function cekURL($page, $url = array())
{
    foreach ($url as $ur) {
        if (strpos($page, $ur) > -1) {
            return true;
        }
    }
    return false;
}

// Redirect ke login jika pengguna belum login
if (!isset($_SESSION['user'])) {
    if (basename($_SERVER['PHP_SELF']) != 'login.php') {
        header('location:login.php');
        exit;
    }
}

// Ambil role pengguna dari sesi
$role = isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : '';

// Ambil parameter halaman
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Validasi akses berdasarkan role
if ($role == 2 || $role == 3) {
    // Ubah $page ke halaman default 'home' jika role mengakses halaman tidak diperbolehkan
    if (cekURL($page, array('teknisi', 'user'))) {
        $page = 'dashboard'; // Redirect internal ke halaman 'home'
    }
}

// Tentukan file halaman
$pageFile = __DIR__ . "/views/pages/{$page}.php";

// Periksa apakah file halaman ada
if (file_exists($pageFile)) {
    ob_start();
    include $pageFile;
    $content = ob_get_clean();
} else {
    $content = '<h2>404 - Page Not Found</h2>';
}

// Tentukan judul halaman
$title = ucfirst($page);

// Tampilkan layout utama
include __DIR__ . '/views/layouts/main.php';
?>
