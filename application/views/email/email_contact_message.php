<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('email/_header', ['title' => trans("contact_message")]); ?>
<table role="presentation" class="main">
    <tr>
        <td class="wrapper">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold"><?php echo trans("contact_message"); ?></h1>
                        <div class="mailcontent" style="line-height: 26px;font-size: 14px;">
                            <p style='text-align: center'>
                                <?php echo trans("name"); ?>:&nbsp;<?php echo html_escape($message_name); ?><br>
                                <?php echo trans("email_address"); ?>:&nbsp;<?php echo html_escape($message_email); ?><br><br>
                                <?php echo html_escape($message_text); ?>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php $this->load->view('email/_footer'); ?>
