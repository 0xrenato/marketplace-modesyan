<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $animation_array = ["none", "bounce", "flash", "pulse", "rubberBand", "shake", "swing", "tada", "wobble", "jello", "heartBeat", "bounceIn", "bounceInDown", "bounceInLeft",
	"bounceInRight", "bounceInUp", "fadeIn", "fadeInDown", "fadeInDownBig", "fadeInLeft", "fadeInLeftBig", "fadeInRight", "fadeInRightBig", "fadeInUp", "fadeInUpBig", "flip",
	"flipInX", "flipInY", "lightSpeedIn", "rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight", "slideInUp", "slideInDown", "slideInLeft",
	"slideInRight", "zoomIn", "zoomInDown", "zoomInLeft", "zoomInRight", "zoomInUp", "hinge", "jackInTheBox", "rollIn"]; ?>

<div class="row">
	<div class="col-lg-5 col-md-12">
		<div class="box box-primary">
			<!-- /.box-header -->
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo trans('update_slider_item'); ?></h3>
			</div><!-- /.box-header -->

			<!-- form start -->
			<?php echo form_open_multipart('admin_controller/update_slider_item_post'); ?>
			<input type="hidden" name="id" value="<?php echo $item->id; ?>">

			<div class="box-body">
				<!-- include message block -->
				<?php $this->load->view('admin/includes/_messages'); ?>

				<div class="form-group">
					<label><?php echo trans("language"); ?></label>
					<select name="lang_id" class="form-control">
						<?php foreach ($this->languages as $language): ?>
							<option value="<?php echo $language->id; ?>" <?php echo ($item->lang_id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label class="control-label"><?php echo trans('title'); ?></label>
					<input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>" value="<?php echo html_escape($item->title); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
				</div>
				<div class="form-group">
					<label class="control-label"><?php echo trans('description'); ?></label>
					<textarea name="description" class="form-control" placeholder="<?php echo trans('description'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo html_escape($item->description); ?></textarea>
				</div>
				<div class="form-group">
					<label class="control-label"><?php echo trans('link'); ?></label>
					<input type="text" class="form-control" name="link" placeholder="<?php echo trans('link'); ?>" value="<?php echo $item->link; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
				</div>

				<div class="row row-form">
					<div class="col-sm-12 col-md-6 col-form">
						<div class="form-group">
							<label class="control-label"><?php echo trans('order'); ?></label>
							<input type="number" class="form-control" name="item_order" placeholder="<?php echo trans('order'); ?>" value="<?php echo $item->item_order; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-form">
						<div class="form-group">
							<label class="control-label"><?php echo trans('button_text'); ?></label>
							<input type="text" class="form-control" name="button_text" placeholder="<?php echo trans('button_text'); ?>" value="<?php echo html_escape($item->button_text); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
						</div>
					</div>
				</div>

                <div class="row row-form">
                    <div class="col-sm-12 col-md-4 col-form">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('text_color'); ?></label>
                            <input type="color" class="form-control" name="text_color" value="<?php echo html_escape($item->text_color); ?>">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-form">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('button_color'); ?></label>
                            <input type="color" class="form-control" name="button_color" value="<?php echo html_escape($item->button_color); ?>">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-form">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('button_text_color'); ?></label>
                            <input type="color" class="form-control" name="button_text_color" value="<?php echo html_escape($item->button_text_color); ?>">
                        </div>
                    </div>
                </div>

				<div class="row row-form">
					<div class="col-sm-12" style="padding-left: 7.5px;">
						<label><?php echo trans("animations"); ?></label>
					</div>
					<div class="col-sm-12 col-md-4 col-form">
						<div class="form-group">
							<label><?php echo trans("title"); ?></label>
							<select name="animation_title" class="form-control">
								<?php foreach ($animation_array as $animation): ?>
									<option value="<?php echo $animation; ?>" <?php echo ($item->animation_title == $animation) ? 'selected' : ''; ?>><?php echo $animation; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-sm-12 col-md-4 col-form">
						<div class="form-group">
							<label><?php echo trans("description"); ?></label>
							<select name="animation_description" class="form-control">
								<?php foreach ($animation_array as $animation): ?>
									<option value="<?php echo $animation; ?>" <?php echo ($item->animation_description == $animation) ? 'selected' : ''; ?>><?php echo $animation; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-sm-12 col-md-4 col-form">
						<div class="form-group">
							<label><?php echo trans("button"); ?></label>
							<select name="animation_button" class="form-control">
								<?php foreach ($animation_array as $animation): ?>
									<option value="<?php echo $animation; ?>" <?php echo ($item->animation_button == $animation) ? 'selected' : ''; ?>><?php echo $animation; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label"><?php echo trans('image'); ?> (1920x600)</label>
					<div class="display-block m-b-15">
						<img src="<?php echo base_url() . $item->image; ?>" alt="" class="img-responsive" style="max-width: 300px; max-height: 300px;">
					</div>
					<div class="display-block">
						<a class='btn btn-success btn-sm btn-file-upload'>
							<?php echo trans('select_image'); ?>
							<input type="file" name="file" accept=".png, .jpg, .jpeg, .gif" onchange="show_preview_image(this);">
						</a>
					</div>
					<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" id="img_preview_file" class="img-file-upload-preview">
				</div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('image'); ?>&nbsp;(for mobile) (768x500)</label>
                    <div class="display-block m-b-15">
                        <img src="<?php echo base_url() . $item->image_mobile; ?>" alt="" class="img-responsive" style="max-width: 300px; max-height: 300px;">
                    </div>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('select_image'); ?>
                            <input type="file" name="file_mobile" accept=".png, .jpg, .jpeg, .gif" onchange="show_preview_image(this);">
                        </a>
                    </div>
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" id="img_preview_file_mobile" class="img-file-upload-preview">
                </div>

			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
			</div>
			<!-- /.box-footer -->
			<?php echo form_close(); ?><!-- form end -->
		</div>
	</div>
</div>
