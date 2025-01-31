<style>
    * {
        box-sizing: border-box;
    }
</style>
<?php if (file_exists(PATH_CONTENT . 'formCreator/settings.json')) {


    $file = json_decode(file_get_contents(PATH_CONTENT . 'formCreator/settings.json'));
    $from = $file->from;
    $to = $file->to;
    $secretkey = $file->secretkey;
    $sitekey = $file->sitekey;
    $redirectpage = $file->redirectpage;
    $successpage = $file->successpage;
    $errorpage = $file->errorpage;
}
;

?>

<h3>Settings Form Creator</h3>

<a href="<?php echo DOMAIN_ADMIN . 'plugin/formcreator'; ?>" style="text-decoration:none !important;"
    class=" w3-button w3-black w3-margin-bottom w3-hover-black">Back to list</a>


<form method="POST" class="w3-border w3-light-gray w3-padding w3-container" style="box-sizing:border-box">

<input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="<?php echo $tokenCSRF;?>">

    <label for="" class="w3-padding-16">Recipients Email</label>
    <input type="text" name="to" value="<?php echo @$to; ?>" class="w3-input w3-border">

    <label for="" class="w3-padding-16">Senders Email </label>
    <input type="text" name="from" value="<?php echo @$from; ?>" class="w3-input w3-border">

    <p class="w3-margin-top">Create your Captcha and copy the codes from <a
            href="https://www.google.com/recaptcha/admin/create" target="_href">Google Recaptcha</a></p>

    <label for="" class="w3-padding-16">Secret Key</label>
    <input type="text" name="secretkey" value="<?php echo @$secretkey; ?>" class="w3-input w3-border">

    <label for="" class="w3-padding-16">Site Key</label>
    <input type="text" name="sitekey" value="<?php echo @$sitekey; ?>" class="w3-input w3-border">

     

 

    <input type="submit" name="savesettings" value="Save Settings"
        class="w3-black w3-btn w3-margin-top">

</form>


<?php if (isset($redirectpage)): ?>

    <script>

        if ('<?php echo $redirectpage; ?>' == 'on') {
            document.querySelector('input[name="redirectpage"]').checked = true;
        };


        if ('<?php echo $successpage; ?>' !== 'none' || '<?php echo $successpage; ?>' !== '') {
            document.querySelector('select[name="successpage"]').value = '<?php echo $successpage; ?>';
        };

        if ('<?php echo $errorpage; ?>' !== 'none' || '<?php echo $errorpage; ?>' !== '') {
            document.querySelector('select[name="errorpage"]').value = '<?php echo $errorpage; ?>';
        };


    </script>

<?php endif; ?>



<?php


?>