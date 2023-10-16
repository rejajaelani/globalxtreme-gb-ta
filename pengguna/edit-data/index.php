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
                            <h1 class="m-0">Edit Data Pengguna</h1>
                        </div><!-- /.col -->
                        <div class="col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Data Master</a></li>
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
                                    <h5><i class="fas fa-user-plus"></i> Edit Data Pengguna</h5>
                                </div>
                                <div class="card-body">
                                    <?php
                                    // Ambil ID pengguna yang akan di-edit dari parameter URL
                                    $editUserId = $_GET['id'];
                                    $sql = "SELECT * FROM pengguna WHERE Id = $editUserId";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                    ?>
                                        <form action="../../controller/edit-pengguna.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="editUserId" value="<?= $editUserId ?>">
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?= $row['Nama'] ?>" placeholder="Nama..." required>
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" value="<?= $row['Username'] ?>" placeholder="Username..." required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password...">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email address</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?= $row['Email'] ?>" placeholder="Email..." required>
                                            </div>
                                            <?php
                                            if ($levelIs_login == 1) {
                                            ?>
                                                <div class="form-group">
                                                    <label for="level">Level</label>
                                                    <select class="form-control" id="level" name="level">
                                                        <option value="1" <?= ($row['Level'] == 1) ? 'selected' : '' ?>>Admin</option>
                                                        <option value="2" <?= ($row['Level'] == 2) ? 'selected' : '' ?>>Super Admin</option>
                                                        <option value="3" <?= ($row['Level'] == 3) ? 'selected' : '' ?>>Sales</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="1" <?= ($row['Status'] == 1) ? 'selected' : '' ?>>Aktif</option>
                                                        <option value="0" <?= ($row['Status'] == 0) ? 'selected' : '' ?>>Non-Aktif</option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                <label for="image">Foto</label>
                                                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                                            </div>
                                            <button type="submit" class="btn bg-custom-lgreen" style="color: #FFFF !important;">Simpan Data</button>
                                        </form>
                                    <?php } ?>
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