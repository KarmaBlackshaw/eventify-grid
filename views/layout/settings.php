<?php 
	require_once dirname(__DIR__) . '/layout/header.php';
	layouts('navbar');
	$layouts = new Layouts();

	$upload_errors = array(
	    0 => 'There is no error, the file uploaded with success',
	    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
	    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
	    3 => 'The uploaded file was only partially uploaded',
	    4 => 'No file was uploaded',
	    6 => 'Missing a temporary folder',
	    7 => 'Failed to write file to disk.',
	    8 => 'A PHP extension stopped the file upload.',
	);

	$profile = $layouts->getProfile();
?>

<div class="my-3 my-md-5">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<h3 class="page-title mb-5">Profile</h3>
				<div>
					<div class="list-group list-group-transparent mb-5 nav-pills">
						<a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex align-items-center active" data-target="events_approval">
							<span class="icon mr-3"><i class="fe fe-settings"></i></span> General
						</a>
					</div>
				</div>
			</div>
			<div class="col-md-10" id="events_container">

				<?php if(isset($_GET['error'])) : ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<?php if(is_numeric($_GET['error'])) : ?>
							<strong>Error!</strong> <?= $upload_errors[$_GET['error']]; ?>
						<?php else : ?>
							<strong>Error!</strong> <?= $_GET['error']; ?>
						<?php endif; ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif; ?>

				<?php if(isset($_GET['success'])) : ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Congratulations!</strong> You have successfully updated your profile!
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif; ?>

				<div class="card">
					<div class="card-header">
						<div class="col-md-4 col-sm-3"><h3 class="card-title">General Account Settings</h3></div>
					</div>

					<!-- Social Media -->
					<div class="card-body p-0">
						<div class="media p-5" style="background: url('<?= $profile['account_cover_photo']; ?>'); object-fit: cover;">
							<img class="avatar avatar-xxl mr-5 hvr-grow-rotate" title="Update profile picture..." data-toggle="tooltip" src="<?= $layouts->getProfilePicture(); ?>" lass="card-img top" id="change_profile_picture">
							<div class="media-body text-white">
								<a href="javascript:" class="h4 m-0"><?= formatName($profile['fname'], $profile['mname'], $profile['lname']); ?></a>
								<p class="text-white mb-0 small font-italic"><?= $layouts->getUndername(); ?></p>
								<ul class="social-links list-inline mb-0 mt-2">
									<li class="list-inline-item">
										<a href="javascript:void(0)" class="hvr-buzz" title="<?= $profile['facebook_account']; ?>" data-toggle="tooltip"><i class="text-dark fab fa-facebook-f"></i></a>
									</li>
									<li class="list-inline-item">
										<a href="javascript:void(0)" class="hvr-buzz" title="<?= $profile['twitter_account']; ?>" data-toggle="tooltip"><i class="text-dark fab fa-twitter"></i></a>
									</li>
									<li class="list-inline-item">
										<a href="javascript:void(0)" class="hvr-buzz" title="<?= $profile['instagram_account']; ?>" data-toggle="tooltip"><i class="text-dark fab fa-instagram"></i></a>
									</li>
									<li class="list-inline-item">
										<a href="javascript:void(0)" class="hvr-buzz" title="<?= $profile['user_contact']; ?>" data-toggle="tooltip"><i class="text-dark fa fa-phone"></i></a>
									</li>
									<li class="list-inline-item">
										<a href="javascript:void(0)" id="change_cover_photo" class="hvr-buzz" title="Update cover photo..." data-toggle="tooltip"><i class="text-dark fas fa-camera"></i></a>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<form action="<?= base_controllers('LayoutsController') ?>" method="POST" enctype="multipart/form-data" id="form_change_profile">
						<input type="file" name="input_change_profile" class="hidden" id="input_change_profile">
						<input type="file" name="input_change_cover" class="hidden" id="input_change_cover">
					</form>

					<form action="<?= base_controllers('LayoutsController') ?>" method="POST">
						<div class="card-body">
							<div class="form-row">
								<div class="col-lg-4 col-md-4 col-sm-4">
									<div class="form-group">
										<label class="form-label">First Name</label>
										<input type="text" class="form-control" name="first_name" placeholder="Enter first name..." value="<?= $profile['fname']; ?>">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4">
									<div class="form-group">
										<label class="form-label">Middle Name</label>
										<input type="text" class="form-control" name="middle_name" placeholder="Enter middle name..." value="<?= $profile['mname']; ?>">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4">
									<div class="form-group">
										<label class="form-label">Last Name</label>
										<input type="text" class="form-control" name="last_name" placeholder="Enter last name..." value="<?= $profile['lname']; ?>">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6">
									<div class="form-group">
										<label class="form-label">Username</label>
										<input type="text" class="form-control" name="username" placeholder="Enter username..." value="<?= $profile['username']; ?>">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6">
									<div class="form-group">
										<label class="form-label">Contact Number</label>
										<input type="text" class="form-control" name="user_contact" placeholder="Enter contact number..." value="<?= $profile['user_contact']; ?>">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4">
									<div class="form-group">
										<label class="form-label">Facebook</label>
										<input type="text" class="form-control" name="facebook_account" placeholder="Enter facebook profile.." value="<?= $profile['facebook_account']; ?>">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4">
									<div class="form-group">
										<label class="form-label">Twitter</label>
										<input type="text" class="form-control" name="twitter_account" placeholder="Enter twitter profile.." value="<?= $profile['twitter_account']; ?>">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4">
									<div class="form-group">
										<label class="form-label">Instagram</label>
										<input type="text" class="form-control" name="instagram_account" placeholder="Enter instagram profile..." value="<?= $profile['instagram_account']; ?>">
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12">
									<div class="form-group mb-0">
										<label class="form-label">About Me</label>
										<textarea rows="5" class="form-control" name="about_me" placeholder="Describe yourself..."><?= $profile['about_me']; ?></textarea>
									</div>
								</div>
								<div class="col">
									<span class="small font-weight-light font-italic text-muted float-left"><?= $profile['updated_at']; ?></span>
									<input type="hidden" name="update_profile">
									<button type="submit" class="btn btn-primary mt-2 float-right">Update Profile</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php layouts('footer'); ?>
<script src="<?= assets('jqueries/layout/navbar.js?'); ?>"></script>