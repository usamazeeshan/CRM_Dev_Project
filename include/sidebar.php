<?php echo $_SESSION['adminName'] ?>
<?php
$userPermissions =$db->display('permissions', 'user_id='.$_SESSION["ID"]);
if($userPermissions->num_rows > 0){
  $menuids = array();
  while($userPermissionsData = $userPermissions->fetch_array()){
  $menuids[] = $userPermissionsData['menu_id'];
 }
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="Admin Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Client Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo ucwords($_SESSION['adminName']) ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <!-- <i class="right fas fa-angle-left"></i> -->
              </p>
            </a>
          </li>
        <?php if(in_array(1,$menuids) || in_array(2,$menuids)){?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Clients
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="client.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Clients</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manage-cpanels.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Cpanel Accesses</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manage-cms.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage CMS Accesses</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="backlinks.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Backlinks</p>
                </a>
              </li> -->
            </ul>
          </li>
          <?php }?>
          <?php if(in_array(3,$menuids) || in_array(4,$menuids) || in_array(5,$menuids) || in_array(6,$menuids)){?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                PBN Management
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
            <?php if(in_array(4,$menuids)){?>
            <li class="nav-item">
                <a href="pbns.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage PBN's</p>
                </a>
              </li>
              <?php }?>
              <?php if(in_array(5,$menuids)){?>
              <li class="nav-item">
                <a href="pbn-client.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Client Articles</p>
                </a>
              </li>
              <?php }?>
              <?php if(in_array(6,$menuids)){?>
              <li class="nav-item">
                <a href="article-infos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage PBN Articles</p>
                </a>
              </li>
              <?php }?>
            </ul>
          </li>
            <?php }?>
            <?php if(in_array(7,$menuids) || in_array(8,$menuids) || in_array(9,$menuids)){?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Masters
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
            <?php if(in_array(8,$menuids)){?>
            <li class="nav-item">
                <a href="manage-backlink.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Backlinks</p>
                </a>
              </li>
              <?php }?>
              <?php if(in_array(9,$menuids)){?>
              <li class="nav-item">
                <a href="users.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Users</p>
                </a>
              </li>
              <?php }?>
            </ul>
          </li>
          <?php }?>
          <!-- <li class="nav-item"><a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
              Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="profile.php" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Profile
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="change-password.php" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>
            </ul>
          </li> -->


          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <?php }?>