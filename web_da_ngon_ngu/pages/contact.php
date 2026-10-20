<table class="form-lang-table">
    <tr>
        <td colspan="2" class="form-title">
            <b><?php echo CONTACT_FORM_TITLE; ?></b>
        </td>
    </tr>
    <tr>
        <td class="form-label"><?php echo USERNAME; ?>:</td>
        <td>
            <input type="text" name="txtUsername">
        </td>
    </tr>
    <tr>
        <td class="form-label"><?php echo BIRTHDAY; ?>:</td>
        <td>
            <input type="text" name="txtBirthday">
        </td>
    </tr>
    <tr>
        <td class="form-label"><?php echo ADDRESS; ?>:</td>
        <td>
            <input type="text" name="txtAddress">
        </td>
    </tr>
    <tr>
        <td class="form-label"><?php echo MAIL; ?>:</td>
        <td>
            <input type="text" name="txtMail">
        </td>
    </tr>
    <tr>
        <td class="form-label"><?php echo PHONE; ?>:</td>
        <td>
            <input type="text" name="txtPhone">
        </td>
    </tr>
    <tr>
        <td class="form-label"><?php echo COMMENT; ?>:</td>
        <td>
            <textarea name="txtComment"></textarea>
        </td>
    </tr>
    <tr>
        <td></td>
        <td class="form-buttons">
            <input type="reset" value="<?php echo BTN_RESET; ?>">
            <input type="submit" value="<?php echo BTN_SUBMIT; ?>">
        </td>
    </tr>
</table>