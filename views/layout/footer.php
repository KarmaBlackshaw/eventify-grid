	  <?php layouts('footnote'); ?>
	<!-- js -->

    <script type="text/javascript" src="<?= assets('js/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" src="<?= assets('js/fontawesome.min.js') ?>"></script>
    <script type="text/javascript" src="<?= assets('js/bootstrap-notify.js') ?>"></script>
    <script type="text/javascript" src="<?= assets('js/settings.js') ?>"></script>
    <script type="text/javascript" src="<?= assets('js/lodash.js') ?>"></script>
	<script type="text/javascript" src="<?= node('toprogress/ToProgress.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= assets('js/defaults.js') ?>"></script>


	<!-- charts -->
	<script src="<?= node('chart.js/dist/Chart.bundle.js') ?>"></script>
	<script src="<?= node('chart.js/dist/Chart.js') ?>"></script>
	
	<script type="text/javascript" src="<?= assets('dashboard/js/core.js') ?>"></script>

	<!-- live server -->
	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</body>
</html>