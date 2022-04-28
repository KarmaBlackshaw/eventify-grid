<?php 
  models('layouts/navbar_default'); 
  $layouts = new Layouts();
?>

<div class="page">
  <div class="page-main">
  
<!-- Header Brand -->
<div class="header py-4 bg-blue-darker">
  <div class="container">
    <div class="d-flex">
      <a class="header-brand text-white" href="javascript:">
        <img src="<?= assets('images/calendar.png'); ?>" class="header-brand-img" alt="">
        <span>Eventify Grid</span>
        <?php if($_SESSION['user_level_id'] != '5') : ?>
        <small class="font-small text-white font-italic"><?= ($_SESSION['user_level_id'] == '2') ? $_SESSION['office'] : $_SESSION['user_level']; ?></small>
        <?php endif; ?>
      </a>
      <div class="d-flex order-lg-2 ml-auto">
        <!-- <div class="dropdown d-none d-md-flex">
          <a class="nav-link text-dark icon" data-toggle="dropdown">
            <i class="fe fe-bell"></i>
            <span class="nav-unread"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
            <a href="javascript:void(0)" class="dropdown-item d-flex">
              <span class="avatar mr-3 align-self-center" style="background-image: url(/assets/images/male.png)"></span>
              <div>
                <strong>Nathan</strong> pushed new commit: Fix page load performance issue.
                <div class="small text-muted">10 minutes ago</div>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="javascript:void(0)" class="dropdown-item text-center text-muted-dark">Mark all as read</a>
          </div>
        </div> -->
        <div class="dropdown">
          <a href="javascript:void(0)" class="nav-link text-dark pr-0 leading-none" data-toggle="dropdown">
            <img src="<?= $layouts->getProfilePicture(); ?>" alt="" class="avatar">
            <span class="ml-2 d-none d-lg-block">
              <span class="text-light"><?= $_SESSION['full_name']; ?></span>
                
              <?php if($_SESSION['user_level_id'] == '5') : // Student ?>
                <small class="text-muted d-block mt-1">Student</small>
              <?php else : ?>
                <small class="text-muted d-block mt-1 font-italic"><?= $_SESSION['position']; ?></small>
              <?php endif; ?>
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
            <a class="dropdown-item" href="<?= base_views('layout/settings') ?>">
              <i class="dropdown-icon fe fe-user"></i> Profile
            </a>
            <a class="dropdown-item text-danger hvr-icon-buzz" href="javascript:" id="logout">
              <i class="dropdown-icon fe fe-log-out text-danger hvr-icon"></i> Logout
            </a>
          </div>
        </div>
      </div>
      <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
        <span class="header-toggler-icon"></span>
      </a>
    </div>
  </div>
</div>

