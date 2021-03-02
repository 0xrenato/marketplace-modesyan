<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-confirm">
                    <?php if (!empty($success)): ?>
                        <div class="circle-loader">
                            <div class="checkmark draw"></div>
                        </div>
                        <h1 class="title">
                            <?php echo $success; ?>
                        </h1>
                        <a href="<?php echo lang_base_url(); ?>" class="btn btn-md btn-custom m-t-15"><?php echo trans("goto_home"); ?></a>
                    <?php elseif (!empty($error)): ?>
                        <div class="error-circle">
                            <i class="icon-close-thin"></i>
                        </div>
                        <h1 class="title">
                            <?php echo $error; ?>
                        </h1>
                        <a href="<?php echo lang_base_url(); ?>" class="btn btn-md btn-custom m-t-15"><?php echo trans("goto_home"); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>