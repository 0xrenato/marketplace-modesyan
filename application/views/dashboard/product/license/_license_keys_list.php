<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-license-key-list">
    <div class="table-responsive">
        <?php if (!empty($license_keys)): ?>
            <table class="table table-striped table-custom-modal">
                <thead>
                <tr>
                    <th scope="col"><?php echo trans("license_key"); ?></th>
                    <th scope="col"><?php echo trans("used"); ?></th>
                    <th scope="col"><?php echo trans("options"); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($license_keys)): ?>
                    <?php foreach ($license_keys as $license_key): ?>
                        <tr id="tr_license_key_<?php echo $license_key->id; ?>">
                            <td><?php echo $license_key->license_key; ?></td>
                            <td style="width: 50px;">
                                <?php if ($license_key->is_used == 1):
                                    echo trans("yes");
                                else:
                                    echo trans("no");
                                endif; ?>
                            </td>
                            <td style="width: 80px;">
                                <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="delete_license_key('<?php echo $license_key->id; ?>','<?php echo $product->id; ?>');"><?php echo trans("delete"); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        <?php endif;
        if (empty($license_keys)): ?>
            <p class="text-center">
                <?php echo trans("no_records_found"); ?>
            </p>
        <?php endif; ?>
    </div>
</div>
