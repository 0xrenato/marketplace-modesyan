<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('email/_header', ['title' => trans("confirm_your_email")]); ?>
<table role="presentation" class="main">
    <tr>
        <td class="wrapper">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold"><?php echo trans("confirm_your_account"); ?></h1>
                        <div class="mailcontent" style="line-height: 26px;font-size: 14px;">
                            <p style='text-align: center'>
                                <?php echo trans("msg_confirmation_email"); ?><br>
                            </p>
                            <p style='text-align: center;margin-top: 30px;'>
                                <a href="<?php echo lang_base_url(); ?>confirm?token=<?php echo $token; ?>" style='font-size: 14px;text-decoration: none;padding: 14px 40px;background-color: #09b1ba;color: #ffffff !important; border-radius: 3px;'>
                                    <?php echo trans("confirm_your_account"); ?>
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