<!-- Navbar -->
<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg order-lg-first">
        <?php if($_SESSION['user_level_id'] === '6') : // SSC ?>
        <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
          <li class="nav-item">
            <a href="<?= base_views('ssc/index') ?>" class="nav-link text-dark"><i class="fe fe-home"></i> Home</a>
          </li>
          <li class="nav-item">
            <a href="<?= base_views('ssc/events/events') ?>" class="nav-link text-dark"><i class="fe fe-calendar"></i> Events</a>
          </li>
          <li class="nav-item">
            <a href="<?= base_views('ssc/reports/reports') ?>" class="nav-link text-dark"><i class="fe fe-users"></i> Reports</a>
          </li>
          <li class="nav-item">
            <a href="<?= base_views('audit/index') ?>" class="nav-link text-dark"><i class="fe fe-book"></i> Audit Trails</a>
          </li>
        </ul>
        <?php elseif($_SESSION['user_level_id'] === '1') : // Academic ?>
        <?php elseif($_SESSION['user_level_id'] === '5') : // Student ?>
          <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
            <li class="nav-item">
              <a href="<?= base_views('student/index') ?>" class="nav-link text-dark"><i class="fe fe-home"></i> Home</a>
            </li>
            <li class="nav-item">
              <a href="<?= base_views('student/repercussions/repercussions') ?>" class="nav-link text-dark"><i class="fe fe-users"></i> Repercussions</a>
            </li>
            <li class="nav-item">
              <a href="<?= base_views('audit/index') ?>" class="nav-link text-dark"><i class="fe fe-book"></i> Audit Trails</a>
            </li>
          </ul>
        <?php elseif($_SESSION['user_level_id'] === '2') : // Administration ?>
            <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
              <?php if($_SESSION['office_id'] === '12') : // Plant and Facilities ?>
                <li class="nav-item">
                  <a href="<?= base_views('plant_and_facilities/index') ?>" class="nav-link text-dark"><i class="fe fe-home"></i> Home</a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_views('plant_and_facilities/events/events') ?>" class="nav-link text-dark"><i class="fe fe-calendar"></i> Events</a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_views('plant_and_facilities/venues/venues') ?>" class="nav-link text-dark"><i class="fe fe-map"></i> Venues</a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_views('plant_and_facilities/facilities/facilities') ?>" class="nav-link text-dark"><i class="fe fe-mic"></i> Facilities</a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_views('audit/index') ?>" class="nav-link text-dark"><i class="fe fe-book"></i> Audit Trails</a>
                </li>
              <?php elseif($_SESSION['office_id'] === '11'): // Management Information System ?>
                <li class="nav-item">
                  <a href="<?= base_views('mis/index') ?>" class="nav-link text-dark"><i class="fe fe-home"></i> Home</a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_views('mis/employees/employees') ?>" class="nav-link text-dark"><i class="fe fe-user"></i> Employees</a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_views('mis/students/students'); ?>" class="nav-link text-dark"><i class="fe fe-users"></i> Students</a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_views('mis/programs/programs') ?>" class="nav-link text-dark"><i class="fe fe-book-open"></i> Programs</a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_views('audit/index') ?>" class="nav-link text-dark"><i class="fe fe-book"></i> Audit Trails</a>
                </li>
              <?php elseif($_SESSION['office_id'] === '13'): // SSC Advisier ?>
                <li class="nav-item">
                  <a href="<?= base_views('adviser/index') ?>" class="nav-link text-dark"><i class="fe fe-home"></i> Home</a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_views('adviser/officers/officers') ?>" class="nav-link text-dark"><i class="fe fe-user"></i> SSC Officers</a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_views('audit/index') ?>" class="nav-link text-dark"><i class="fe fe-book"></i> Audit Trails</a>
                </li>
              <?php elseif($_SESSION['office_id'] === '6'): // OSA Director ?>
                <li class="nav-item">
                  <a href="<?= base_views('student_affairs/index') ?>" class="nav-link text-dark"><i class="fe fe-home"></i> Home</a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_views('student_affairs/events/events') ?>" class="nav-link text-dark"><i class="fe fe-user"></i> Events</a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_views('audit/index') ?>" class="nav-link text-dark"><i class="fe fe-book"></i> Audit Trails</a>
                </li>
            <?php endif; ?>

            <?php if($_SESSION['bldg_coordinator_id'] !== NULL) : ?>
              <?php if($_SESSION['bldg_coordinator_only'] == true) : ?>
                <li class="nav-item">
                  <a href="javascript:void(0)" class="nav-link text-dark"><i class="fe fe-home"></i> Home</a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_views('audit/index') ?>" class="nav-link text-dark"><i class="fe fe-book"></i> Audit Trails</a>
                </li>
              <?php endif; ?>
              <li class="nav-item">
                <a href="<?= base_views('bldg_coordinator/bldg/bldg') ?>" class="nav-link text-dark"><i class="fe fe-home"></i> My Building</a>
              </li>
            <?php endif; ?>
            </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php layouts('modal_logout'); ?>
<script src="<?= base_assets('jqueries/layout/navbar.js?') ?>"></script>