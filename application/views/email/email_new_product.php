<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('email/_header', ['title' => trans("email_text_new_product")]); ?>
    <table role="presentation" class="main">
        <tr>
            <td class="wrapper">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold"><?php echo trans("email_text_new_product"); ?></h1>
                            <div class="mailcontent" style="line-height: 26px;font-size: 14px;">
                                <p style='text-align: center'>
                                    <?php echo trans("email_text_see_product"); ?>
                                </p><br>
                                <p style='text-align: center'>
                                    <a href='<?php echo $product_url; ?>' style='font-size: 14px;text-decoration: none;padding: 14px 40px;background-color: #09b1ba;color: #ffffff !important; border-radius: 3px;'>
                                        <?php echo trans("view_product"); ?>
                                    </a>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
<?php $this->load->view('email/_footer'); ?>