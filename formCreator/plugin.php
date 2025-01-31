<?php
class formcreator extends Plugin
{




    public function siteHead()
    {

        include($this->phpPath() . 'PHP/frontend.class.php');
    }


    public function adminController()
    {




        if (isset($_GET['delete'])) {
            include($this->phpPath() . 'PHP/backend.class.php');
            $formClass = new backendFormCreator();
            $formClass->deleteForm($_GET['delete']);
        }
        ;


        if (isset($_POST['savesettings'])) {
            // Collect and sanitize form data
            include($this->phpPath() . 'PHP/backend.class.php');
            $formClass = new backendFormCreator();

            $to = isset($_POST['to']) ? htmlspecialchars($_POST['to']) : '';
            $from = isset($_POST['from']) ? htmlspecialchars($_POST['from']) : '';
            $secretkey = isset($_POST['secretkey']) ? htmlspecialchars($_POST['secretkey']) : '';
            $sitekey = isset($_POST['sitekey']) ? htmlspecialchars($_POST['sitekey']) : '';
            //$redirectpage = isset($_POST['redirectpage']) ? htmlspecialchars($_POST['redirectpage']) : '';
            //$successpage = isset($_POST['successpage']) ? htmlspecialchars($_POST['successpage']) : '';
            //$errorpage = isset($_POST['errorpage']) ? htmlspecialchars($_POST['errorpage']) : '';


            // Create an associative array with the form data
            $settings = array(
                "to" => $to,
                "from" => $from,
                "secretkey" => $secretkey,
                "sitekey" => $sitekey,
                "redirectpage" => '',
                "successpage" => '',
                "errorpage" => ''
            );

            // Encode the array as a JSON object
            $json_data = json_encode($settings, JSON_PRETTY_PRINT);

            // Specify the file path
            $file_path = PATH_CONTENT . 'formCreator/settings.json';

            // Write the JSON data to the file
            if (file_put_contents($file_path, $json_data)) {
                echo "<div class='w3-card w3-green w3-margin-top w3-padding w3-text-center'>Settings saved successfully!</div>";
                echo "<meta http-equiv='refresh' content='1;url=" . DOMAIN_ADMIN. "plugin/formcreator'>";
            }
        }
        ;

        if (isset($_POST['saveform'])) {
            include($this->phpPath() . 'PHP/backend.class.php');
            $formClass = new backendFormCreator();

            $formClass->saveForm();
        }
        ;

    }

    public function adminView()
    {
        include($this->phpPath() . 'PHP/backend.class.php');

        global $security;
        $tokenCSRF = $security->getTokenCSRF();


        include($this->phpPath() . '/PHP/lister.php');

    }

    public function adminSidebar()
    {
        $pluginName = Text::lowercase(__CLASS__);
        $url = HTML_PATH_ADMIN_ROOT . 'plugin/' . $pluginName;
        $html = '<a id="current-version" class="nav-link" href="' . $url . '">✉️ formCreator</a>';
        return $html;
    }
}
;

function showFormCreator($val)
{
    $formClassFront = new frontendFormCreator();
    $formClassFront->show($val);
}


?>