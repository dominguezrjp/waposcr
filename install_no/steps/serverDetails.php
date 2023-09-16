<div class="card">
	<div class="card-header">
		<h4 class="card-title">Server Requirement</h4>
	</div>
	<div class="card-body">
		<div class="right-details">
			<div>
				<ul class="server-reqirement">
					<li class="<?= (array_key_exists('php', $serverReq) || version_compare(PHP_VERSION, '7.2.0', "<=")) ? 'error' : 'success' ?>" >PHP Version <?= PHP_VERSION; ?> <?= (version_compare(PHP_VERSION, '7.2.0', "<=")) ? '(PHP > 7.2.0)' : '' ?></li>
					<li class="<?= array_key_exists('curl', $serverReq) ? 'error' : 'success' ?>" >Curl</li>
					<li class="<?= array_key_exists('openssl_encrypt', $serverReq) ? 'error' : 'success' ?>" >Openssl Encrypt</li>
					<li class="<?= array_key_exists('mysqli', $serverReq) ? 'error' : 'success' ?>" >Mysqli</li>
					<li class="<?= array_key_exists('ipapi', $serverReq) ? 'error' : 'success' ?>" >IP API</li>
					<li class="<?= array_key_exists('ziparchive', $serverReq) ? 'error' : 'success' ?>" >ZipArchive</li>
					<li class="<?= array_key_exists('gzip', $serverReq) ? 'error' : 'success' ?>" >Gzip compression</li>
					<li class="<?= array_key_exists('allow_url_fopen', $serverReq) ? 'error' : 'success' ?>" >allow_url_fopen</li>
					<li class="<?= is_ssl() ? 'success' : 'error' ?>" ><?= is_ssl() ? 'SSL' : 'Non SSL' ?></li>
					<li class="<?= extension_loaded('gd') ? 'success' : 'error' ?>" ><?= extension_loaded('gd') ? 'GD Library Installed' : 'No GD Library Installed' ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>