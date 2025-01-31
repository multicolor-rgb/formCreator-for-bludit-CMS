<?php

class backendFormCreator
{


    function editform($val)
    {

        if (file_exists(PATH_CONTENT . 'formCreator/' . $val . '.json')) {

            $js = file_get_contents(PATH_CONTENT . 'formCreator/' . $val . '.json');

            $json = json_decode($js);


            foreach ($json as $key => $value) {


                echo ' 
                 <div class="w3-border w3-panel w3-light-grey w3-padding-16" style="position:relative;padding-top:30px !important;">
                <button onclick="event.preventDefault();this.parentElement.remove()" class="w3-btn w3-hover-black w3-red closethis" style="position:absolute;top:0;right:0;">X</button>
                <label>' . 'Label type' . '</label>
        <input type="text" name="label-' . $key . '" value="' . $value[0] . '" style="width:100%; margin:10px 0;background:#fff;border:solid 1px #ddd;padding:10px;box-sizing:border-box;">
        <label>' . 'Label type' . '</label>
   <select name="type-' . $key . '"  style="width:100%; margin:10px 0;background:#fff;border:solid 1px #ddd;padding:10px;box-sizing:border-box;">
         <option value="checkbox" >Checkbox</option>
        <option value="color" >Color</option>
        <option value="date">Date</option>
        <option value="datetime-local" >Datetime Local</option>
        <option value="email" >Email</option>
         <option value="month" >Month</option>
        <option value="number" >Number</option>
        <option value="password" >Password</option>
        <option value="radio" >Radio</option>
        <option value="range" >Range</option>
        <option value="tel" >Telephone</option>
        <option value="text" >Text</option>
        <option value="time" >Time</option>
         <option value="week" >Week</option>
        <option value="textarea" >Textarea</option>
          <option value="select" >Select</option>
           <option value="checkboxes" >Checkboxes</option>
           <option value="radios">Radios</option>
    </select>';


                echo '<input name="select-' . $key . '"     type="text" placeholder="option1|option2|option3" value="' . (isset($value[3]) ? $value[3] : '') . (isset($value[2]) && !isset($value[3]) ? $value[2] : '') . '"  style="width:100%; margin:10px 0;background:#fff;border:solid 1px #ddd;padding:10px;box-sizing:border-box; ">';
                ;



                echo '<label style="display:flex;align-items:center;gap:5px;margin-top:10px;margin-bottom:10px;"> Required?</label>
                       <input name="required-' . $key . '" type="checkbox" ' . (isset($value[2]) && $value[2] == 'on' ? 'checked' : '') . '>
    
    </div>


    <script>


 document.querySelector(`select[name="type-' . $key . '"]`).value = `' . $value[1] . '`;


 if(document.querySelector(`select[name="type-' . $key . '"]`).value == "select" ||  document.querySelector(`select[name="type-' . $key . '"]`).value == "checkboxes" ||  document.querySelector(`select[name="type-' . $key . '"]`).value == "radios"){
 document.querySelector(`input[name="select-' . $key . '"]`).style.display="block";
 }else{
  document.querySelector(`input[name="select-' . $key . '"]`).style.display="none";
  }
 

    document.querySelector(`select[name="type-' . $key . '"]`).addEventListener("change",()=>{
    
if(document.querySelector(`select[name="type-' . $key . '"]`).value == "select" ||  document.querySelector(`select[name="type-' . $key . '"]`).value == "checkboxes" ||  document.querySelector(`select[name="type-' . $key . '"]`).value == "radios"){
 document.querySelector(`input[name="select-' . $key . '"]`).style.display="block";
 }else{
  document.querySelector(`input[name="select-' . $key . '"]`).style.display="none";
  }


})

    </script>


    
 


       ';
            }
            ;
        }
    }


    function deleteForm($val)
    {

        unlink(PATH_CONTENT . 'formCreator/' . $val . '.json');
        echo "<meta http-equiv='refresh' content='0;url=" . DOMAIN_ADMIN . "plugin/formCreator'>";
    }


    function saveForm()
    {

        if (isset($_POST['formname']) && $_POST['formname'] !== '') {

            global $SITEURL;
            global $GSADMIN;

            $ars = [];

            $temp = [];


            foreach ($_POST as $key => $value) {

                if ($key === 'formname' || $key === 'saveform' || $key === 'requiredinput') {
                    continue; // Skip these keys
                }
                ;

                $temp[$key] = $value;
            }

            $selectElements = [];  // Array to store select elements temporarily

            foreach ($temp as $key => $value) {
                $baseKey = preg_replace('/^(type-|label-|required-|select-)/', '', $key);

                if (!isset($ars[$baseKey])) {
                    $ars[$baseKey] = [];
                }

                // Check if the key starts with "select-"
                if (strpos($key, 'select-') === 0) {
                    // Store select elements separately
                    $selectElements[$baseKey][] = $value;
                } else {
                    $ars[$baseKey][] = $value;
                }
            }

            foreach ($selectElements as $key => $values) {
                foreach ($values as $value) {
                    $ars[$key][] = $value;
                }
            }

            $json = json_encode($ars, JSON_PRETTY_PRINT);

            $file = file_exists(PATH_CONTENT . 'formCreator/') || mkdir(PATH_CONTENT . 'formCreator/', 0755);

            if ($file) {

                file_put_contents(PATH_CONTENT . 'formCreator/' . @$_POST['formname'] . '.json', $json);
            }

            echo "<meta http-equiv='refresh' content='0;url=" . DOMAIN_ADMIN . "plugin/formcreator?editform=" . $_POST['formname'] . "'>";
        }
    }
}
;
