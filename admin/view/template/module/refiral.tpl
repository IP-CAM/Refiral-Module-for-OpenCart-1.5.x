<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb[ 'separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>

        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning">
        <?php echo $error_warning; ?>
    </div>
    <?php } ?>
    <div class="box">
        <div class="heading">
             <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>

            <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
            </div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                    <p><strong>Sign up</strong> at <a href="http://www.refiral.com" target="_blank">Refiral.com</a> to get API key.</p>
                    <tr>
                        <td colspan="2"><strong><?php echo $text_account_setting; ?></strong> 
                    </tr>
                    <tr>
                        <td>
                            <?php echo $entry_enable; ?> <span class="required">*</span>
                        </td>
                        <td>
                            <select name="refiral_enable">
                                <?php if ($refiral_enable) { ?>
                                <option value="1" selected="selected">
                                    <?php echo $text_enabled; ?>
                                </option>
                                <option value="0">
                                    <?php echo $text_disabled; ?>
                                </option>
                                <?php } else { ?>
                                <option value="1">
                                    <?php echo $text_enabled; ?>
                                </option>
                                <option value="0" selected="selected">
                                    <?php echo $text_disabled; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $entry_apikey; ?> <span class="required">*</span>
                        </td>
                        <td>
                            <input type="text" name="refiral_apikey" value="<?php echo $refiral_apikey; ?>" size="40" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php echo $footer; ?>