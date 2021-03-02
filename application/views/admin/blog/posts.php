<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('blog_posts'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?php echo admin_url(); ?>blog-add-post" class="btn btn-success btn-add-new">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo trans('add_post'); ?>
                    </a>
                </div>
            </div><!-- /.box-header -->

            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="cs_datatable_lang" role="grid"
                                   aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?php echo trans('id'); ?></th>
                                    <th><?php echo trans('title'); ?></th>
                                    <th><?php echo trans('language'); ?></th>
                                    <th><?php echo trans('category'); ?></th>
                                    <th><?php echo trans('date'); ?></th>
                                    <th class="th-options"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($posts as $item): ?>
                                    <?php $post_category = $this->blog_category_model->get_category($item->category_id); ?>
                                    <tr>
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td class="td-product td-blog">
                                            <?php if (!empty($post_category)): ?>
                                                <a href="<?php echo generate_url("blog") . "/" . $post_category->slug; ?>/<?php echo $item->slug; ?>" target="_blank" class="a-table">
                                                    <div class="img-table">
                                                        <img src="<?php echo get_blog_image_url($item, 'image_small'); ?>" alt=""/>
                                                    </div>
                                                    <?php echo html_escape($item->title); ?>
                                                </a>
                                            <?php else: ?>
                                                <div class="img-table">
                                                    <img src="<?php echo get_blog_image_url($item, 'image_small'); ?>" alt=""/>
                                                </div>
                                                <?php echo html_escape($item->title); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $language = get_language($item->lang_id);
                                            if (!empty($language)) {
                                                echo $language->name;
                                            } ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($post_category)): ?>
                                                <?php echo html_escape($post_category->name); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo formatted_date($item->created_at); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                        type="button"
                                                        data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <a href="<?php echo admin_url(); ?>update-blog-post/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('blog_controller/delete_post_post','<?php echo $item->id; ?>','<?php echo trans("confirm_post"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>
