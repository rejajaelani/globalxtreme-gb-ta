<?php include "../../assets/template/header-2.php" ?>

<?php
// Periksa apakah parameter ID dari data yang akan diubah telah dikirimkan
if (isset($_POST['id_newlead'])) {
    $id = $_POST['id_newlead'];
    $type = $_POST['type'];

    // Query SQL untuk mengambil data dari tabel new_lead berdasarkan ID
    $selectSql = "SELECT * FROM new_lead WHERE Id = ?";
    $selectStmt = $conn->prepare($selectSql);

    if ($selectStmt) {
        $selectStmt->bind_param("i", $id);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $row = $result->fetch_assoc();
        $selectStmt->close();
    } else {
        echo "Terjadi kesalahan dalam persiapan pernyataan SQL: " . mysqli_error($conn);
    }
} else {
    // Tidak ada parameter ID, maka beri nilai default atau tindakan lain sesuai kebutuhan
    // Contoh:
    echo "Parameter ID tidak ditemukan.";
    exit;
}
?>
<style>
    label {
        font-size: 12px !important;
    }

    .card {
        padding: 20px 5px;
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

        <?php include "../../assets/template/navbar.php" ?>

        <?php include "../../assets/template/sidebar-2.php" ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-12">
                            <h1 class="m-0">Tambah Data <?= $type ?> Note </h1>
                        </div><!-- /.col -->
                        <div class="col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Data Master</li>
                                <li class="breadcrumb-item"><a href="../">New Lead</a></li>
                                <li class="breadcrumb-item active">Tambah Note</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card" style="border-radius: 10px;">
                                <div class="card-header border-0 bg-white">
                                    <h5 class="m-0"><i class="fas fa-plus"></i> Note</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <form action="../../controller/input-notes.php" method="post">
                                                <input type="hidden" name="id_newlead" id="id_newlead" value="<?= $id ?>">
                                                <input type="hidden" name="type" id="type" value="<?= $type ?>">
                                                <textarea class="form-control" name="notes" id="notes" rows="10"></textarea>
                                                <button class="btn btn-outline-info mt-3">Tambah</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->

        <?php include "../../assets/template/footer-2.php" ?>

        <!-- Script Here -->
        <script>

        </script>
        <!-- /.Script -->

        <?php include "../../assets/template/footer-end-2.php" ?>