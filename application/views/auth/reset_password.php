<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
	<div class="container">
		<div class="auth-container">
			<div class="auth-box">
				<div class="row">
					<div class="col-12">
						<h1 class="title"><?php echo trans("reset_password"); ?></h1>
						<!-- form start -->
						<?php echo form_open('reset-password-post', ['id' => 'form_validate']); ?>
						<!-- include message block -->
						<?php $this->load->view('partials/_messages'); ?>
						<?php if (!empty($user)): ?>
							<input type="hidden" name="token" value="<?php echo $user->token; ?>">
						<?php endif; ?>
						<?php if (!empty($success)): ?>
							<div class="form-group m-t-30">
								<a href="<?php echo lang_base_url(); ?>" class="btn btn-md btn-custom btn-block"><?php echo trans("goto_home"); ?></a>
							</div>
						<?php else: ?>
							<div class="form-group">
								<label><?php echo trans("new_password"); ?></label>
								<input type="password" name="password" class="form-control form-input" value="<?php echo old("password"); ?>" placeholder="<?php echo trans("new_password"); ?>" minlength="4" maxlength="255" required>
							</div>
							<div class="form-group m-b-30">
								<label><?php echo trans("password_confirm"); ?></label>
								<input type="password" name="password_confirm" class="form-control form-input" value="<?php echo old("password_confirm"); ?>" placeholder="<?php echo trans("password_confirm"); ?>" maxlength="255" required>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-md btn-custom btn-block"><?php echo trans("submit"); ?></button>
							</div>
						<?php endif; ?>
						<?php echo form_close(); ?>
						<!-- form end -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Wrapper End-->
