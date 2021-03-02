<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-confirm">
                    <div class="circle-loader">
                        <div class="checkmark draw"></div>
                    </div>
                    <h1 class="title"><?php echo trans("unsubscribe_successful"); ?></h1>
                    <p><?php echo trans("msg_unsubscribe"); ?></p>
                    <a href="<?php echo lang_base_url(); ?>" class="btn btn-md btn-custom m-t-15"><?php echo trans("goto_home"); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
