<?php 
	require_once dirname(__DIR__) . '/layout/header.php';
	models('mis/mis_default');
	layouts('navbar');
?>

<div class="my-3 my-md-5">
	<div class="container">
		<div class="row">
		  <div class="col-md-2">
		    <h3 class="page-title mb-5">Events</h3>
		    <div>
		      <div class="list-group list-group-transparent mb-5 nav-pills">
		        <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex align-items-center active" data-target="events_approval">
		          <span class="icon mr-3"><i class="fe fe-map"></i></span> Feed
		        </a>
		      </div>
		    </div>
		  </div>
		  <div class="col-md-10" id="events_container">

		  	<div class="card">
		  	  <div class="card-header">
		  	    <div class="d-flex justify-content-center">
		  	      <div class="spinner-grow spinner-grow-sm" role="status">
		  	        <span class="sr-only">Loading...</span>
		  	      </div>
		  	    </div>
		  	  </div>
		  	  <div class="card-body pb-1">
		  	    <div class="d-flex justify-content-center">
		  	      <div class="spinner-grow" role="status">
		  	        <span class="sr-only">Loading...</span>
		  	      </div>
		  	    </div>
		  	    <hr class="m-1">
		  	    <div class="btn-group w-100">
		  	      <a href="javascript:" class="btn btn-transparent hvr-icon-grow w-100"><span class="icon mr-3"><i class="far fa-thumbs-up fa-lg hvr-icon"></i></span> Like </a>
		  	      <a href="javascript:" class="btn btn-transparent hvr-icon-grow w-100"><span class="icon mr-3"><i class="far fa-comment-alt fa-lg hvr-icon"></i></i></span> Comment </a>
		  	      <a href="javascript:" class="btn btn-transparent hvr-icon-grow w-100"><span class="icon mr-3"><i class="far fa-thumbs-down fa-lg hvr-icon"></i></span> Dislike </a>
		  	    </div>
		  	  </div>
		  	  <div class="card-footer">
		  	    <div class="d-flex justify-content-start mb-2">
		  	      <div class="spinner-grow mr-2" role="status">
		  	        <span class="sr-only">Loading...</span>
		  	      </div>
		  	      <textarea rows="1" class="form-control rounded" placeholder="Write a comment..." draggable="false" style="resize: none;"></textarea>
		  	    </div>
		  	  </div>
		  	</div>
		  	
		  </div>
		</div>
	</div>
</div>

<?php layouts('footer'); ?>
<script src="<?= assets('jqueries/students/events/events.js?'); ?>"></script>