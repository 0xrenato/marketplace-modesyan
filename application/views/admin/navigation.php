<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('navigation'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('admin_controller/navigation_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="form-group">
                    <label><?php echo trans('menu_limit'); ?>&nbsp;(<?php echo trans("number_of_links_in_menu"); ?>)</label>
                    <input type="number" class="form-control" name="menu_limit"
                           placeholder="<?php echo trans('menu_limit'); ?>"
                           value="<?php echo $this->general_settings->menu_limit; ?>" min="1"
                           max="100" style="max-width: 400px;" required>
                </div>
                <div class="form-group">
                    <label><?php echo trans('navigation_template'); ?></label>
                </div>
                <div class="row nav-template-items">
                    <div class="col-md-6">
                        <div class="nav-template-item <?php echo ($this->general_settings->selected_navigation == 1) ? 'active' : ''; ?>" data-nav-id="1">
                            <img src="<?php echo base_url(); ?>assets/admin/img/nav_1.jpg" alt="" class="img-responsive">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="nav-template-item <?php echo ($this->general_settings->selected_navigation == 2) ? 'active' : ''; ?>" data-nav-id="2">
                            <img src="<?php echo base_url(); ?>assets/admin/img/nav_2.jpg" alt="" class="img-responsive">
                        </div>
                    </div>
                </div>
                <input type="hidden" id="input_navigation" name="navigation" value="<?php echo $this->general_settings->selected_navigation; ?>">
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>

<script>
    $(".nav-template-item").click(function () {
        $(".nav-template-item").removeClass("active");
        $(this).addClass("active");
        var id = $(this).attr("data-nav-id");
        $("#input_navigation").val(id);
    });
</script>
