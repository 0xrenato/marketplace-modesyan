<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="<?php echo base_url(); ?>assets/admin/vendor/chart/chart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/vendor/chart/utils.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/vendor/chart/analyser.js"></script>

<div class="row m-b-30">
    <div class="col-sm-12">
        <div class="small-boxes-dashboard">
            <?php if ($this->is_sale_active): ?>
                <div class="col-lg-3 col-md-6 col-sm-12 p-0">
                    <div class="small-box-dashboard small-box-dashboard-first">
                        <h3 class="total"><?= $total_sales_count; ?></h3>
                        <span class="text-muted"><?= trans("number_of_total_sales"); ?></span>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                            <path fill-rule="evenodd" d="M11.354 5.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 p-0">
                    <div class="small-box-dashboard">
                        <h3 class="total"><?= price_formatted($this->auth_user->balance, $this->payment_settings->default_currency); ?></h3>
                        <span class="text-muted"><?= trans("balance"); ?></span>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cash-stack" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 3H1a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1h-1z"/>
                            <path fill-rule="evenodd" d="M15 5H1v8h14V5zM1 4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H1z"/>
                            <path d="M13 5a2 2 0 0 0 2 2V5h-2zM3 5a2 2 0 0 1-2 2V5h2zm10 8a2 2 0 0 1 2-2v2h-2zM3 13a2 2 0 0 0-2-2v2h2zm7-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
                        </svg>
                    </div>
                </div>
            <?php endif; ?>
            <div<?= !$this->is_sale_active ? ' class="classified-small-boxes"' : ''; ?>>
                <div class="col-lg-3 col-md-6 col-sm-12 p-0">
                    <div class="small-box-dashboard" <?= !$this->is_sale_active ? 'style="border-radius: 4px 0 0 4px;"' : ''; ?>>
                        <h3 class="total"><?= $products_count; ?></h3>
                        <span class="text-muted"><?= trans("products"); ?></span>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-basket" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 p-0">
                    <div class="small-box-dashboard small-box-dashboard-last">
                        <h3 class="total"><?= !empty($total_pageviews_count) ? $total_pageviews_count : '0'; ?></h3>
                        <span class="text-muted"><?= trans("page_views"); ?></span>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bar-chart" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5h-2v12h2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($this->is_sale_active): ?>
    <div class="row">
        <?php if (!empty($active_sales_count) || !empty($completed_sales_count)): ?>
            <div class="col-lg-4 col-sm-12 col-xs-12">
                <div class="box box-primary box-sm index-box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo trans("sales"); ?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="index-chart-container">
                            <canvas id="chart_sales"></canvas>
                        </div>
                    </div>
                    <div class="box-footer clearfix"></div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12 col-xs-12">
                <div class="box box-primary box-sm index-box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo trans("monthly_sales"); ?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="index-chart-container">
                            <canvas id="chart_montly_sales"></canvas>
                        </div>
                    </div>
                    <div class="box-footer clearfix"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
