<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('email/_header', ['title' => html_escape($subject)]); ?>
<table role="presentation" class="main">
	<tr>
		<td class="wrapper">
			<table role="presentation" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold"><?php echo html_escape($subject); ?></h1>
						<div class="mailcontent" style="line-height: 26px;font-size: 14px;">
							<p style='text-align: center'>
								<?php echo $email_content; ?><br>
							</p>
							<p style='text-align: center;margin-top: 30px;'>
								<a href="<?php echo $email_link; ?>" style='font-size: 14px;text-decoration: none;padding: 14px 40px;background-color: #09b1ba;color: #ffffff !important; border-radius: 3px;'>
									<?php echo html_escape($email_button_text); ?>
								</a>
							</p>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php $this->load->view('email/_footer'); ?>
