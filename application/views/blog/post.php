<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
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
                            <li class="breadcrumb-item"><a href="<?php echo generate_url("blog") . "/" . html_escape($post->category_slug); ?>"><?php echo html_escape($post->category_name); ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo html_escape($post->title); ?></li>
                        </ol>
                    </nav>

                    <div class="row">
                        <div class="col-sm-12 col-md-9">
                            <div class="post-content">
                                <div class="row-custom">
                                    <h1 class="title"><?php echo html_escape($post->title); ?></h1>
                                </div>
                                <div class="row-custom">
                                    <div class="blog-post-meta">
                                        <a href="<?php echo generate_url("blog") . "/" . html_escape($post->category_slug); ?>">
                                            <i class="icon-folder"></i><?php echo html_escape($post->category_name); ?>
                                        </a>
                                        <span><i class="icon-clock"></i><?php echo time_ago($post->created_at); ?></span>
                                    </div>
                                </div>
                                <div class="row-custom">
                                    <div class="post-image">
                                        <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?php echo get_blog_image_url($post, 'image_default'); ?>" alt="<?php echo html_escape($post->title); ?>" class="img-fluid lazyload"/>
                                    </div>
                                </div>
                                <div class="row-custom">
                                    <div class="post-text post-text-responsive">
                                        <?php echo $post->content; ?>
                                    </div>
                                </div>

                                <div class="row-custom m-b-20">
                                    <div class="post-tags">
                                        <ul>
                                            <!--print tags-->
                                            <?php foreach ($post_tags as $tag): ?>
                                                <li>
                                                    <a href="<?php echo generate_url("blog", "tag") . "/" . html_escape($tag->tag_slug); ?>"><?php echo html_escape($tag->tag); ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row-custom row-bn">
                                    <!--Include banner-->
                                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "blog_post_details", "class" => "m-b-10"]); ?>
                                </div>

                                <div class="row-custom">
                                    <div class="post-share">
                                        <h4 class="title"><?php echo trans("share"); ?></h4>
                                        <a href="javascript:void(0)"
                                           onclick='window.open("https://www.facebook.com/sharer/sharer.php?u=<?php echo generate_url("blog") . "/" . html_escape($category->slug) . "/" . html_escape($post->slug); ?>", "Share This Post", "width=640,height=450");return false'
                                           class="btn btn-md btn-share facebook">
                                            <i class="icon-facebook"></i>
                                            <span>Facebook</span>
                                        </a>

                                        <a href="javascript:void(0)"
                                           onclick='window.open("https://twitter.com/share?url=<?php echo generate_url("blog") . "/" . html_escape($category->slug) . "/" . html_escape($post->slug); ?>&amp;text=<?php echo html_escape($post->title); ?>", "Share This Post", "width=640,height=450");return false'
                                           class="btn btn-md btn-share twitter">
                                            <i class="icon-twitter"></i>
                                            <span>Twitter</span>
                                        </a>

                                        <a href="https://api.whatsapp.com/send?text=<?php echo str_replace("&", "", $post->title); ?> - <?php echo generate_url("blog") . "/" . html_escape($category->slug) . "/" . html_escape($post->slug); ?>" target="_blank"
                                           class="btn btn-md btn-share whatsapp">
                                            <i class="icon-whatsapp"></i>
                                            <span>Whatsapp</span>
                                        </a>

                                        <a href="javascript:void(0)"
                                           onclick='window.open("http://pinterest.com/pin/create/button/?url=<?php echo generate_url("blog") . "/" . html_escape($category->slug) . "/" . html_escape($post->slug); ?>&amp;media=<?php echo get_blog_image_url($post, 'image_small'); ?>", " Share This Post", "width=640,height=450");return false'
                                           class="btn btn-md btn-share pinterest">
                                            <i class="icon-pinterest"></i>
                                            <span>Pinterest</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="row-custom">
                                    <div class="related-posts">
                                        <h4 class="blog-section-title"><?php echo trans("related_posts"); ?></h4>
                                        <div class="row">
                                            <!--print related posts-->
                                            <?php foreach ($related_posts as $item): ?>
                                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                                    <?php $this->load->view('blog/_blog_item_small', ['item' => $item]); ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($this->general_settings->blog_comments == 1 || $this->general_settings->facebook_comment_status == 1): ?>
                                    <div class="blog-comments-section">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs">
                                            <?php if ($this->general_settings->blog_comments == 1): ?>
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#comments"><?php echo trans("comments"); ?></a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($this->general_settings->facebook_comment_status == 1): ?>
                                                <li class="nav-item">
                                                    <a class="nav-link <?php echo ($this->general_settings->blog_comments != 1) ? 'active' : ''; ?>" data-toggle="tab" href="#facebook_comments">
                                                        <?php echo trans("facebook_comments"); ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <?php if ($this->general_settings->blog_comments == 1): ?>
                                                <div class="tab-pane container active" id="comments">
                                                    <?php $this->load->view('blog/_comment_box'); ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($this->general_settings->facebook_comment_status == 1): ?>
                                                <div class="tab-pane container <?php echo ($this->general_settings->blog_comments != 1) ? 'active' : 'fade'; ?>" id="facebook_comments">
                                                    <div class="fb-comments" data-href="<?php echo current_url(); ?>" data-width="100%" data-numposts="5"
                                                         data-colorscheme="light"></div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3">
                            <div class="latest-posts">
                                <h4 class="blog-section-title"><?php echo trans("latest_posts"); ?></h4>
                                <div class="row">
                                    <!--print related posts-->
                                    <?php foreach ($latest_posts as $item): ?>
                                        <div class="col-sm-12">
                                            <?php $this->load->view('blog/_blog_item_small', ['item' => $item]); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="blog-tags">
                                <h4 class="blog-section-title"><?php echo trans("tags"); ?></h4>
                                <ul>
                                    <!--print tags-->
                                    <?php foreach ($random_tags as $tag): ?>
                                        <li>
                                            <a href="<?php echo generate_url("blog", "tag") . "/" . html_escape($tag->tag_slug); ?>"><?php echo html_escape($tag->tag); ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div class="row-custom">
                                <!--Include banner-->
                                <?php $this->load->view("partials/_ad_spaces_sidebar", ["ad_space" => "blog_post_details_sidebar", "class" => "m-t-30 text-left"]); ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>
<?php if ($this->general_settings->facebook_comment_status == 1):
    echo $this->general_settings->facebook_comment;
endif; ?>