<div class="row">
    <?php if ($this->is_sale_active): ?>
        <div class="col-lg-6 col-sm-12 col-xs-12">
            <div class="box box-primary box-sm index-box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo trans("latest_sales"); ?></h3>
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
                                <th><?php echo trans("sale"); ?></th>
                                <th><?php echo trans("total"); ?></th>
                                <th><?php echo trans("status"); ?></th>
                                <th><?php echo trans("date"); ?></th>
                                <th><?php echo trans("options"); ?></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($latest_sales as $item): ?>
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
                                    <td><?php echo date("Y-m-d / h:i", strtotime($item->created_at)); ?></td>
                                    <td style="width: 10%">
                                        <a href="<?php echo generate_dash_url("sale"); ?>/<?php echo html_escape($item->order_number); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>

                <div class="box-footer clearfix text-right">
                    <a href="<?= generate_dash_url("sales"); ?>" class="btn btn-sm btn-default"><?php echo trans("view_all"); ?></a>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm index-box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("most_viewed_products"); ?></h3>
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
                            <th><?php echo trans("product"); ?></th>
                            <th><?php echo trans("page_views"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if (!empty($most_viewed_products)):
                            foreach ($most_viewed_products as $item): ?>
                                <tr>
                                    <td style="width: 10%"><?= html_escape($item->id); ?></td>
                                    <td><a href="<?= generate_product_url($item); ?>" class="link-black" target="_blank"><?= get_product_title($item); ?></a></td>
                                    <td><?= $item->pageviews; ?></td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix text-right">
                <a href="<?php echo generate_dash_url("comments"); ?>" class="btn btn-sm btn-default"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm index-box">
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
                            <th><?php echo trans("comment"); ?></th>
                            <th><?php echo trans("product"); ?></th>
                            <th><?php echo trans("date"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if (!empty($latest_comments)):
                            foreach ($latest_comments as $item):
                                $product = get_active_product($item->product_id); ?>
                                <tr>
                                    <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                    <td style="width: 35%"><?php echo character_limiter(html_escape($item->comment), 40, '...'); ?></td>
                                    <td style="width: 35%">
                                        <?php if (!empty($product)): ?>
                                            <a href="<?php echo lang_base_url() . $product->slug; ?>" class="link-black" target="_blank">
                                                <?php echo character_limiter(get_product_title($product), 40, '...'); ?>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="white-space-nowrap" style="width: 20%"><?php echo formatted_date($item->created_at); ?></td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix text-right">
                <a href="<?php echo generate_dash_url("comments"); ?>" class="btn btn-sm btn-default"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm index-box">
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
                            <th><?php echo trans("comment"); ?></th>
                            <th><?php echo trans("product"); ?></th>
                            <th><?php echo trans("date"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if (!empty($latest_reviews)):
                            foreach ($latest_reviews as $item):
                                $product = get_active_product($item->product_id); ?>
                                <tr>
                                    <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                    <td class="break-word">
                                        <div class="pull-left" style="width: 100%;">
                                            <?php $this->load->view('admin/includes/_review_stars', ['review' => $item->rating]); ?>
                                        </div>
                                        <p class="pull-left">
                                            <?php echo html_escape($item->review); ?>
                                        </p>
                                    </td>
                                    <td style="width: 35%">
                                        <?php if (!empty($product)): ?>
                                            <a href="<?php echo lang_base_url() . $product->slug; ?>" class="link-black" target="_blank">
                                                <?php echo character_limiter(get_product_title($product), 40, '...'); ?>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="white-space-nowrap" style="width: 20%"><?php echo formatted_date($item->created_at); ?></td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix text-right">
                <a href="<?php echo generate_dash_url("reviews"); ?>" class="btn btn-sm btn-default"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($active_sales_count) || !empty($completed_sales_count)): ?>
    <script>
        //total sales
        var ctx = document.getElementById('chart_sales').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    "<?= trans("active_sales"); ?> (<?= !empty($active_sales_count) ? $active_sales_count : 0; ?>)",
                    "<?= trans("completed_sales"); ?> (<?= !empty($completed_sales_count) ? $completed_sales_count : 0; ?>)"
                ],
                datasets: [{
                    data: [<?= !empty($active_sales_count) ? $active_sales_count : 0; ?>, <?= !empty($completed_sales_count) ? $completed_sales_count : 0; ?>],
                    backgroundColor: [
                        '#1BC5BD',
                        '#6993FF'
                    ],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 70,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return data['labels'][tooltipItem['index']];
                        }
                    }
                }
            }
        });
    </script>
<?php endif; ?>
<script>
    //monthly sales
    var months = ["<?= trans("january");?>", "<?= trans("february");?>", "<?= trans("march");?>", "<?= trans("april");?>", "<?= trans("may");?>", "<?= trans("june");?>", "<?= trans("july");?>", "<?= trans("august");?>", "<?= trans("september");?>", "<?= trans("october");?>", "<?= trans("november");?>", "<?= trans("december");?>"];
    var i;
    for (i = 0; i < months.length; i++) {
        months[i] = months[i].substr(0, 3);
    }
    var presets = window.chartColors;
    var utils = Samples.utils;
    var inputs = {
        min: 0,
        max: 100,
        count: 8,
        decimals: 2,
        continuity: 1
    };
    var options = {
        maintainAspectRatio: false,
        spanGaps: false,
        elements: {
            line: {
                tension: 0.000001
            }
        },
        plugins: {
            filler: {
                propagate: false
            }
        },
        scales: {
            x: {
                ticks: {
                    autoSkip: false,
                    maxRotation: 0
                }
            },
            yAxes: [
                {
                    ticks: {
                        beginAtZero: true,
                        callback: function (label, index, labels) {
                            return "<?= $this->default_currency->symbol; ?>" + label;
                        }
                    }
                }
            ]
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    return data['labels'][tooltipItem['index']] + ": <?= $this->default_currency->symbol; ?>" + data['datasets'][0]['data'][tooltipItem['index']];
                }
            }
        }
    };
    [false, 'origin', 'start', 'end'].forEach(function () {
        utils.srand(8);
        new Chart('chart_montly_sales', {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    backgroundColor: utils.transparentize("#bfe8e6"),
                    borderColor: "#1BC5BD",
                    data: [<?php for ($i = 1; $i <= 12; $i++) {
                        echo $i > 1 ? ',' : '';
                        $total = 0;
                        if (!empty($sales_sum)):
                            foreach ($sales_sum as $sum):
                                if (isset($sum->month) && $sum->month == $i):
                                    $total = $sum->total_amount;
                                    break;
                                endif;
                            endforeach;
                        endif;
                        echo get_price($total, 'decimal');
                    }?>],
                    label: "<?= trans("sales"); ?> (<?= date("Y") ?>)"
                }]
            },
            options: Chart.helpers.merge(options, {
                title: {
                    display: false
                },
                elements: {
                    line: {
                        tension: 0.4,
                        borderWidth: 2
                    }
                }
            })
        });
    });
</script>