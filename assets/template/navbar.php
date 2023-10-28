  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-custom-lgreen">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li> -->
      <li class="nav-item">
        <a href="#" class="nav-link disabled text-white"><?= $name ?></a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a href="#" class="nav-link disabled text-white">Welcome
          <?php
          // Konversi level berdasarkan nilai $levelIs_login
          switch ($levelIs_login) {
            case 1:
              echo "Admin";
              break;
            case 2:
              echo "Supervisor";
              break;
            case 3:
              echo "Sales";
              break;
            default:
              echo "Uknown";
              break;
          }
          ?>
          <span class="badge badge-info">Online</span></a>
      </li>
      <li class="nav-item">
        <form action="<?= ($type == 2) ? "../../" : "../" ?>controller/LogoutController.php" method="post">
          <input type="hidden" name="email" id="email" value="<?= $email ?>">
          <button class="btn text-white" style="background-color: #1AB394 !important;"><i class="fas fa-sign-out-alt text-danger"></i> Log out</button>
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->