<?php include "../../assets/template/header-2.php" ?>

<?php

$type = 2;

// Periksa apakah parameter ID dari data yang akan diubah telah dikirimkan
if (isset($_GET['id'])) {
    $id = $_GET['id'];

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
                            <h1 class="m-0">Asigned To</h1>
                        </div><!-- /.col -->
                        <div class="col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Data Master</li>
                                <li class="breadcrumb-item"><a href="../">New Lead</a></li>
                                <li class="breadcrumb-item active">Edit Data Asigned To</li>
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
                        <div class="col-6">
                            <form action="../../controller/update-asigned.php" method="post">
                                <input type="hidden" name="id_pengguna" id="id_pengguna" value="<?= $row['id_pengguna'] ?>">
                                <input type="hidden" name="id_new_lead" id="id_new_lead" value="<?= $row['Id'] ?>">
                                <div class="card">
                                    <div class="card-header text-center border-0">
                                        <h5 class="mt-3">Data Pengguna</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="asigned_to" class="col-sm-2 col-form-label">Asigned To</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="asigned_to" name="asigned_to">
                                                    <option style="display: none;">-- Select Asigned To --</option>
                                                    <option value="00">No Asigned</option>
                                                    <?php

                                                    // Query SQL untuk mengambil data pengguna
                                                    $sql2 = "SELECT * FROM pengguna";
                                                    $result2 = $conn->query($sql2);

                                                    if ($result2->num_rows > 0) {
                                                        while ($row2 = $result2->fetch_assoc()) {
                                                    ?>
                                                            <option value="<?= $row2['Id'] ?>"><?= $row2['Nama'] ?></option>

                                                    <?php
                                                        }
                                                    } else {
                                                        echo "Parameter ID tidak ditemukan.";
                                                        exit;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <a href="../" class="btn btn-secondary ml-2 mr-2">Cancel</a>
                                    <button class="btn bg-custom-lgreen" style="color: #FFFF !important;">Update Changes</button>
                                </div>
                            </form>
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