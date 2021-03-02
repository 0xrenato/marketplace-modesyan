<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box admin-small-box bg-success">
            <div class="inner">
                <h3 class="increase-count"><?php echo $order_count; ?></h3>
                <a href="<?php echo admin_url(); ?>orders">
                    <p><?php echo trans("orders"); ?></p>
                </a>
            </div>
            <div class="icon">
                <a href="<?php echo admin_url(); ?>orders">
                    <i class="fa fa-shopping-cart"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box admin-small-box bg-purple">
            <div class="inner">
                <h3 class="increase-count"><?php echo $product_count; ?></h3>
                <a href="<?php echo admin_url(); ?>products">
                    <p><?php echo trans("products"); ?></p>
                </a>
            </div>
            <div class="icon">
                <a href="<?php echo admin_url(); ?>products">
                    <i class="fa fa-shopping-basket"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box admin-small-box bg-danger">
            <div class="inner">
                <h3 class="increase-count"><?php echo $pending_product_count; ?></h3>
                <a href="<?php echo admin_url(); ?>pending-products">
                    <p><?php echo trans("pending_products"); ?></p>
                </a>
            </div>
            <div class="icon">
                <a href="<?php echo admin_url(); ?>pending-products">
                    <i class="fa fa-low-vision"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box admin-small-box bg-warning">
            <div class="inner">
                <h3 class="increase-count"><?php echo $members_count; ?></h3>
                <a href="<?php echo admin_url(); ?>members">
                    <p><?php echo trans("members"); ?></p>
                </a>
            </div>
            <div class="icon">
                <a href="<?php echo admin_url(); ?>members">
                    <i class="fa fa-users"></i>
                </a>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("latest_orders"); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th><?php echo trans("order"); ?></th>
                            <th><?php echo trans("total"); ?></th>
                            <th><?php echo trans("status"); ?></th>
                            <th><?php echo trans("date"); ?></th>
                            <th><?php echo trans("details"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($latest_orders as $item): ?>
                            <tr>
                                <td>#<?php echo $item->order_number; ?></td>
                                <td><?php echo price_formatted($item->price_total, $item->price_currency); ?></td>
                                <td>
                                    <?php if ($item->status == 1):
                                        echo trans("completed");
                                    else:
                                        echo trans("order_processing");
                                    endif; ?>
                                </td>
                                <td><?php echo formatted_date($item->created_at); ?></td>
                                <td style="width: 10%">
                                    <a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix">
                <a href="<?php echo admin_url(); ?>orders"
                   class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("latest_transactions"); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th><?php echo trans("id"); ?></th>
                            <th><?php echo trans("order"); ?></th>
                            <th><?php echo trans("payment_amount"); ?></th>
                            <th><?php echo trans('payment_method'); ?></th>
                            <th><?php echo trans('status'); ?></th>
                            <th><?php echo trans("date"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($latest_transactions as $item): ?>
                            <tr>
                                <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                <td style="white-space: nowrap">#<?php
                                    $order = $this->order_admin_model->get_order($item->order_id);
                                    if (!empty($order)):
                                        echo $order->order_number;
                                    endif; ?>
                                </td>
                                <td><?php echo price_currency_format($item->payment_amount, $item->currency); ?></td>
                                <td><?= get_payment_method($item->payment_method); ?></td>
                                <td><?php echo trans($item->payment_status); ?></td>
                                <td><?php echo formatted_date($item->created_at); ?></td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix">
                <a href="<?php echo admin_url(); ?>transactions"
                   class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("latest_products"); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th><?php echo trans("id"); ?></th>
                            <th><?php echo trans("name"); ?></th>
                            <th><?php echo trans("details"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($latest_products as $item): ?>
                            <tr>
                                <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                <td class="td-product-small">
                                    <div class="img-table">
                                        <a href="<?php echo generate_product_url($item); ?>" target="_blank">
                                            <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                        </a>
                                    </div>
                                    <a href="<?php echo generate_product_url($item); ?>" target="_blank" class="table-product-title">
                                        <?php echo get_product_title($item); ?>
                                    </a>
                                    <br>
                                    <div class="table-sm-meta">
                                        <?php echo time_ago($item->created_at); ?>
                                    </div>
                                </td>
                                <td style="width: 10%">
                                    <a href="<?php echo admin_url(); ?>product-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix">
                <a href="<?php echo admin_url(); ?>products"
                   class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("latest_pending_products"); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th><?php echo trans("id"); ?></th>
                            <th><?php echo trans("name"); ?></th>
                            <th><?php echo trans("details"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($latest_pending_products as $item): ?>
                            <tr>
                                <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                <td class="td-product-small">
                                    <div class="img-table">
                                        <a href="<?php echo generate_product_url($item); ?>" target="_blank">
                                            <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                        </a>
                                    </div>
                                    <a href="<?php echo generate_product_url($item); ?>" target="_blank" class="table-product-title">
                                        <?php echo get_product_title($item); ?>
                                    </a>
                                    <br>
                                    <div class="table-sm-meta">
                                        <?php echo time_ago($item->created_at); ?>
                                    </div>
                                </td>
                                <td style="width: 10%;vertical-align: center !important;">
                                    <a href="<?php echo admin_url(); ?>product-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix">
                <a href="<?php echo admin_url(); ?>pending-products"
                   class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("latest_transactions"); ?>&nbsp;<small style="font-size: 13px;">(<?php echo trans("featured_products"); ?>)</small>
                </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th><?php echo trans("id"); ?></th>
                            <th><?php echo trans('payment_method'); ?></th>
                            <th><?php echo trans("payment_amount"); ?></th>
                            <th><?php echo trans('status'); ?></th>
                            <th><?php echo trans("date"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($latest_promoted_transactions as $item): ?>
                            <tr>
                                <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                <td><?= get_payment_method($item->payment_method); ?></td>
                                <td><?php echo price_currency_format($item->payment_amount, $item->currency); ?></td>
                                <td><?php echo trans($item->payment_status); ?></td>
                                <td><?php echo formatted_date($item->created_at); ?></td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix">
                <a href="<?php echo admin_url(); ?>featured-products-transactions"
                   class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("latest_reviews"); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th><?php echo trans("id"); ?></th>
                            <th><?php echo trans("username"); ?></th>
                            <th style="width: 60%"><?php echo trans("review"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($latest_reviews as $item): ?>
                            <tr>
                                <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                <td style="width: 25%" class="break-word">
                                    <?php echo html_escape($item->user_username); ?>
                                </td>
                                <td style="width: 65%" class="break-word">
                                    <div>
                                        <?php $this->load->view('admin/includes/_review_stars', ['review' => $item->rating]); ?>
                                    </div>
                                    <?php echo character_limiter($item->review, 100); ?>
                                    <div class="table-sm-meta">
                                        <?php echo time_ago($item->created_at); ?>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix">
                <a href="<?php echo admin_url(); ?>reviews"
                   class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("latest_comments"); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th><?php echo trans("id"); ?></th>
                            <th><?php echo trans("user"); ?></th>
                            <th style="width: 60%"><?php echo trans("comment"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($latest_comments as $item): ?>
                            <tr>
                                <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                <td style="width: 25%" class="break-word">
                                    <?php echo html_escape($item->name); ?>
                                </td>
                                <td style="width: 65%" class="break-word">
                                    <?php echo character_limiter($item->comment, 100); ?>
                                    <div class="table-sm-meta">
                                        <?php echo time_ago($item->created_at); ?>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix">
                <a href="<?php echo admin_url(); ?>product-comments"
                   class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>

    <div class="no-padding margin-bottom-20">
        <div class="col-lg-6 col-sm-12 col-xs-12">
            <!-- USERS LIST -->
            <div class="box box-primary box-sm">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo trans("latest_members"); ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="users-list clearfix">
                        <?php if (!empty($latest_members)):
                            foreach ($latest_members as $item) : ?>
                                <li>
                                    <a href="<?php echo generate_profile_url($item->slug); ?>">
                                        <img src="<?php echo get_user_avatar($item); ?>" alt="user" class="img-responsive">
                                    </a>
                                    <a href="<?php echo generate_profile_url($item->slug); ?>" class="users-list-name"><?php echo html_escape($item->username); ?></a>
                                    <span class="users-list-date"><?php echo time_ago($item->created_at); ?></span>
                                </li>
                            <?php endforeach;
                        endif; ?>
                    </ul>
                    <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="<?php echo admin_url(); ?>members" class="btn btn-sm btn-default btn-flat pull-right"><?php echo trans("view_all"); ?></a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!--/.box -->
        </div>
    </div>
</div>



