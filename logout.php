<?php
session_start();

// Hapus semua sesi
session_unset();
session_destroy();

// Tampilkan alert saat logout berhasil
echo "<script>alert('Anda telah berhasil logout!'); window.location.href='index.php';</script>";
exit();
