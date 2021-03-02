<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <?php $this->load->view('admin/bidding/_filter_quote_requests'); ?>
                        <thead>
                        <tr role="row">
                            <th><?php echo trans('quote'); ?></th>
                            <th><?php echo trans('product'); ?></th>
                            <th><?php echo trans('seller'); ?></th>
                            <th><?php echo trans('buyer'); ?></th>
                            <th><?php echo trans('status'); ?></th>
                            <th><?php echo trans('sellers_bid'); ?></th>
                            <th><?php echo trans('updated'); ?></th>
                            <th><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($quote_requests as $item): ?>
                            <tr>
                                <td>#<?php echo $item->id; ?></td>
                                <td class="td-product">
                                    <?php $product = get_product($item->product_id);
                                    if (!empty($product)):?>
                                        <div class="img-table">
                                            <a href="<?php echo generate_product_url($product); ?>" target="_blank">
                                                <img src="<?php echo get_product_image($product->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                            </a>
                                        </div>
                                        <a href="<?php echo generate_product_url($product); ?>" target="_blank" class="table-product-title">
                                            <?php echo html_escape($item->product_title); ?>
                                        </a><br>
                                        <?php echo trans("quantity") . ": " . $item->product_quantity; ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php $user = get_user($item->seller_id);
                                    if (!empty($user)):?>
                                        <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank" class="link-black">
                                            <strong class="font-600"><?= html_escape($user->username); ?></strong>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php $user = get_user($item->buyer_id);
                                    if (!empty($user)):?>
                                        <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank" class="link-black">
                                            <strong class="font-600"><?= html_escape($user->username); ?></strong>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo trans($item->status); ?></td>
                                <td>
                                    <?php if ($item->status != 'new_quote_request' && $item->price_offered != 0): ?>
                                        <div class="table-seller-bid">
                                            <p><strong><?php echo price_formatted($item->price_offered, $item->price_currency); ?></strong></p>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo time_ago($item->updated_at); ?></td>
                                <td><?php echo formatted_date($item->created_at); ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_quote_request_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <?php if (empty($quote_requests)): ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>
