<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('email/_header', ['title' => $subject]); ?>
<table role="presentation" class="main">
    <tr>
        <td class="wrapper">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <h1 style="text-decoration: none; font-size: 20px;line-height: 28px;font-weight: bold;margin-bottom: 5px;"><?php echo $subject; ?></h1>
                        <div class="mailcontent" style="line-height: 26px;font-size: 14px;">
                            <p style='text-align: left;margin-bottom: 10px;'>
                                <strong style="font-weight: 600;"><?php echo trans("user"); ?></strong>:<br><?php echo html_escape($message_sender); ?>
                            </p>
                            <p style='text-align: left;margin-bottom: 10px;'>
                                <strong style="font-weight: 600;"><?php echo trans("subject"); ?></strong>:<br><?php echo html_escape($message_subject); ?>
                            </p>
                            <p style='text-align: left;margin-bottom: 10px;'>
                                <strong style="font-weight: 600;"><?php echo trans("message"); ?></strong>:<br><?php echo html_escape($message_text); ?>
                            </p>
                        </div>
                        <p style='text-align: center;margin-top: 60px;'>
                            <a href='<?php echo generate_url("messages"); ?>' style='font-size: 14px;text-decoration: none;padding: 14px 40px;background-color: #09b1ba;color: #ffffff !important; border-radius: 3px;'>
                                <?php echo trans("messages"); ?>
                            </a>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php $this->load->view('email/_footer'); ?>
