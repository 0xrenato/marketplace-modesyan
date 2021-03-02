<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b style="font-weight: 600;">Version</b> 1.8
    </div>
    <strong style="font-weight: 600;"><?php echo html_escape($this->settings->copyright); ?></strong>
</footer>
</div>
<!-- ./wrapper -->

<style>.item-table-filter {
        min-width: 110px;
        max-width: 160px;
    }</style>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery-ui.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);
    var thousands_separator = "<?php echo $this->thousands_separator; ?>";
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/admin/vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables js -->
<script src="<?php echo base_url(); ?>assets/admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/vendor/datatables/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/admin/js/adminlte.min.js"></script>
<!-- iCheck js -->
<script src="<?php echo base_url(); ?>assets/admin/vendor/icheck/icheck.min.js"></script>
<!-- Pace -->
<script src="<?php echo base_url(); ?>assets/admin/vendor/pace/pace.min.js"></script>
<!-- Tagsinput js -->
<script src="<?php echo base_url(); ?>assets/admin/vendor/tagsinput/jquery.tagsinput.min.js"></script>
<!-- Plugins JS-->
<script src="<?php echo base_url(); ?>assets/admin/js/plugins-1.8.js"></script>

<script src="<?php echo base_url(); ?>assets/admin/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- Custom js -->
<script src="<?php echo base_url(); ?>assets/admin/js/main-1.8.js"></script>
<!--tinyMCE-->
<script src="<?php echo base_url(); ?>assets/vendor/tinymce/jquery.tinymce.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/tinymce/tinymce.min.js"></script>
<script>
    function init_tinymce(selector, min_height) {
        var menu_bar = 'file edit view insert format tools table help';
        if (selector == '.tinyMCEsmall') {
            menu_bar = false;
        }
        tinymce.init({
            selector: selector,
            min_height: min_height,
            valid_elements: '*[*]',
            relative_urls: false,
            remove_script_host: false,
            directionality: directionality,
            entity_encoding: "raw",
            language: "<?php echo $this->selected_lang->text_editor_lang; ?>",
            menubar: menu_bar,
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code codesample fullscreen",
                "insertdatetime media table paste imagetools"
            ],
            toolbar: 'fullscreen code preview | bold italic underline strikethrough | fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | numlist bullist | forecolor backcolor removeformat | table image media link | outdent indent superscript subscript',
            content_css: ['<?php echo base_url(); ?>assets/vendor/tinymce/editor_content.css'],
        });
        tinymce.DOM.loadCSS('<?php echo base_url(); ?>assets/vendor/tinymce/editor_ui.css');
    }

    if ($('.tinyMCE').length > 0) {
        init_tinymce('.tinyMCE', 400);
    }
    if ($('.tinyMCEsmall').length > 0) {
        init_tinymce('.tinyMCEsmall', 300);
    }
    $(document).ready(function () {
        $('.data_table').DataTable({
            "order": [[0, "desc"]],
            "aLengthMenu": [[15, 30, 60, 100], [15, 30, 60, 100, "All"]],
            "language": {
                "lengthMenu": "<?= trans('show'); ?> _MENU_",
                "search": "<?= trans('search'); ?>:",
                "zeroRecords": "<?= trans('no_records_found'); ?>"
            },
            "infoCallback": function (settings, start, end, max, total, pre) {
                return total > 0 ? "<?= trans('number_of_entries'); ?>: " + total : '';
            }
        });
    });
    $(document).ready(function () {
        $('#cs_datatable_currency').DataTable({
            "ordering": false,
            "aLengthMenu": [[15, 30, 60, 100], [15, 30, 60, 100, "All"]],
            "language": {
                "lengthMenu": "<?= trans('show'); ?> _MENU_",
                "search": "<?= trans('search'); ?>:",
                "zeroRecords": "<?= trans('no_records_found'); ?>"
            },
            "infoCallback": function (settings, start, end, max, total, pre) {
                return total > 0 ? "<?= trans('number_of_entries'); ?>: " + total : '';
            }
        });
    });
</script>
<?php if (isset($lang_search_column)): ?>
    <script>
        //datatable
        var table = $('#cs_datatable_lang').DataTable({
            dom: 'l<"#table_dropdown">frtip',
            "order": [[0, "desc"]],
            "aLengthMenu": [[15, 30, 60, 100], [15, 30, 60, 100, "All"]],
            "language": {
                "lengthMenu": "<?= trans('show'); ?> _MENU_",
                "search": "<?= trans('search'); ?>:",
                "zeroRecords": "<?= trans('no_records_found'); ?>",
                "info": "<?= trans('number_of_entries'); ?>: _TOTAL_"
            },
            "infoCallback": function (settings, start, end, max, total, pre) {
                return total > 0 ? "<?= trans('number_of_entries'); ?>: " + total : '';
            }
        });
        //insert a label
        $('<label class="table-label"><label/>').text("<?= trans('language'); ?>").appendTo('#table_dropdown');

        //insert the select and some options
        $select = $('<select class="form-control input-sm"><select/>').appendTo('#table_dropdown');

        $('<option/>').val('').text('<?php echo trans("all"); ?>').appendTo($select);
        <?php foreach ($this->languages as $lang): ?>
        $('<option/>').val('<?php echo $lang->name; ?>').text('<?php echo $lang->name; ?>').appendTo($select);
        <?php endforeach; ?>

        table.column(<?php echo $lang_search_column; ?>).search('').draw();

        $("#table_dropdown select").change(function () {
            table.column(<?php echo $lang_search_column; ?>).search($(this).val()).draw();
        });
    </script>
<?php endif; ?>
<script>
    $('#location_1').on('ifChecked', function () {
        $("#location_countries").hide();
    });
    $('#location_2').on('ifChecked', function () {
        $("#location_countries").show();
    });
    var sweetalert_ok = "<?= trans("ok"); ?>";
    var sweetalert_cancel = "<?= trans("cancel"); ?>";
</script>
</body>
</html>
