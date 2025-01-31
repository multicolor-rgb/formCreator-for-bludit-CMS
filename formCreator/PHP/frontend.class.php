<?php

class frontendFormCreator
{
     function show($val)
    {
         function hex_encode($input)
        {
            return bin2hex($input);
        }

         function hex_decode($input)
        {
            return hex2bin($input);
        }

         if (file_exists(PATH_CONTENT . 'formCreator/settings.json')) {
            $file = json_decode(file_get_contents(PATH_CONTENT . 'formCreator/settings.json'));
            $from = $file->from;
            $to = $file->to;
            $secretkey = $file->secretkey;
            $sitekey = $file->sitekey;
            $redirectpage = $file->redirectpage;
            $successpage = $file->successpage;
            $errorpage = $file->errorpage;
        }

        echo '<form method="POST">';

        // Check if form definition file exists and read the form structure
        if (file_exists(PATH_CONTENT . 'formCreator/' . $val . '.json')) {
            $js = file_get_contents(PATH_CONTENT . 'formCreator/' . $val . '.json');
            $json = json_decode($js);

             foreach ($json as $key => $value) {
                $hashed = hex_encode($value[0]);

                 if ($value[1] == 'textarea') {
                    echo '<div class="formcreator-' . $hashed . '">';
                    echo '<label for="' . $hashed . '">' . htmlspecialchars($value[0]) . '</label>';
                    echo '<textarea name="' .  $hashed . '" ' . (isset($value[2]) && $value[2] == 'on' ? 'required' : '') . '></textarea></div>';

                 } elseif ($value[1] == 'select') {
                    $selectarray = isset($value[3]) ? $value[3] : $value[2];
                    $selectarray = explode("|", $selectarray);

                    echo '<div class="formcreator-' . $hashed . '">';
                    echo '<label for="' . $hashed . '">' . htmlspecialchars($value[0]) . '</label>';
                    echo '<select name="' .  hex_encode($value[0]) . '" ' . (isset($value[2]) && $value[2] == 'on' ? 'required' : '') . '>';
                    foreach ($selectarray as $item) {
                        $item = trim($item);
                        echo '<option value="' . htmlspecialchars($item) . '">' . htmlspecialchars($item) . '</option>';
                    }
                    echo '</select></div>';

                 } elseif ($value[1] == 'checkboxes') {
                    echo '<fieldset class="formcreator-' . $hashed . '">';
                    echo '<legend>' . htmlspecialchars($value[0]) . '</legend>';

                    $selectarray = isset($value[3]) ? $value[3] : $value[2];
                    $selectarray = explode("|", $selectarray);

                    foreach ($selectarray as $item) {
                        $item = trim($item);
                        echo '<label for="' . $hashed . '"><input type="checkbox" value="' . htmlspecialchars($item) . '" name="' .  hex_encode($value[0]) . '[]" ' . (isset($value[2]) && $value[2] == 'on' ? 'required' : '') . '> ' . htmlspecialchars($item) . ' </label>';
                    }

                    echo '</fieldset>';

                 } elseif ($value[1] == 'radios') {
                    $selectarray = isset($value[3]) ? $value[3] : $value[2];
                    $selectarray = explode("|", $selectarray);

                    echo '<fieldset class="formcreator-' . $hashed . '">';
                    echo '<legend>' . htmlspecialchars($value[0]) . '</legend>';

                    foreach ($selectarray as $item) {
                        $item = trim($item);
                        echo '<label><input type="radio" value="' . htmlspecialchars($item) . '" name="' .  hex_encode($value[0]) . '" ' . (isset($value[2]) && $value[2] == 'on' ? 'required' : '') . '> ' . htmlspecialchars($item) . ' </label>';
                    }

                    echo '</fieldset>';

                 } else {
                    echo '<div class="formcreator-' . $hashed . '">';
                    echo '<label for="' . $hashed . '">' . htmlspecialchars($value[0]) . '</label>';
                    echo '<input type="' . htmlspecialchars($value[1]) . '" name="' . $hashed . '" ' . (isset($value[2]) && $value[2] == 'on' ? 'required' : '') . '>';
                    echo '</div>';
                }
            }
        }

         echo '
            <div class="g-recaptcha" data-sitekey="' . htmlspecialchars(@$sitekey) . '"></div>
            <input type="submit" style="margin-top:10px;" name="submit" value="Send Message">
        ';
        echo '</form>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>';

        // Handle form submission
        if (isset($_POST['submit'])) {
            $secretKey = @$secretkey;
            $responseKey = $_POST['g-recaptcha-response'];
            $userIP = $_SERVER['REMOTE_ADDR'];
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";

            $response = file_get_contents($url);
            $responseKeys = json_decode($response, true);

             if (intval($responseKeys["success"]) !== 1) {
                echo "<span style='color:red;'>Please complete the CAPTCHA verification.</span>";
            } else {
                $subject = "Message from website!";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: " . htmlspecialchars(@$from) . "\r\n";

                 $message = "
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            color: #333;
                        }
                        .container {
                            padding: 20px;
                            border: 1px solid #ddd;
                            background-color: #f9f9f9;
                        }
                        .header {
                            font-size: 18px;
                            font-weight: bold;
                            margin-bottom: 10px;
                            color: #004085;
                        }
                        .content {
                            margin-bottom: 20px;
                        }
                        .content p {
                            margin: 5px 0;
                        }
                        .footer {
                            font-size: 12px;
                            color: #777;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>You have received a new message from your website:</div>
                        <div class='content'>
                ";

                 $message .= $this->arrayToString($_POST);

                $message .= "
                        </div>
                        <div class='footer'>
                         This email was sent from your websites contact form.
                        </div>
                    </div>
                </body>
                </html>
                ";

                // Send the email
                if (mail($to, $subject, $message, $headers)) {
                    echo "<span style='color:green;'>The message has been sent.</span>";
                } else {
                    echo "<span style='color:red;'>An error occurred while sending the message.</span>";
                 }
            }
        }
    }

     function arrayToString($array)
    {
        $string = '';

        foreach ($array as $name => $value) {
            if ($name !== 'submit' && $name !== 'g-recaptcha-response') {
                // Decode the hex-encoded field name
                $decodedName = hex_decode($name);

                // Check if the value is an array
                if (is_array($value)) {
                    // Join array elements with commas and sanitize each element
                    $joinedValues = implode(', ', array_map('htmlspecialchars', $value));
                    $string .= "<strong>" . htmlspecialchars($decodedName) . "</strong>: " . $joinedValues . "<br>";
                } else {
                    // Sanitize value
                    $string .= "<strong>" . htmlspecialchars($decodedName) . "</strong>: " . htmlspecialchars($value) . "<br>";
                }
            }
        }

        return $string;
    }
}
?>
