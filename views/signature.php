<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="page">
	<div class="page-single">
		<div class="container">
			<div class="row">
				<div class="col col-login mx-auto" >
					<div class="text-center">
						<h1 class="display-4 no-highlight">Signature Pad</h1>
					</div>
					<div class="alert hidden" id="signature_alert">
					  A simple primary alert—check it out!
					</div>
					<div class="wrapper mb-1">
						<canvas id="signature-pad" class="signature-pad border shadow form-control h-100"></canvas>
					</div>
					<button id="save" class="btn btn-primary w-100 mb-1">Save</button>
					<button id="clear" class="btn btn-secondary w-100 mb-5">Clear</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?= assets('js/pad.js') ?>"></script>
<script src="<?= assets('jqueries/logins/signature.js') ?>"></script>

<?php layouts('footer'); ?>