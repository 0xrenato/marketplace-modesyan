<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<ul>
    <?php if (!empty($this->settings->facebook_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->facebook_url); ?>" class="facebook"><i class="icon-facebook"></i></a></li>
    <?php endif;
    if (!empty($this->settings->twitter_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->twitter_url); ?>" class="twitter"><i class="icon-twitter"></i></a></li>
    <?php endif;
    if (!empty($this->settings->instagram_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->instagram_url); ?>" class="instagram"><i class="icon-instagram"></i></a></li>
    <?php endif;
    if (!empty($this->settings->pinterest_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->pinterest_url); ?>" class="pinterest"><i class="icon-pinterest"></i></a></li>
    <?php endif;
    if (!empty($this->settings->linkedin_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->linkedin_url); ?>" class="linkedin"><i class="icon-linkedin"></i></a></li>
    <?php endif;
    if (!empty($this->settings->vk_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->vk_url); ?>" class="vk"><i class="icon-vk"></i></a></li>
    <?php endif;
    if (!empty($this->settings->whatsapp_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->whatsapp_url); ?>" class="whatsapp"><i class="icon-whatsapp"></i></a></li>
    <?php endif;
    if (!empty($this->settings->telegram_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->telegram_url); ?>" class="telegram"><i class="icon-telegram"></i></a></li>
    <?php endif;
    if (!empty($this->settings->youtube_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->youtube_url); ?>" class="youtube"><i class="icon-youtube"></i></a></li>
    <?php endif;
    if ($this->general_settings->rss_system == 1 && isset($show_rss)): ?>
        <li><a href="<?php echo generate_url("rss_feeds"); ?>" class="rss"><i class="icon-rss"></i></a></li>
    <?php endif; ?>
</ul>
