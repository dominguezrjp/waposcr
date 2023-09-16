<div class="container">
	<div class="row mail_content" style="border:1px solid #d6d6d6; background-color:#f3f3f3; padding:10px;">
		<div class="col-md-12">
			<table>
				<tr style="width:100%; overflow:hidden;">
					<td style="width:10%; float:left;"><b>Username:</b></td>
					<td style="width:90%;"><?= html_escape($name);?></td>
				</tr>

				<tr style="width:100%; overflow:hidden;">
					<td style="width:10%; float:left;"><b>Email:</b></td>
					<td style="width:90%;"><?= html_escape($email);?></td>
				</tr>

				<tr style="width:100%; overflow:hidden;">
					<td style="width:10%; float:left;"><b>Password:</b></td>
					<td style="width:90%;"><?= html_escape($password);?></td>
				</tr>
				<tr style="width:100%; overflow:hidden;">
					<td style="width:10%; float:left;"><b>Message:</b></td>
					<td style="width:90%;"><?= html_escape($message);?></td>
				</tr>
			</table>
		</div>
	</div>
</div>