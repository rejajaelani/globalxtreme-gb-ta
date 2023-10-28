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
                            <h1 class="m-0">Tambah Data Pengguna</h1>
                        </div><!-- /.col -->
                        <div class="col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Data Master</li>
                                <li class="breadcrumb-item"><a href="../">New Lead</a></li>
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
                            <form action="../../controller/input-new-lead.php" method="post">
                                <input type="hidden" name="id_pengguna" id="id_pengguna" value="<?= $idIs_login ?>" required>
                                <div class="card">
                                    <div class="card-header text-center border-0">
                                        <h5 class="mt-3">Contact Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="fullname" class="col-sm-2 col-form-label">Full Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="fullname" name="fullname" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="address" name="address" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phonenumber" class="col-sm-2 col-form-label">Phone Number</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="phonenumber" name="phonenumber" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="email" name="email" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header text-center border-0">
                                        <h5 class="mt-3">Company Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="companyname" class="col-sm-2 col-form-label">Company Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="companyname" name="companyname">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="companyaddress" class="col-sm-2 col-form-label">Company Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="companyaddress" name="companyaddress">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="companyphonenumber" class="col-sm-2 col-form-label">Company Phone Number</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="companyphonenumber" name="companyphonenumber">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="companyemail" class="col-sm-2 col-form-label">Company Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="companyemail" name="companyemail">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header text-center border-0">
                                        <h5 class="mt-3">Other Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="status" class="col-sm-2 col-form-label">Status</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="status" name="status" required>
                                                    <option style="display: none;">-- Select Status --</option>
                                                    <option>Scheduled</option>
                                                    <option>Consideration</option>
                                                    <option>Junk</option>
                                                    <option>FCB - Future Call Back</option>
                                                    <option>Qualified</option>
                                                    <option>NI - Not Interested</option>
                                                    <option>Out Cover</option>
                                                    <option>Not Response</option>
                                                    <option>Pending</option>
                                                </select>
                                            </div>
                                        </div>
                                        <?php
                                        // if ($levelIs_login == 3) {
                                        ?>
                                        <!-- <div class="form-group row">
                                                <label for="probability" class="col-sm-2 col-form-label">Probability</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="probability" name="probability" value="Pending" readonly>
                                                </div>
                                            </div> -->
                                        <?php //} else { 
                                        ?>
                                        <div class="form-group row">
                                            <label for="probability" class="col-sm-2 col-form-label">Probability</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="probability" name="probability" required>
                                                    <option style="display: none;">-- Select Probability --</option>
                                                    <option>Converted</option>
                                                    <option>Pending</option>
                                                    <option>Cancel</option>
                                                </select>
                                            </div>
                                        </div>
                                        <?php //} 
                                        ?>
                                        <div class="form-group row">
                                            <label for="source" class="col-sm-2 col-form-label">Source</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="source" name="source" required>
                                                    <option style="display: none;">-- Select Source --</option>
                                                    <option>Outbound</option>
                                                    <option>Inbound - Tawk To</option>
                                                    <option>Inbound - WA Center</option>
                                                    <option>Inbound - Call</option>
                                                    <option>Inbound - Walk in</option>
                                                    <option>Customer Support</option>
                                                    <option>Sales</option>
                                                    <option>Other</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="media" class="col-sm-2 col-form-label">Media</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="media" name="media" required>
                                                    <option style="display: none;">-- Select Media --</option>
                                                    <option>Outbound</option>
                                                    <option>WA Center</option>
                                                    <option>Call</option>
                                                    <option>Website</option>
                                                    <option>Email</option>
                                                    <option>Walk In</option>
                                                    <option>Sales</option>
                                                    <option>Other</option>
                                                    <option>Digital Platform</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <a href="../" class="btn btn-secondary ml-2 mr-2">Cancel</a>
                                    <button class="btn bg-custom-lgreen" style="color: #FFFF !important;">Save Changes</button>
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
        <!-- Bootstrap JavaScript -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script>

        </script>
        <!-- /.Script -->

        <?php include "../../assets/template/footer-end-2.php" ?>