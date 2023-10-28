<?php include "../../assets/template/header-2.php" ?>

<?php

$type = 2;

include "../../assets/delMsg.php";

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
<style>
    label {
        font-size: 12px !important;
    }

    .card {
        padding: 20px 5px;
        border-radius: 10px;
        overflow: hidden;
    }

    .box-note {
        width: 60%;
        height: auto;
        overflow-y: auto;
    }

    .wrapper-note {
        margin: 10px 0;
        padding: 20px 10px;
        background-color: #F7F7F9;
        border: 2px solid #000;
        font-size: 14px !important;
    }

    .wrapper-status {
        display: flex;
        justify-content: space-between;
    }

    .ket {
        margin-right: 50px;
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
                        <?php
                        if (!empty($_SESSION['msg'])) {
                        ?>
                            <div class="col-12">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Message!</strong> <?= $_SESSION['msg']['key'] ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        if (!empty($_SESSION['msg-w'])) {
                        ?>
                            <div class="col-12">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Message!</strong> <?= $_SESSION['msg-w']['key'] ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        if (!empty($_SESSION['msg-f'])) {
                        ?>
                            <div class="col-12">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Message!</strong> <?= $_SESSION['msg-f']['key'] ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-12">
                            <h1 class="m-0">Detail Data New Lead</h1>
                        </div><!-- /.col -->
                        <div class="col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Data Master</li>
                                <li class="breadcrumb-item"><a href="../">New Lead</a></li>
                                <li class="breadcrumb-item active">Detail New Lead</li>
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
                                <div class="card-header bg-white border-0" style="border-radius: 10px;">
                                    <div class="row" style="border-radius: 10px;">
                                        <div class="col-12" style="display: flex; align-items: center; justify-content: space-between;">
                                            <h4 class="text-dark"><?= $row['Id'] ?> - <?= $row['Fullname'] ?> <i class="fas fa-map-marker-alt" style="color: #007BFF;"></i></h4>
                                            <span class="badge badge-sm badge-secondary">Global Xtreme</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-0 bg-white">
                                    <h5 class="m-0"><i class="fas fa-users"></i> General</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="primary-contact" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Primary Contact</label>
                                            <p id="primary-contact"><?= $row['Fullname'] ?></p>
                                            <label for="company-name" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Company Name</label>
                                            <p id="company-name"><?= $row['Companyname'] ?></p>
                                        </div>
                                        <div class="col-4">
                                            <label for="status" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Status</label>
                                            <p id="status" class="<?= ($row['Status'] == 'Scheduled') ? 'rounded bg-primary' : 'd-none'; ?>" style="padding: 2px 5px;width: max-content;">Scheduled</p>
                                            <p id="status" class="<?= ($row['Status'] == 'Consideration') ? 'rounded bg-primary' : 'd-none'; ?>" style="padding: 2px 5px;width: max-content;">Consideration</p>
                                            <p id="status" class="<?= ($row['Status'] == 'Junk') ? 'rounded bg-primary' : 'd-none'; ?>" style="padding: 2px 5px;width: max-content;">Junk</p>
                                            <p id="status" class="<?= ($row['Status'] == 'FCB - Future Call Back') ? 'rounded bg-primary' : 'd-none'; ?>" style="padding: 2px 5px;width: max-content;">FCB - Future Call Back</p>
                                            <p id="status" class="<?= ($row['Status'] == 'Qualified') ? 'rounded bg-primary' : 'd-none'; ?>" style="padding: 2px 5px;width: max-content;">Qualified</p>
                                            <p id="status" class="<?= ($row['Status'] == 'NI - Not Interested') ? 'rounded bg-primary' : 'd-none'; ?>" style="padding: 2px 5px;width: max-content;">NI - Not Interested</p>
                                            <p id="status" class="<?= ($row['Status'] == 'Out Cover') ? 'rounded bg-primary' : 'd-none'; ?>" style="padding: 2px 5px;width: max-content;">Out Cover</p>
                                            <p id="status" class="<?= ($row['Status'] == 'Not Response') ? 'rounded bg-primary' : 'd-none'; ?>" style="padding: 2px 5px;width: max-content;">Not Response</p>
                                            <p id="status" class="<?= ($row['Status'] == 'Pending') ? 'rounded bg-primary' : 'd-none'; ?>" style="padding: 2px 5px;width: max-content;">Pending</p>
                                            <label for="probability" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Probability</label>
                                            <p id="probability" class="<?= ($row['Probability'] == 'Confirmed') ? 'rounded bg-primary' : 'd-none'; ?>" style="padding: 2px 5px;width: max-content;">Confirmed</p>
                                            <p id="probability" class="<?= ($row['Probability'] == 'Pending') ? 'rounded bg-primary' : 'd-none'; ?>" style="padding: 2px 5px;width: max-content;">Pending</p>
                                            <p id="probability" class="<?= ($row['Probability'] == 'Cancel') ? 'rounded bg-primary' : 'd-none'; ?>" style="padding: 2px 5px;width: max-content;">Cancel</p>
                                            <label for="media" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Media</label>
                                            <p id="media"><?= $row['media'] ?></p>
                                            <label for="source" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Source</label>
                                            <p id="source"><?= $row['source'] ?></p>
                                        </div>
                                        <div class="col-4">
                                            <label for="created_at" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Created At</label>
                                            <p id="created_at"><?= $row['created_at'] ?></p>
                                            <label for="created-by" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Created By</label>
                                            <?php
                                            $sql2 = "SELECT * FROM pengguna WHERE Id = " . $row['id_pengguna'];
                                            $result2 = mysqli_query($conn, $sql2);
                                            if ($result2->num_rows > 0) {
                                                while ($row2 = $result2->fetch_assoc()) { ?>
                                                    <p id="created-by"><?= $row2['Nama'] ?></p>
                                            <?php }
                                            } ?>
                                            <label for="update_at" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Last Updated</label>
                                            <p id="update_at"><?= $row['last_update'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-0 bg-white">
                                    <h5 class="m-0"><i class="fas fa-id-card"></i> Contact Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="phone-number" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Phone Number</label>
                                            <p id="phone-number"><?= $row['Phonenumber'] ?></p>
                                            <label for="email" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Email</label>
                                            <p id="email"><?= $row['Email'] ?></p>
                                            <label for="address" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Address</label>
                                            <p id="address"><?= $row['Address'] ?></p>
                                        </div>
                                        <div class="col-4">
                                            <label for="company-phone-number" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Company Phone Number</label>
                                            <p id="company-phone-number"><?= $row['Companyphonenumber'] ?></p>
                                            <label for="company-email" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Company Email</label>
                                            <p id="company-email"><?= $row['Companyemail'] ?></p>
                                            <label for="company-address" class="text-secondary text-uppercase m-0" style="font-weight: normal;">Company Address</label>
                                            <p id="company-address"><?= $row['Companyaddress'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-0 bg-white">
                                    <h5 class="m-0"><i class="fas fa-clipboard"></i> Follow Ups</h5>
                                </div>
                                <div class="card-body">
                                    <form action="../tambah-note/" method="post">
                                        <input type="hidden" name="id_newlead" id="id_newlead" value="<?= $row['Id'] ?>">
                                        <input type="hidden" name="type" id="type" value="Report">
                                        <button class="btn btn-outline-primary btn-sm">New Report <i class="fas fa-plus"></i></button>
                                    </form>
                                    <?php
                                    $sql3 = "SELECT * FROM tb_notes_newlead WHERE note_type = 'Report' AND id_newlead = '" . $row['Id'] . "'";
                                    $result3 = mysqli_query($conn, $sql3);
                                    if ($result3->num_rows > 0) {
                                        while ($row3 = $result3->fetch_assoc()) { ?>
                                            <div class="wrapper-note">
                                                <div class="wrapper-status">
                                                    <div class="status">
                                                        <p class="m-0" style="padding-left: 10px;"><strong>Status: </strong><?= $row['Status'] ?></p>
                                                        <p class="m-0" style="padding-left: 10px;"><strong>Probability: </strong><?= $row['Probability'] ?></p>
                                                    </div>
                                                    <div class="ket">
                                                        <?php
                                                        $sql2 = "SELECT * FROM pengguna WHERE Id = " . $row['id_pengguna'];
                                                        $result2 = mysqli_query($conn, $sql2);
                                                        if ($result2->num_rows > 0) {
                                                            while ($row2 = $result2->fetch_assoc()) { ?>
                                                                <p class="m-0"><strong><?= $row2['Nama'] ?></strong></p>
                                                        <?php }
                                                        } ?>
                                                        <p class="m-0"><?= $row3['created_at'] ?></p>
                                                        <?php if ($row['asigned_to'] == 00) {
                                                        ?>
                                                            <p class="m-0"></p>
                                                            <?php } else {
                                                            $sql2 = "SELECT Nama FROM pengguna WHERE Id = " . $row['asigned_to'];
                                                            $result2 = $conn->query($sql2);

                                                            if ($result2->num_rows > 0) {
                                                                while ($row2 = $result2->fetch_assoc()) {
                                                            ?>
                                                                    <p class="m-0 p-2 rounded bg-gradient-secondary" style="font-size: 10px;">Asigned To : <br><strong><?= $row2['Nama'] ?></strong></p>
                                                        <?php }
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="box-note">
                                                    <pre><?= $row3['note'] ?></pre>
                                                </div>
                                            </div>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-0 bg-white">
                                    <h5 class="m-0"><i class="fas fa-clipboard"></i> Surver</h5>
                                </div>
                                <div class="card-body">
                                    <form action="../tambah-note/" method="post">
                                        <input type="hidden" name="id_newlead" id="id_newlead" value="<?= $row['Id'] ?>">
                                        <input type="hidden" name="type" id="type" value="Survey">
                                        <button class="btn btn-outline-primary btn-sm">New Survey <i class="fas fa-plus"></i></button>
                                    </form>
                                    <?php
                                    $sql3 = "SELECT * FROM tb_notes_newlead WHERE note_type = 'Survey' AND id_newlead = '" . $row['Id'] . "'";
                                    $result3 = mysqli_query($conn, $sql3);
                                    if ($result3->num_rows > 0) {
                                        while ($row3 = $result3->fetch_assoc()) { ?>
                                            <div class="wrapper-note">
                                                <div class="wrapper-status">
                                                    <div class="status">
                                                        <p class="m-0" style="padding-left: 10px;"><strong>Status: </strong><?= $row['Status'] ?></p>
                                                        <p class="m-0" style="padding-left: 10px;"><strong>Probability: </strong><?= $row['Probability'] ?></p>
                                                    </div>
                                                    <div class="ket">
                                                        <?php
                                                        $sql2 = "SELECT * FROM pengguna WHERE Id = " . $row['id_pengguna'];
                                                        $result2 = mysqli_query($conn, $sql2);
                                                        if ($result2->num_rows > 0) {
                                                            while ($row2 = $result2->fetch_assoc()) { ?>
                                                                <p class="m-0"><strong><?= $row2['Nama'] ?></strong></p>
                                                        <?php }
                                                        } ?>
                                                        <p class="m-0"><?= $row3['created_at'] ?></p>
                                                        <?php if ($row['asigned_to'] == 00) {
                                                        ?>
                                                            <p class="m-0"></p>
                                                            <?php } else {
                                                            $sql2 = "SELECT Nama FROM pengguna WHERE Id = " . $row['asigned_to'];
                                                            $result2 = $conn->query($sql2);

                                                            if ($result2->num_rows > 0) {
                                                                while ($row2 = $result2->fetch_assoc()) {
                                                            ?>
                                                                    <p class="m-0 p-2 rounded bg-gradient-secondary" style="font-size: 10px;">Asigned To : <br><strong><?= $row2['Nama'] ?></strong></p>
                                                        <?php }
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="box-note">
                                                    <pre><?= $row3['note'] ?></pre>
                                                </div>
                                            </div>
                                    <?php }
                                    } ?>
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
        <!-- Bootstrap JavaScript -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>

        </script>
        <!-- /.Script -->

        <?php include "../../assets/template/footer-end-2.php" ?>