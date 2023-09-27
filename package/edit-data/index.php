<?php include "../../assets/template/header-2.php" ?>

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
              <h1 class="m-0">Edit Data Package</h1>
            </div><!-- /.col -->
            <div class="col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">Data Master</li>
                <li class="breadcrumb-item"><a href="../">Package</a></li>
                <li class="breadcrumb-item active">Edit Data</li>
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
              <div class="card">
                <div class="card-header">
                  <h5><i class="fas fa-edit"></i> Edit Data Package</h5>
                </div>
                <div class="card-body">
                  <?php
                  $packageId = $_GET['id'];
                  $sql = "SELECT * FROM packages WHERE Id = " . $packageId;
                  $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                  ?>
                      <form action="../../controller/edit-package.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="packageId" value="<?= $packageId ?>">
                        <div class="form-group">
                          <label for="name">Nama Package</label>
                          <input type="text" class="form-control" id="name" name="name" value="<?= $row['Nama_Packages'] ?>" placeholder="Nama..." required>
                        </div>
                        <div class="form-group">
                          <label for="jenis">Jenis</label>
                          <select class="form-control" id="jenis" name="jenis">
                            <?php
                            $sql = "SELECT * FROM jenis";
                            $jenisResult = $conn->query($sql);

                            if ($jenisResult->num_rows > 0) {
                              while ($jenisRow = $jenisResult->fetch_assoc()) {
                                $selected = ($jenisRow['Id'] == $row['Id_jenis']) ? 'selected' : '';
                            ?>
                                <option value="<?= $jenisRow['Id'] ?>" <?= $selected ?>><?= $jenisRow['Nama_jenis'] ?></option>
                            <?php }
                            } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="harga">Harga Jual (Rp.)</label>
                          <input type="text" class="form-control" id="harga" name="harga" value="<?= $row['Harga_jual'] ?>" placeholder="Harga Jual..." required>
                        </div>
                        <div class="form-group">
                          <label for="decs">Deskripsi</label>
                          <textarea class="form-control" id="decs" name="decs" rows="3"><?= $row['Deskripsi'] ?></textarea>
                        </div>
                        <button class="btn bg-custom-lgreen" style="color: #FFFF !important;">Simpan Data</button>
                      </form>
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
    <script>

    </script>
    <!-- /.Script -->

    <?php include "../../assets/template/footer-end-2.php" ?>
