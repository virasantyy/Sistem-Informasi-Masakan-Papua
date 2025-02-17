<?php
session_start();
include '../../config/database.php';

// Validasi role admin
if ($_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Mendapatkan data makanan berdasarkan ID (jika ada)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($connect, "SELECT * FROM makanan WHERE id=$id");
    $row = mysqli_fetch_assoc($result);

    // Ambil foto lama dari database
    $query_foto = "SELECT foto FROM makanan WHERE id = '$id'";
    $result_foto = $connect->query($query_foto);
    $foto_data = $result_foto->fetch_assoc();
    $foto_lama = $foto_data['foto']; // Foto lama sekarang tersedia di $foto_lama
}

// Pagination
$limit = 3; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk menghitung total data
$totalResult = $connect->query("SELECT COUNT(*) AS total FROM makanan");
$totalData = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalData / $limit);

// Query untuk mengambil data dengan limit dan offset
$result = $connect->query("SELECT * FROM makanan LIMIT $limit OFFSET $offset");

// Mendapatkan data user admin
$users = $connect->query("SELECT * FROM users WHERE role = 'admin' LIMIT $limit OFFSET $offset");

// Mendapatkan data user yang sedang login
$user_id = $_SESSION['user_id'];
$query_user = "SELECT * FROM users WHERE id = $user_id";
$users = mysqli_query($connect, $query_user);
$user = mysqli_fetch_assoc($users);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> RasaSorong Admin</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Rasa Sorong</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Charts -->
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="bi bi-egg-fried"></i>
                    <span>Makanan</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="pesaan.php">
                    <i class="bi bi-chat-left"></i>
                    <span>Pesan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">



                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <img class="img-profile rounded-circle"
                                    src="../assets/img/icon.jpg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileModal">
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>

                            <!-- Modal Update Profile -->
                            <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form method="POST" action="update_profile.php">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="profileModalLabel">Update Profile</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">New Password (optional)</label>
                                                    <input type="password" class="form-control" id="password" name="password">
                                                    <small class="form-text text-muted">Leave blank if you don't want to change your password.</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                            <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php
                    $countQuery = "SELECT COUNT(*) AS total FROM users WHERE role = 'pengunjung'";
                    $countResult = $connect->query($countQuery);
                    $countRow = $countResult->fetch_assoc();
                    $totalUsers = $countRow['total'];
                    ?>
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Data Makanan</h1>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-12 col-lg-10">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary"></h6>
                                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                                            <i class="fas fa-download fa-sm text-white-50"></i> Tambah Data
                                        </a>
                                    </div>
                                    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Makanan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="../proses/tambah_makanan.php" method="POST" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="nama" class="form-label">Nama</label>
                                                            <input type="text" class="form-control" id="nama" name="nama" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="deskripsi" class="form-label">Deskripsi</label>
                                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="alamat" class="form-label">Alamat</label>
                                                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="bahan_utama" class="form-label">Bahan Utama</label>
                                                            <textarea class="form-control" id="bahan_utama" name="bahan_utama" rows="3" required></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="pendamping" class="form-label">Pendamping</label>
                                                            <textarea class="form-control" id="pendamping" name="pendamping" rows="3"></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="kategori" class="form-label">Kategori</label>
                                                            <input type="text" class="form-control" id="kategori" name="kategori" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="foto" class="form-label">Foto</label>
                                                            <input type="file" class="form-control" id="foto" name="foto" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>Deskripsi</th>
                                                        <th>Alamat</th>
                                                        <th>Foto</th>
                                                        <th>Pendamping</th>
                                                        <th>Kategori</th>
                                                        <th>Tanggal</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = $offset + 1;
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                            <tr>
                                                                <td><?= $no++; ?></td>
                                                                <td><?= $row['nama']; ?></td>
                                                                <td>
                                                                    <?php
                                                                    $deskripsi = $row['deskripsi'];
                                                                    $deskripsi_kata = explode(' ', $deskripsi);
                                                                    echo count($deskripsi_kata) > 7 ? implode(' ', array_slice($deskripsi_kata, 0, 7)) . '...' : $deskripsi;
                                                                    ?>
                                                                </td>
                                                                <td><?= $row['alamat']; ?></td>
                                                                <td><img src="../../uploads/<?= $row['foto']; ?>" alt="Foto Makanan" style="width: 80px; height: 50px;"></td>
                                                                <td>
                                                                    <?php
                                                                    $pendamping = $row['pendamping'];
                                                                    $pendamping_kata = explode(' ', $pendamping);
                                                                    echo count($pendamping_kata) > 7 ? implode(' ', array_slice($pendamping_kata, 0, 7)) . '...' : $pendamping;
                                                                    ?>
                                                                </td>
                                                                <td><?= $row['kategori']; ?></td>
                                                                <td><?= $row['tanggal_ditambahkan']; ?></td>
                                                                <td>
                                                                    <a href="../proses/delete_makanan.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDataModal<?= $row['id']; ?>">Edit</button>
                                                                </td>
                                                            </tr>
                                                            <div class="modal fade" id="editDataModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="editDataModalLabel<?= $row['id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editDataModalLabel<?= $row['id']; ?>">Edit Data Makanan</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <form action="../proses/edit_makanan.php" method="POST" enctype="multipart/form-data">
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                                                <div class="mb-3">
                                                                                    <label for="nama" class="form-label">Nama</label>
                                                                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $row['nama']; ?>" required>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                                                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?= $row['deskripsi']; ?></textarea>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="alamat" class="form-label">Alamat</label>
                                                                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= $row['alamat']; ?></textarea>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="bahan_utama" class="form-label">Bahan Utama</label>
                                                                                    <textarea class="form-control" id="bahan_utama" name="bahan_utama" rows="3" required><?= $row['bahan_utama']; ?></textarea>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="pendamping" class="form-label">Pendamping</label>
                                                                                    <textarea class="form-control" id="pendamping" name="pendamping" rows="3"><?= $row['pendamping']; ?></textarea>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="kategori" class="form-label">Kategori</label>
                                                                                    <input type="text" class="form-control" id="kategori" name="kategori" value="<?= $row['kategori']; ?>" required>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="foto" class="form-label">Foto</label>
                                                                                    <!-- Tampilkan gambar lama -->
                                                                                    <img src="../../uploads/<?= htmlspecialchars($row['foto']); ?>" alt="<?= htmlspecialchars($row['nama']); ?>" style="width: 80px; height: 50px;">
                                                                                    <input type="file" class="form-control mt-2" id="foto" name="foto">
                                                                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                                                                                </div>

                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="10" class="text-center">No data in tables</td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Pagination -->
                                        <nav>
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                                                    <a class="page-link" href="?page=<?= $page - 1; ?>" aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                                    <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                                                        <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                                                    </li>
                                                <?php } ?>
                                                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                                    <a class="page-link" href="?page=<?= $page + 1; ?>" aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; RasaSorong 2025</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->


                <!-- Scroll to Top Button-->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>


                <!-- Bootstrap core JavaScript-->
                <script src="../assets/vendor/jquery/jquery.min.js"></script>
                <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                <!-- Core plugin JavaScript-->
                <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

                <!-- Custom scripts for all pages-->
                <script src="../assets/js/sb-admin-2.min.js"></script>

                <!-- Page level plugins -->
                <script src="../assets/vendor/chart.js/Chart.min.js"></script>

                <!-- Page level custom scripts -->
                <script src="../assets/js/demo/chart-area-demo.js"></script>
                <script src="../assets/js/demo/chart-pie-demo.js"></script>

                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

                <!-- Include Popper.js (untuk modal dan dropdowns) -->
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>


</body>

</html>