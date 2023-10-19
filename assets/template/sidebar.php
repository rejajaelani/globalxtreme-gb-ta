  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 bg-white">
    <!-- Brand Logo -->
    <!-- <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a> -->
    <div class="p-2 mb-2 bg-custom-lgreen">
      <div class="img">
        <img src="../assets/images/<?= $foto ?>" alt="foto">
      </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2" style="height: 55vh;overflow-y: auto;overflow-x: hidden;">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="../" class="nav-link text-dark" style="font-size: 18px;">
              <i class="fas fa-th-large"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item menu-close" style="<?= ($levelIs_login == 3) ? 'display: none' : ''; ?>">
            <a href="#" class="nav-link text-dark" style="font-size: 18px;">
              <i class="fas fa-chart-bar"></i>
              <p>
                Data Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../pengguna/" class="nav-link text-dark">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengguna</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../jenis-package/" class="nav-link text-dark">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jenis Package</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../package/" class="nav-link text-dark">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Package</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item menu-close">
            <a href="#" class="nav-link text-dark" style="font-size: 18px;">
              <i class="fas fa-users"></i>
              <p>
                Data Customer
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../new-lead/" class="nav-link text-dark">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Lead</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../prospect/" class="nav-link text-dark">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Prospect</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="../config-app/" class="nav-link text-dark" style="font-size: 18px;">
              <i class="fas fa-desktop"></i>
              <p>Config App</p>
            </a>
          </li>
          <li class="nav-item menu-close">
            <a href="#" class="nav-link text-dark" style="font-size: 18px;">
              <i class="fas fa-file"></i>
              <p>
                Data Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../laporan/new-lead/" class="nav-link text-dark">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Lead</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../laporan/prospect/" class="nav-link text-dark">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Prospect</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>