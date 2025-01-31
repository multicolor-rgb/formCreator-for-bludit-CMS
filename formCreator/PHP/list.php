
<style>
    * {
        box-sizing: border-box;
    }
</style>

<div class="w3-parent">

    <h3>Form Creator List 💌</h3>

    <a href="<?php echo DOMAIN_ADMIN . 'plugin/formcreator?addnewform'; ?>" style="text-decoration:none !important;" class=" w3-button w3-black w3-margin-bottom w3-hover-black">Add New</a>
    <a href="<?php echo DOMAIN_ADMIN. 'plugin/formcreator?settings'; ?>" style="text-decoration:none !important;" class=" w3-button w3-black w3-margin-bottom w3-hover-black">Settings</a>


    <ul class="w3-ul w3-border" style="margin:0;padding:0;">


        <?php foreach (glob(PATH_CONTENT . 'formCreator/*.json') as $file): ?>


            <?php if (pathinfo($file)['filename'] !== 'settings'): ?>

                <li style="display:flex;justify-content:space-between;margin:align-items:center;">
                    <h6 style="font-weight:bold;"> <?php echo pathinfo($file)['filename']; ?> </h6>

                    <p style="margin-top:8px;display:block;font-size:0.9rem;color:#333;">&lt;?php showFormCreator('<?php echo pathinfo($file)['filename']; ?>');?></p>

                    <div class="link">
                        <a href="<?php echo DOMAIN_ADMIN;?>plugin/formcreator?editform=<?php echo pathinfo($file)['filename']; ?>" class="w3-button  w3-black w3-button w3-tiny w3-hover-black" style="text-decoration:none !important;">Edit</a>
                        <a href="<?php echo DOMAIN_ADMIN;?>plugin/formcreator?delete=<?php echo pathinfo($file)['filename']; ?>" class="w3-button w3-red w3-button w3-tiny w3-hover-black" onclick="confirm('Are you sure you want to delete this item?')" style="text-decoration:none !important;">Delete</a>
                    </div>
                </li>

            <?php endif; ?>

        <?php endforeach; ?>

    </ul>

</div>