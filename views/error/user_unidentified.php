<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

    <div class="page">
      <div class="page-content">
        <div class="container text-center">
          <div class="display-1 text-muted mb-5 hvr-pulse"><i class="si si-exclamation"></i> 404</div>
          <h1 class="h2 mb-3">Oops.. No page found..</h1>
          <p class="h4 text-muted font-weight-normal mb-7">We are sorry but your interface is yet to be developed!</p>
          <a class="btn btn-primary" href="<?= base_views(); ?>">
            <i class="fe fe-arrow-left mr-2"></i>Go back
          </a>
        </div>
      </div>
    </div>
    
<?php die(); ?>