<?php
session_start();

if (!isset($_SESSION["signIn"])) {
   header("Location: ../../sign/member/sign_in.php");
   exit;
}
require "../../config/config.php";
$akunMember = $_SESSION["member"]["nisn"];
$dataPinjam = queryReadData("SELECT peminjaman.id_peminjaman, peminjaman.id_buku, buku.judul, peminjaman.nisn, member.nama, admin.nama_admin, peminjaman.tgl_peminjaman, peminjaman.tgl_pengembalian, peminjaman.status
FROM peminjaman
INNER JOIN buku ON peminjaman.id_buku = buku.id_buku
INNER JOIN member ON peminjaman.nisn = member.nisn
INNER JOIN admin ON peminjaman.id_admin = admin.id
WHERE peminjaman.nisn = $akunMember");


foreach ($dataPinjam as $item) {
  if ($item['status'] == 'tidak') {
     $dataPinjam = false;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../style.css">
     <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
     <title>Transaksi peminjaman Buku || Member</title>
     <link rel="icon" href="../../assets/logoh.png" type="image/png">
</head>
  </head>
  <body style="background: url(../../assets/bg.jpg) fixed; ">
     <nav class="navbar fixed-top ">
      <div class="container-fluid" style="background-color: black; ">
        <a class="navbar-brand" href="#">
          <img src="../../assets/logoNav.png" alt="logo" width="140px">
        </a>
        
        <a class="btn btn-tertiary" href="../dashboardMember.php" style="color: white;">Dashboard</a>
      </div>
    </nav>
    
  <div class="p-4 mt-5">
    <div class="mt-5 alert alert-primary" role="alert">Riwayat transaksi Peminjaman Buku Anda - <span class="fw-bold text-capitalize"><?php echo htmlentities($_SESSION["member"]["nama"]); ?></span></div>
    
    <?php if ($dataPinjam == false) { ?>
      <div class="alert alert-secondary" role="alert">
         Buku tidak tersedia!
      </div>
      <?php } else { ?>
      <div class="table-responsive mt-3">
         <table class="table table-striped table-hover">
            <thead class="text-center">
               <tr>
                  <th class="bg-success text-light">Id Peminjaman</th>
                  <th class="bg-success text-light">Id Buku</th>
                  <th class="bg-success text-light">Judul Buku</th>
                  <th class="bg-success text-light">Nisn</th>
                  <th class="bg-success text-light">Nama</th>
                  <th class="bg-success text-light">Nama Admin</th>
                  <th class="bg-success text-light">Tanggal Peminjaman</th>
                  <th class="bg-success text-light">Tanggal Berakhir</th>
                  <th class="bg-success text-light">Aksi</th>
               </tr>
            </thead>

            <tr>
               <?php foreach ($dataPinjam as $item) : ?>
               <td><?= $item["id_peminjaman"]; ?></td>
               <td><?= $item["id_buku"]; ?></td>
               <td><?= $item["judul"]; ?></td>
               <td><?= $item["nisn"]; ?></td>
               <td><?= $item["nama"]; ?></td>
               <td><?= $item["nama_admin"]; ?></td>
               <td><?= $item["tgl_peminjaman"]; ?></td>
               <td><?= $item["tgl_pengembalian"]; ?></td>
               <td>
                  <a class="btn btn-success" href="bacabuku.php?id=<?= $item["id_buku"]; ?>"> Baca Buku</a>
               </td>
               <?php endforeach; ?>
            </tr>
         </table>
      </div>
   </div>
   <?php } ?>

  </body>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>
 