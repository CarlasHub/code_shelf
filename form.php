
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset=utf-8>
<title>Form validation with parsely.js</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<link href="parsely.css" rel="stylesheet">


<style type="text/css">
h1 {margin-bottom:20px}
input, label {margin-top:7px; margin-bottom:7px; color:#000066; font-size: 18px; padding-right: 7px}
input[type='checkbox'] {margin-left: 5px}
.note {color: #ff0000}
.success_msg{color:#006600}
</style>
</head>


<body>
<?php


// https://www.w3resource.com/php/form/php-form-validation.php 

$name       =  $_POST['full_name'];
$email      =  $_POST['email'];
$package    =  $_POST['package'];
$arrival    =  $_POST['arv_dt'];
$submit     =  $_POST['submit'];
$people     =  $_POST['persons'];
$facilities =  $_POST['facilities'];

if (isset($submit)) {
    
//checking name

if(empty($name))
$msg_name = "You must supply your name";
$name_pattern = '/^[a-zA-Z ]*$/';

preg_match($name_pattern, $name, $name_matches);

if(!$name_matches[0])

$msg2_name = "Only alphabets and white space allowed";


//check email

if(empty($email))

$msg_email = "You must supply your email";
$email_pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';

preg_match($email_pattern, $email, $email_matches);

if(!$email_matches[0])

$msg2_email = "Must be of valid email format";


//check package

if(empty($package))

$msg_package = "You must select a package";


//date validation

if(empty($arrival))
$msg_dt = "You must supply an arival date";

if(!empty($arrival))
{
    
    
    $array = explode("/",$arrival);

    $day   = $array[1];
    
    $month = $array[0];
    
    $year  = $array[2];

    if(!checkdate($month, $day, $year))
    {
    $msg2_dt = "Must be in m/d/y format";
    }
    else
    {
    $today = strtotime("now");
    
    if(strtotime($arrival)<$today)

    $msg3_dt = "Date supplied is before present day";
    }
}

//checking for non-empty and non-negative integer

if(empty($people))

$msg_persons = "You must supply number of persons travelling";

if(!empty($people))
{

preg_match("@^([1-9][0-9]*)$@", $people, $persons_match);

if(!$persons_match[0])

$msg2_persons = "Must be non negative integer";
}
// //check discount coupon
// //[^a-z0-9_]

// if($_POST['dis_code'])
// {
//  $dis_code = $_POST['dis_code'];
 
//  preg_match("/^[a-zA-Z0-9]+$/", $dis_code, $dis_match);
 
//  if(!$dis_match[0])
 
//  $msg_dis = "Must be alphanumric"; 
 
//  if(strlen($dis_code)!='10')
 
//  $msg2_dis = "Must be 10 characters long";
// }

//checking facilities


  if(empty($facilities)) 
  {
      
    $msg_facilities = "You must select facilities";
    
  } 
 
 if(!empty($facilities)) {
     
    $no_checked = count($facilities);
    
    if($no_checked<2)
    
    $msg2_facilities = "Select at least two options";
    
    }
}



?>
<?php
//checking terms 
$tnc = $_POST['tnc'];
switch($tnc)
{
case "agree":
$tncv="checked";
$tnc1v="";
break;

case "disagree":
$tncv="";
$tnc1v="checked";
$msg2_agree = "You must agree";
break;

default: // By default 1st option is selected
$tncv="checked";
$tnc1v="";
break;
};
?>
<?php

// validation complete 

if(isset($_POST['submit'])){
    
if($msg_name=="" 
&& $msg2_name=="" 
&& $msg_email==""
&& $msg2_email=="" 
&& $msg_package==""
&& $msg_dt==""
&& $msg2_dt==""
&& $msg3_dt=="" 
&& $msg_persons=="" 
&& $msg2_persons=="" 
&& $msg_facilities==""
&& $msg2_facilities==""
&& $msg_dis==""
&& $msg2_dis=="" 
&& $msg_agree==""
&& $msg2_agree=="")

$msg_success = "You filled this form up correctly <br> Your  details are  : 
$name<br> 
$email<br>     
$package<br>  
$arrival<br>  
$submit<br> 
$people<br>
$facilities";
}
 
?>
        <div class="container">
        
        <h3><span class="note">*</span> denotes mandotory</h3>
        
        <?php echo "<h3 class='success_msg'>".$msg_success."</h3>"; ?>
            
            <form id="registration_form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            
                <!--name-->
             
              <input type="text" name="full_name" placeholder="Full Name" autofocus="autofocus" value="<?php echo $_POST['full_name']; ?>">  
              
              <?php echo "<p class='note'>".$msg_name."</p>";?>
              <?php echo "<p class='note'>".$msg2_name."</p>";?>
              
              <!--email-->
              
              <input type="text" name="email"  placeholder="email" value="<?php echo $_POST['email_addr']; ?>">
               <?php echo "<p class='note'>".$msg_email."</p>";?>
              <?php echo "<p class='note'>".$msg2_email."</p>";?>
              
              <!--select-->
              
               <label>Select Tour Package<span class="note">*</span>:</label>   
               <select name="package">
                <option value="patagonia" <?= ($_POST['package'] == "1")? "selected":"";?>>Patagonia</options>
                <option value="canada" <?= ($_POST['package'] == "2")? "selected":"";?>>Canada</options>
                <option value="budapeste" <?= ($_POST['package'] == "3")? "selected":"";?>>Budapeste</options>
               </select>
               
              <?php echo "<p class='note'>".$msg_package."</p>";?>
              
              
              
              <!--arrival date-->
              <label>Arrival date<span class="note">*</span>:</label>
              <input type="text" name="arv_dt" placeholder="m/d/y" value="<?php echo $_POST['arv_dt']; ?>">
              <?php echo "<p class='note'>".$msg_dt."</p>";?>
              <?php echo "<p class='note'>".$msg2_dt."</p>";?>
              <?php echo "<p class='note'>".$msg3_dt."</p>";?>
              
              
              
              <label>Number of persons<span class="note">*</span>:</label>
              <input type="text" name="persons" value="<?php echo $_POST['persons']; ?>"s>
              <?php echo "<p class='note'>".$msg_persons."</p>";?>
              <?php echo "<p class='note'>".$msg2_persons."</p>";?>
              
              
             <label>What would you want to avail?<span class="note">*</span></label>
             
             Boarding
             <input type="checkbox" name="facilities[]" value="boarding" <?php if(isset($_POST['submit']) && isset($_POST['facilities'][0])) echo "checked" ?> >
             
             Fooding
             <input type="checkbox" name="facilities[]" value="fooding" <?php if(isset($_POST['submit']) && isset($_POST['facilities'][1])) echo "checked" ?> >
             
             Sight seeing
             <input type="checkbox" name="facilities[]" value="sightseeing" <?php if(isset($_POST['submit']) && isset($_POST['facilities'][2])) echo "checked" ?> >
             
             <?php echo "<p class='note'>".$msg_facilities."</p>";?>
             <?php echo "<p class='note'>".$msg2_facilities."</p>";?>
             
             
              <label>Terms and conditions<span class="note">*</span></label><br>
              
              <input type="radio" name="tnc" value="agree" <?php echo $tncv; ?>>I agree<br>
              <input type="radio" name="tnc" value="disagree" <?php echo $tnc1v; ?>>I disagree<br>
              
              <?php echo "<p class='note'>".$msg_agree."</p>";?>
              <?php echo "<p class='note'>".$msg2_agree."</p>";?>
              
              <button type="submit" class="btn btn-large btn-primary" name="submit">Complete reservation</button>
              
            </form>
        </div>
    </body>
</html>

