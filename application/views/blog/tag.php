<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <div class="blog-content">
                    <nav class="nav-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo generate_url("blog"); ?>"><?php echo trans("blog"); ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo html_escape($tag->tag_slug); ?></li>
                        </ol>
                    </nav>

                    <h1 class="page-title"><?php echo trans("tag"); ?>:&nbsp;<?php echo html_escape($tag->tag); ?></h1>
                    <div class="row">
                        <div class="col-12">
                            <!--Include banner-->
                            <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "blog_1", "class" => "m-b-30"]); ?>
                        </div>
                    </div>

                    <div class="row">
                        <!--print blog posts-->
                        <?php foreach ($posts as $item): ?>
                            <div class="col-xs-12 col-sm-6 col-lg-4">
                                <?php $this->load->view('blog/_blog_item', ['item' => $item]); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="row">
                        <!-- Pagination -->
                        <div class="col-sm-12">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <!--Include banner-->
                            <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "blog_1", "class" => ""]); ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Wrapper End-->
