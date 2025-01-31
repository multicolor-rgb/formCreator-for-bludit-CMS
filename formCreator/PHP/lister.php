

<?php

echo '<link href="' . $this->domainPath() . 'PHP/css/w3.css' . '"  rel="stylesheet">';

$formClass = new backendFormCreator();

if (isset($_GET['addnewform']) || isset($_GET['editform'])) {
    include($this->phpPath() . '/PHP/edit.php');
} elseif (isset($_GET['settings'])) {
    include($this->phpPath() . '/PHP/settings.php');
} else {
    include($this->phpPath() . '/PHP/list.php');
}

echo "
<div style='text-decoration:none !important;margin-top:20px;display:flex;align-items:center;justify-content:space-between;box-sizing:border-box' class='w3-border w3-padding w3-light-gray'>
<p style='margin:0 auto'>Do you like my work? Are you using  this in a commercial project?</p>
<a href='https://ko-fi.com/I3I2RHQZS' target='_blank'><img height='36' style='border:0px;height:36px;' src='https://storage.ko-fi.com/cdn/kofi3.png?v=3' border='0' alt='Buy Me a Coffee at ko-fi.com' /></a> 
</div>";
echo '<script src="' . $this->domainPath() . 'PHP/js/w3.js' . '"></script>';
 


; ?>