<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= !empty(lang('404'))?lang('404'):'404';?></title>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
	<style>
		.error_pages {
			width: 100%;
			height: 98vh;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: calc(18px + .5vw);
			font-family: 'Roboto', sans-serif;
			overflow: hidden;
			font-weight: normal;
		}
		body{
			background: #435B66;
			color: #F0EDD4;
		}
	</style>
</head>
<body>
	<div class="error_pages">
		<p><?= !empty(lang('sorry'))?lang('sorry'):'sorry';?> | <?= !empty(lang('404_not'))?lang('404_not'):'404 Not Found';?></p>
	</div>
</body>
</html>

