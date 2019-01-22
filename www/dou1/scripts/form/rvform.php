<?php
/**
 *
 * PLEASE DO NOT REMOVE THIS HEADER!!!
 *
 * COPYRIGHT NOTICE
 *
 * FormMail.php v5.0
 * Copyright 2000-2004 Ai Graphics and Joe Lumbroso (c) All rights reserved.
 * Created 07/06/2000   Last Modified 10/28/2003
 * Joseph Lumbroso, http://www.aigraphics.com, http://www.dtheatre.com
 *                  http://www.dtheatre.com/scripts/
 *
 *
 * This cannot and will not be inforced but I would appreciate a link back
 * to any of these sites:
 * http://www.dtheatre.com
 * http://www.aigraphics.com
 * http://www.dtheatre.com/scripts/
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR
 * OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 *
 * @filesource http://www.dtheatre.com/scripts/ <Jack's Formmail.php Version 5.0>
 * @author  Pairote Manunphol <pairote@rvskin.com>
 * @version $Revision$
 * @since   PHP 4.1
 *
 */
$aRVSPublist = loadPublishList();

if ( is_file( dirname(dirname(dirname(__FILE__))) . "/rvsStaticWeb.php") && isset($aRVSPublist['ComponentAndUserFramework'])) {
   // include( dirname(dirname(dirname(__FILE__))) . "/rvscommonfunc.php");
    include( dirname(dirname(dirname(__FILE__))) . "/rvsStaticWeb.php");

    // include fsbb and use SGL_Fsbb
    
    if (class_exists('SGL_Fsbb')) {
    $rvblocker = &SGL_Fsbb::singleton();
} else {
    include(dirname(dirname(dirname(__FILE__))) . '/scripts/fsbb/fsbb.php');
    $rvblocker=new formSpamBotBlocker();
}

} else {

    include(dirname(dirname(dirname(__FILE__))) . '/scripts/fsbb/fsbb.php');
    $rvblocker=new formSpamBotBlocker();
}
/**
 * @global VERSION <Jack's Formmail.php Version>
 * Default "5.0"
 */
define("VERSION", "5.0");

/**
 * @global SEPARATOR <field / value seperator>
 *
 * Default ": "
 */
define("SEPARATOR", ": ");

/**
 * @global NEWLINE <content newline>
 *
 * Default "\n"
 */
define( "NEWLINE" , "\n");


$rvformid = $_REQUEST['rvformid'];
$required = $_REQUEST['required'];


/**
 * Read RVSitebuilder form mail INI file
 * @ignore rvform_$ID.ini.php
 */
if ($rvformid && is_file( dirname(__FILE__) . '/rvform_' . $rvformid .'.ini.php')) {
    $iniFile = 'rvform_' . $rvformid .'.ini.php';
}
else {
    echo 'Could not find online form configuration file ID=' . $rvformid . ' for RV SiteBuilder formmail.';
    exit;
}
//echo dirname(__FILE__) . '/' . $iniFile;
$CONF = @parse_ini_file( dirname(__FILE__) . '/' . $iniFile, true);


$require = (isset($_REQUEST['require'])) ? $_REQUEST['require'] : false;
$name = (isset($_REQUEST['name'])) ? $_REQUEST['name'] : false;
//set email
if (isset($_REQUEST['email'])) {
    $email = $_REQUEST['email'];
} elseif (isset($_REQUEST['EMAIL'])) {
    $email = $_REQUEST['EMAIL'];
} elseif (isset($_REQUEST['Email'])) {
    $email = $_REQUEST['Email'];
} elseif (isset($_REQUEST['e-mail'])) {
    $email = $_REQUEST['e-mail'];
} elseif (isset($_REQUEST['E-mail'])) {
    $email = $_REQUEST['E-mail'];
} elseif (isset($_REQUEST['mail'])) {
    $email = $_REQUEST['mail'];
} elseif (isset($_REQUEST['Mail'])) {
    $email = $_REQUEST['Mail'];
} elseif (isset($_REQUEST['MAIL'])) {
    $email = $_REQUEST['MAIL'];
} else {
    $email = false;
}

$zip_code = (isset($_REQUEST['zip_code'])) ? $_REQUEST['zip_code'] : false;
$ZIP_CODE = (isset($_REQUEST['ZIP_CODE'])) ? $_REQUEST['ZIP_CODE'] : false;

$phone_no = (isset($_REQUEST['phone_no'])) ? $_REQUEST['phone_no'] : false;
$PHONE_NO = (isset($_REQUEST['PHONE_NO'])) ? $_REQUEST['PHONE_NO'] : false;

$fax_no = (isset($_REQUEST['fax_no'])) ? $_REQUEST['fax_no'] : false;
$FAX_NO = (isset($_REQUEST['FAX_NO'])) ? $_REQUEST['FAX_NO'] : false;

$sort = (isset($_REQUEST['sort'])) ? $_REQUEST['sort'] : false;

$attachment = (isset($_REQUEST['attachment'])) ? $_REQUEST['attachment'] : false;
$attachment_name = (isset($_REQUEST['attachment']['name'])) ? $_REQUEST['attachment']['name'] : false;
$attachment_size = (isset($_REQUEST['attachment']['size'])) ? $_REQUEST['attachment']['size'] : false;
$attachment_type = (isset($_REQUEST['attachment']['type'])) ? $_REQUEST['attachment']['type'] : false;

$file = (isset($_REQUEST['file'])) ? $_REQUEST['file'] : false;
$file_name = (isset($_REQUEST['file']['name'])) ? $_REQUEST['file']['name'] : false;
$file_size = (isset($_REQUEST['file_size'])) ? $_REQUEST['file_size'] : false;
$path_to_file = (isset($_REQUEST['path_to_file'])) ? $_REQUEST['path_to_file'] : false;
$file2 = (isset($_REQUEST['file2'])) ? $_REQUEST['file2'] : false;
$file2_name = (isset($_REQUEST['file2']['name'])) ? $_REQUEST['file2']['name'] : false;
$file2_size = (isset($_REQUEST['file2_size'])) ? $_REQUEST['file2_size'] : false;
$env_report = (isset($_REQUEST['env_report'])) ? $_REQUEST['env_report'] : false;
$ar_file = (isset($_REQUEST['ar_file'])) ? $_REQUEST['ar_file'] : false;

$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : false;

if (isset($_REQUEST['subject'])) {
    $subject = $_REQUEST['subject'];
}
elseif ( isset($CONF['subject']['msg']) ) {
    $subject = $CONF['subject']['msg'];
}
else {
    $subject = '';
}

$title = (isset($_REQUEST['title'])) ? $_REQUEST['title'] : "";
$bgcolor = (isset($_REQUEST['bgcolor'])) ? $_REQUEST['bgcolor'] : "";
$text_color = (isset($_REQUEST['text_color'])) ? $_REQUEST['text_color'] : "";
$link_color = (isset($_REQUEST['link_color'])) ? $_REQUEST['link_color'] : "";
$vlink_color = (isset($_REQUEST['vlink_color'])) ? $_REQUEST['vlink_color'] : "";
$alink_color = (isset($_REQUEST['alink_color'])) ? $_REQUEST['alink_color'] : "";
$style_sheet = (isset($_REQUEST['style_sheet'])) ? $_REQUEST['style_sheet'] : "";
$background = (isset($_REQUEST['background'])) ? $_REQUEST['background'] : "";
$missing_field_redirect = (isset($_REQUEST['missing_field_redirect'])) ? $_REQUEST['missing_field_redirect'] : "";
$missing_fields_redirect = (isset($_REQUEST['missing_fields_redirect'])) ? $_REQUEST['missing_fields_redirect'] : "";

    
/** Set Array $aLang
 *  Contain user translated langauge
 */
$rvsDefaultLangFile =   'english-utf-8.php';
if(isset($CONF['language']['rvsLang'])){
    $rvsLangFile = $CONF['language']['rvsLang'] . '.php';
}

if(is_readable('language/' . $rvsLangFile)){
    include 'language/' . $rvsLangFile;
}
elseif(is_readable('language/' . $rvsDefaultLangFile)){
    include 'language/' . $rvsDefaultLangFile;
}
else {
    echo 'Could not find language file for RV SiteBuilder formmail.';
    exit;
}


/**
 * recipient : This INI configuration allows you to specify to whom you wish for your form results to be mailed.
 *
 * @example
 * [recipient]
 * 1=yourEmail@yourDomail
 */
if ( count($CONF['recipient']) > 0 ) {
    $recipient_in = tranferHash($CONF['recipient']);

    for ($i=0; $i<count($recipient_in); $i++) {
        $recipient_to_test = trim($recipient_in[$i]);

        if ( !preg_match("/[0-9a-z]+@+[0-9a-z]/i", $recipient_to_test) ) {
            print_error("<b>" . $aLang["I NEED VALID RECIPIENT EMAIL ADDRESS"] .  "($recipient_to_test) " . $aLang["TO CONTINUE</b>"]);
        }
    }
}
else {
    print_error("<b>" . $aLang["I NEED VALID RECIPIENT EMAIL ADDRESS"] . "</b>");
}

$recipient = tranferHash($CONF['recipient']);
// spambot
$rvblocker->setTimeWindow(2,14400);

$isnotSpamBot = $rvblocker->isnotSpamBot();
if ($isnotSpamBot  == false) {
    print_error("<b>" . $aLang["This was an INVALID submission. You have acted like a spambot!"] . "</b>");
}
// end spambot

/**
 * bcc :This configuration allows you to specify to whom you wish for your form results to be Blind Carbon Copied to.
 *
 * This variables is disable.
 */
$bcc = '';

/**
 * referers : This INI configuration allows you to define the domains that you will allow forms to reside on and use your FormMail.php script.
 * If a user tries to put a form on another server, that is not the specified domain or ip,
 * they will receive an error message when someone tries to fill out their form.
 *
 * @example
 * [referers]
 * 1=somedomain.com
 * 2=www.somedomain.com
 * 3=121.0.0.111
 */
if ( count($CONF['referers']) > 0 ) {
    $referers = tranferHash($CONF['referers']);
    check_referer($referers);
}

/**
 * banlist : This INI configuration allows you to define the domains and emails that you would like banned from using your Formmail.php.
 *
 * @example
 * [banlist]
 * 1=*@somedomain.com
 * 2=user@domain.com
 * 3=etc@domains.com
 */
if ( count($CONF['banlist']) > 0 ) {
    $banlist = tranferHash($CONF['banlist']);
    check_banlist($banlist, $email);
}

/**
 * required : Required is an alias for require,
 *
 * @see require
 * @example
 * <input type=hidden name="required" value="email,phone_no">
 */
if ( $required ) {
    $require = $required;
}

/**
 * require : You can now require for certain fields in your form to be filled
 * in before the user can successfully submit the form.
 * Simply place all field names that you want to be mandatory into this field.
 * If the required fields are not filled in, the user will be notified of what they need to fill in,
 * and a link back to the form they just submitted will be provided.
 *
 * @example
 * <input type=hidden name="require" value="email,phone_no">
 */
if ( isset($require) ) {
    $require = ereg_replace( " +", "", $require);
    $required = split(",",$require);
    $missing_field_list = '';
    for ($i=0;$i<count($required);$i++) {
        $string = trim($required[$i]);
        if ( !isset($string) || $string == '') continue;
        if ( (!($_REQUEST[$string]))  ) {
            /// show filed name with filedname_trans if missing
            $fieldName = $required[$i];
            $fieldMiss = (isset($_REQUEST[$fieldName . '_trans'])) ? $_REQUEST[$fieldName . '_trans'] : $fieldName;
            //$missing_field_list .= "<b>" . $aLang["Missing:"] . " $required[$i]</b><br>\n";
            $missing_field_list .= "<b>" . $aLang["Missing:"] . " $fieldMiss</b><br>\n";
        }
    }
    if ( isset($missing_field_list) && $missing_field_list <> '' ) {
        print_error($missing_field_list,"missing");
    }
}

/**
 * email : This form field will allow the user to specify their return e-mail address.
 * If you want to be able to return e-mail to your user,
 * I strongly suggest that you include this form field and allow them to fill it in.
 * This will be put into the From: field of the message you receive.
 * The email address submitted will be checked for validity.
 *
 * @example
 * <input type=text name="email">
 */

if ( $email || $EMAIL) {
     
    $email = trim($email);
     
    if ( isset($EMAIL) && $EMAIL <> '') {
        $email = trim($EMAIL);
    }
    if (!eregi("^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z-]+\.)+[a-z]{2,6}$", $email)) {
        print_error($aLang["your <b>email address"] . " ( $email )" . $aLang["</b> is invalid."]);
    }
    $EMAIL = $email;
}

/**
 * zip_code : This form field will allow the user to specify a zip code.
 * The zip code submitted will be checked for basic validity and
 * must match one of the following formats.
 *
 *		12345
 *		12345-1234
 *		A1B 2C3 (for candians :P)
 *
 * @example
 * <input type=text name="zip_code">
 */
if ( $ZIP_CODE || $zip_code) {
    $zip_code = trim($zip_code);
    if ( isset($ZIP_CODE) && $ZIP_CODE <> '') {
        $zip_code = trim($ZIP_CODE);
    }

    if (
    !ereg("(^[0-9]{5})-([0-9]{4}$)", trim($zip_code)) &&
    (!ereg("^[a-zA-Z][0-9][a-zA-Z][[:space:]][0-9][a-zA-Z][0-9]$", trim($zip_code)))
    && (!ereg("(^[0-9]{5})", trim($zip_code)))
    ) {
        print_error($aLang["your <b>zip/postal code</b> is invalid"]);
    }
}

/**
 * phone_no : This form field will allow the user to specify a phone number.
 * The phone number submitted will be checked for validity and
 * must match one of the following formats.
 *
 *    	123.123.1234
 * 	123-123-1234
 * 	(123)123.1234
 * 	(123)123-1234
 * 	etc..
 *
 * @example
 * <input type=text name="phone_no">
 */
if ( $PHONE_NO || $phone_no) {
    $phone_no = trim($phone_no);
    if ( isset($PHONE_NO) && $PHONE_NO <> '') $phone_no = trim($PHONE_NO);

    if (!ereg("(^(.*)[0-9]{3})(.*)([0-9]{3})(.*)([0-9]{4}$)", $phone_no)) {
        print_error($aLang["your <b>phone number</b> is invalid"]);
    }
}

/**
 * fax_no : This form field will allow the user to specify a fax number.
 * The fax number submitted will be checked for validity and
 * must match one of the following formats.
 *
 *		123.123.1234
 *		123-123-1234
 *		(123)123.1234
 *		(123)123-1234
 *		etc..
 *
 * @example
 * <input type=text name="fax_no">
 */
if ( $FAX_NO || $fax_no) {
    $fax_no = trim($fax_no);
    if ( isset($FAX_NO) && $FAX_NO <> '') $fax_no = trim($FAX_NO);
    if (!ereg("(^(.*)[0-9]{3})(.*)([0-9]{3})(.*)([0-9]{4}$)", $fax_no)) {
        print_error($aLang["your <b>fax number</b> is invalid"]);
    }
}

/**
 * sort : This field allows you to choose the order in which you wish
 * for your variables to appear in the email that Formmail.php generates.
 * You can choose to have the field sorted alphabetically or specify a set order
 * in which you want the fields to appear in your mail message.
 * By leaving this field out, the order will simply default to the order in which the browsers
 * sends the information to the script
 * (which is usually the exact same order as they appeared in the form.)
 * When sorting by a set order of fields,
 * you should include the phrase "order:" as the first part of your value for the sort field,
 * and then follow that with the field names you want to be listed in the email message,
 * separated by commas.
 *
 * @example To sort alphabetically:
 * <input type=hidden name="sort" value="alphabetic">
 * @example To sort by a set field order:
 * <input type=hidden name="sort" value="order:name1,name2,etc...">
 */
if ($sort == "alphabetic") {
    uksort($_POST, "strnatcasecmp");
}
else if (
ereg('^order:.*,.*', $sort) &&
$list = explode(',', ereg_replace('^order:', '', $sort)) ) {
    $sort = $list;
}
$countSpamMakeTag = 0;
 foreach ($_POST as $key => $val) {
 	if ($countSpamMakeTag >3) {
 	    $aPost[$key] =  $val;
 	}
 	$countSpamMakeTag++;
 }
 
$content = parse_form($aPost, $sort);

/**
 * attachment : Allows the user attach a file to the email sent by Formmail
 *
 * @example
 * <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
 * <input type="file" name="attachment">
 */
if ( isset($attachment_name) && $attachment_name <> '') {
    if ($attachment_size > 0) {
        if ( !isset($attachment_type)) $attachment_type =  "application/unknown";
        $content .= "Attached File: ". $attachment_name ."\n";
        $fp = fopen($attachment ,  "r");
        $attachment_chunk = fread($fp, filesize($attachment));
        $attachment_chunk = base64_encode($attachment_chunk);
        $attachment_chunk = chunk_split($attachment_chunk);
    }
}

/**
 * file : Allows the user to upload a file to a path of your specification.
 * NOTE :  If you are using the file option it is crucial to include
 * the ENCTYPE="multipart/form-data" in the form field.
 * <path_to_file> - This is the path which the file will be uploaded to.
 * Must be a direct path to your directory. ie: "/www/yourname/filedir/"
 * <MAX_FILE_SIZE> - (case sensitive) hidden field must precede the file
 * input field and it's value is the maximum filesize accepted. The value is in bytes.
 *
 * @example
 * <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
 * <input type="hidden" name="path_to_file" value="/www/dir_where_file_goes/">
 * <input type="file" name="file">
 */
if ( isset($file_name) && $file_name <> '') {
    if ( $file_size > 0) {
        if (!ereg("/$", $path_to_file)) {
            $path_to_file = $path_to_file ."/";
        }
        $location = $path_to_file . $file_name;
        if (file_exists($path_to_file . $file_name)) {
            $location = $path_to_file . rand(1000,3000).".". $file_name;
        }
        copy($file,$location);
        unlink($file);
        $content .= "Uploaded File: ".$location."\n";
    }
}

/**
 * file2 : I received a lot of email asking how to handle additional file uploads,
 * I added "file2" to show how easy it is: Keep the same syntax as above,
 * but append a "2" to the end of the file.
 * Advanced: to add addtional files copy the php functions (below) that handle
 * the file upload for file2 and and change the "2"s to a "3" or anything else.
 */
if ( isset($file2_name) && $file2_name <> '') {
    if ($file_size > 0) {
        if (!ereg("/$", $path_to_file)) {
            $path_to_file = $path_to_file . "/";
        }
        $location = $path_to_file.$file2_name;
        if (file_exists($path_to_file.$file2_name)) {
            $location = $path_to_file . rand(1000,3000) . "." . $file2_name;
        }
        copy($file2, $location);
        unlink($file2);
        $content .= "Uploaded File: " . $location."\n";
    }
}

/**
 * env_report : Allows you to have Environment variables included in the e-mail message
 * you receive after a user has filled out your form.
 * Useful if you wish to know what browser they were using,
 * what domain they were coming from or any other attributes associated
 * with environment variables.
 * The following is a short list of valid environment variables that might be useful:
 * <REMOTE_HOST> - Sends the hostname making the request.
 * <REMOTE_ADDR> - Sends the IP address of the remote host making the request.
 * <HTTP_USER_AGENT> - The browser the client is using to send the request.
 *
 * @example If you wanted to find the remote host and browser sending the request,
 * you would put the following into your form:
 * <input type=hidden name="env_report" value="REMOTE_HOST, HTTP_USER_AGENT">
 *  Seperate by commas ",".
 */
if ( isset($env_report) and $env_report <>'') {
    $env_report = ereg_replace( " +", "", $env_report);
    $env_reports = split(",",$env_report);
    $content .= "\n------ eviromental variables ------\n";
    for ($i=0;$i<count($env_reports);$i++) {
        $string = trim($env_reports[$i]);
        if ($env_reports[$i] == "REMOTE_HOST") {
            $content .= "REMOTE HOST: ".$REMOTE_HOST."\n";
        }
        if ($env_reports[$i] == "REMOTE_USER") {
            $content .= "REMOTE USER: ". $REMOTE_USER."\n";
        }
        if ($env_reports[$i] == "REMOTE_ADDR") {
            $content .= "REMOTE ADDR: ". $REMOTE_ADDR."\n";
        }
        if ($env_reports[$i] == "HTTP_USER_AGENT") {
            $content .= "BROWSER: ". $HTTP_USER_AGENT."\n";
        }
    }
}


mail_it(stripslashes($content), ($subject)?stripslashes($subject):"Form Submission", $email, $recipient);

/**
 * ar_file : This optional field should be the path
 * to your a text file which contains your autoresponse text.
 *
 * @example
 * <input type="hidden" name="ar_file" value="/www/dir_where_file_goes/autoresponder.txt">
 */

if (file_exists($ar_file) && $ar_file <> '') {
    $fd = fopen($ar_file, "rb");
    $ar_message = fread($fd, filesize($ar_file));
    fclose($fd);
    mail_it($ar_message, ($ar_subject)?stripslashes($ar_subject):"RE: Form Submission", ($ar_from)?$ar_from:$recipient, $email);
}

/**
 * redirect : If you wish to redirect the user to a different URL,
 * rather than having them see the default response to the fill-out form,
 * you can use this hidden variable to send them to a pre-made HTML page
 * or as another form type to let the user decide.
 *
 * @example
 * <input type=hidden name="redirect" value="http://your.host.com/to/ file.html">
 */

if ($redirect) {
    if ( sitebuilderPreview() == true) {
        javaRedirect($redirect);
    }
    else {
        header("Location: ".$redirect);
        exit;
    }
}
else {
    if (isset($aLang["Thank you for submitting your enquiry"])) {
        echo $aLang["Thank you for submitting your enquiry"] . "'\n";        
    } else {
        echo $aLang["Thank you for your submission"] . "'\n";        
    }
    echo "<br><br>\n";
    echo "<small>" . $aLang["This form is powered by "] . "<a href=\"http://www.dtheatre.com/scripts/\">Jack's Formmail.php ".VERSION."!</a></small>\n\n";
    exit;
}


// our mighty error function..
function print_error($reason,$type = 0)
{
    global $title, $bgcolor, $text_color, $link_color, $vlink_color, $alink_color, $style_sheet, $missing_field_redirect , $aLang;

    // for missing required data
    if ($missing_field_redirect) {
        if ( sitebuilderPreview() == true) {
            javaRedirect($missing_field_redirect . "?error=" . urlencode($reason));
            exit;
        }
        else {
            header("Location: " . $missing_field_redirect . "?error=" . urlencode($reason));
            exit;
        }
    }
    else {

        build_body($title, $bgcolor, $text_color, $link_color, $vlink_color, $alink_color, $style_sheet);
        echo $aLang["The form was not submitted for the following reasons:"] . "\n";
        echo "<p><ul>\n";
        echo $reason ."\n";
        echo "</ul>\n";
        echo $aLang["Please use your browser back button to return to the form and try again."] . "\n";
        echo "<br><br>\n";
        echo "<small>" . $aLang["This form is powered by"] .  " <a href=\"http://www.dtheatre.com/scripts/\">Jack's Formmail.php ". VERSION ."</a></small>\n\n";
        exit;
    }
}

function sitebuilderPreview()
{
    if ( preg_match('/RvSitebuilderPreview/i', $_SERVER['REQUEST_URI'], $maich) ) {
        return true;
    }
    else {
        return false;
    }
}

function javaRedirect($page)
{
    print "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
    print "<!--\n";
    print "location = '$page'; \n";
    print "//-->\n";
    print "</script>\n";
}
// function to check the banlist
// suggested by a whole lot of people.. Thanks
function check_banlist($banlist = array(), $email)
{
    global $aLang;
    $allow = true;
    if (count($banlist) && $email) {
        foreach($banlist as $banned) {
            $temp = explode("@", $banned);
            if ($temp[0] == "*") {
                $temp2 = explode("@", $email);
                if ( trim(strtolower($temp2[1])) == trim(strtolower($temp[1])) ) {
                    $allow = false;
                }
            }
            else {
                if ( trim(strtolower($email)) == trim(strtolower($banned)) ) {
                    $allow = false;
                }
            }
        }
    }
    if (!$allow) {
        print_error($aLang["You are using from a <b>banned email address.</b>"]);
    }
}

// function to check the referer for security reasons.
// contributed by some one who's name got lost.. Thanks
// goes out to him any way.
function check_referer($referers)
{
    global $aLang;
     
    if (count($referers)) {
        $found = false;

        $temp = explode("/",getenv("HTTP_REFERER"));
        $referer = $temp[2];

        if ($referer=="") {
            $referer = $_SERVER['HTTP_REFERER'];
            list($remove,$stuff)=split('//',$referer,2);
            list($home,$stuff)=split('/',$stuff,2);
            $referer = $home;
        }

        for ($x=0; $x < count($referers); $x++) {
            if (eregi ($referers[$x], $referer)) {
                $found = true;
            }
        }
        if ($referer =="") $found = false;
        if (!$found) {
            print_error($aLang["You are coming from an <b>unauthorized domain.</b>"]);
            error_log("[rvform.php] Illegal Referer. (".getenv("HTTP_REFERER").")", 0);
        }
        return $found;
    }
    else{
        return true;
    }
}

// This function takes the sorts, excludes certain keys and
// makes a pretty content string.
function parse_form($array, $sort = "")
{
    // build reserved keyword array
    $reserved_keys[] = "MAX_FILE_SIZE";
    $reserved_keys[] = "required";
    $reserved_keys[] = "redirect";
    $reserved_keys[] = "require";
    $reserved_keys[] = "path_to_file";
    $reserved_keys[] = "recipient";
    $reserved_keys[] = "subject";
    $reserved_keys[] = "sort";
    $reserved_keys[] = "style_sheet";
    $reserved_keys[] = "bgcolor";
    $reserved_keys[] = "text_color";
    $reserved_keys[] = "link_color";
    $reserved_keys[] = "vlink_color";
    $reserved_keys[] = "alink_color";
    $reserved_keys[] = "title";
    $reserved_keys[] = "missing_fields_redirect";
    $reserved_keys[] = "missing_field_redirect";
    $reserved_keys[] = "env_report";
    $reserved_keys[] = "submit";
    $reserved_keys[] = "rvformid";
    $reserved_keys[] = "charset";
    $reserved_keys[] = "validated";

    $content ='';
    if (count($array)) {
        if (is_array($sort)) {
            foreach ($sort as $field) {
                $reserved_violation = 0;
                for ($ri=0; $ri<count($reserved_keys); $ri++)
                if ($array[$field] == $reserved_keys[$ri]) $reserved_violation = 1;

                if ($reserved_violation != 1) {
                    if (is_array($array[$field])) {
                        for ($z=0;$z<count($array[$field]);$z++)
                        $content .= $field.SEPARATOR.$array[$field][$z].NEWLINE;
                    } else
                    $content .= $field.SEPARATOR.$array[$field].NEWLINE;
                }
            }
        }

        while (list($key, $val) = each($array)) {
            $reserved_violation = 0;
            for ($ri=0; $ri<count($reserved_keys); $ri++)
            if ($key == $reserved_keys[$ri]) $reserved_violation = 1;

            for ($ri=0; $ri<count($sort); $ri++)
            if (is_array($sort)) {
                if ($key == $sort[$ri]) $reserved_violation = 1;
            }

            // prepare content
            if ($reserved_violation != 1) {
                if (is_array($val)) {
                    for ($z=0;$z<count($val);$z++)
                    $content .= $key.SEPARATOR.$val[$z].NEWLINE;
                } else {
                    if (!preg_match('/_trans$/', $key)) {
                        $key = (isset($array[$key . '_trans'])) ? $array[$key . '_trans'] : $key;
                        $content .= $key.SEPARATOR.$val.NEWLINE;
                    }
                }
            }
        }
    }
    return $content;
}

function tranferHash($Hash)
{
    $aValue = array();
    foreach ($Hash as $hashKey => $hashValue) {
        array_push($aValue,$hashValue);
    }
    return $aValue;
}

// mail the content we figure out in the following steps
function mail_it($content, $subject, $email, $recipient)
{
    global $attachment_chunk, $attachment_name, $attachment_type, $attachment_sent, $bcc, $aLang;

    $ob = "----=_OuterBoundary_000";
    $ib = "----=_InnerBoundery_001";

    $charset = $_REQUEST['charset'] ? $_REQUEST['charset'] : 'iso-8859-1';
     
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "From: " . formMailFilter($email) . "\n";
    
    $suhosin = ini_get('suhosin.mail.protect');
    /*
     * suhosin.mail.protect
     * This directive controls if the mail() header protection is activated or not and to what degree it is activated. 
     * The appended table lists the possible activation levels.
     * 
     *  0    mail() header protection is disabled
     *  1    Disallows newlines in Subject:, To: headers and double newlines in additional headers
     *  2    Additionally disallows To:, CC:, BCC: in additional headers
     */
    switch ($suhosin){
        case 1:
            break;
        case 2:
            break;
        default:
            // remove send to double
            //$headers .= "To: " . formMailFilter($recipient[0]) . "\n";
    }
    $headers .= "Reply-To: ". formMailFilter($email) . "\n";
    if ($bcc) {
        //$headers .= "Bcc: " .    $email = formMailFilter($bcc) . "\n";
    }
    
    $headers .= "X-Mailer: DT Formmail". VERSION ."\n";
    $headers .= "Content-Type: multipart/mixed;\n\tboundary=\"".$ob."\"\n";
     

    $message  = "This is a multi-part message in MIME format.\n";
    $message .= "\n--".$ob."\n";
    $message .= "Content-Type: multipart/alternative;\n\tboundary=\"".$ib."\"\n\n";
    $message .= "\n--".$ib."\n";
    $message .= "Content-Type: text/plain;\n\tcharset=\"" . formMailFilter($charset) . "\"\n";
    $message .= "Content-Transfer-Encoding: quoted-printable\n\n";
    $message .= $content . "\n\n";
    $message .= "\n--".$ib."--\n";
    if ($attachment_name && !$attachment_sent) {
        $message .= "\n--".$ob."\n";
        $message .= "Content-Type: " . formMailFilter($attachment_type) . ";\n\tname=\"" . formMailFilter($attachment_name) . "\"\n";
        $message .= "Content-Transfer-Encoding: base64\n";
        $message .= "Content-Disposition: attachment;\n\tfilename=\"" . formMailFilter($attachment_name) . "\"\n\n";
        $message .= $attachment_chunk;
        $message .= "\n\n";
        $attachment_sent = 1;
    }
    $message .= "\n--".$ob."--\n";
    
    $isSendMail = (isSendMail() === false) ? false : true; 
    if($isSendMail && !mail($recipient[0], $subject, $message, $headers)) {
    	print_error("<b>" . $aLang["Cannot connect to sendmail server"] .  ' ' . $aLang["Sending email from"] . ' ' . $email . ' ' . $aLang["to"] . ' ' . $recipient[0] . ' ' .  $aLang["failed"] . ".</b>");
    }
    
    if ($isSendMail === false) {
    	print_error($aLang['Sorry, your admin disable send mail.']);
    }
}

function loadPublishList()
{
	$path = dirname(dirname(dirname(__FILE__))) . '/.rvsPublish.ini.php';
	$aRVSPublist = (is_file($path)) ? parse_ini_file($path, true) : array();
	return $aRVSPublist;
}

function isSendMail()
{            
	$aRVSPublist = loadPublishList();
	$projectId = (isset($aRVSPublist['project_id'])) ? $aRVSPublist['project_id'] : '';
    $path = dirname(dirname(dirname(dirname(__FILE__)))) .'/.rvsitebuilder/projects/'. $projectId . '/scripts/Tryout/setting.ini.php';
    $aConf =  (is_file($path)) ? parse_ini_file($path, true) : array();
    return (isset($aConf['allowSendMail']) && $aConf['allowSendMail'] != 1) ? false : true;
}

// take in the body building arguments and build the body tag for page display
function build_body($title='', $bgcolor='', $text_color='', $link_color='', $vlink_color='', $alink_color='', $style_sheet='')
{
    global $background;
    if ($style_sheet)
    echo "<LINK rel=STYLESHEET href=\"$style_sheet\" Type=\"text/css\">\n";
    if ($title)
    echo "<title>$title</title>\n";
    if (!$bgcolor)
    $bgcolor = "#FFFFFF";
    if (!$text_color)
    $text_color = "#000000";
    if (!$link_color)
    $link_color = "#0000FF";
    if (!$vlink_color)
    $vlink_color = "#FF0000";
    if (!$alink_color)
    $alink_color = "#000088";
    if ($background) {
        $background = "background=\"" . $background . "\"";
    }
    echo "<body bgcolor=\"$bgcolor\" text=\"$text_color\" link=\"$link_color\" vlink=\"$vlink_color\" alink=\"$alink_color\" ". $background . ">\n\n";
}


/**
 * Filter input going to insert in email header
 *
 * Function to filter the variables to add in the email header.
 * Provide to protect unexpected arbitrary code.
 *
 * @author Pairote Manunphol <pairote@rvsitebuilder.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @param string $item
 * @return $item if all test passed, redirect to error page if the spam sign detected
 **/
function formMailFilter($item)
{
    global $aLang;
    $bad = 0;

    // remove the ending \n
    $item=ereg_replace("[\r\n]","",$item);

    // Check if there is the bcc: included in the string
    $bad = eregi('bcc:', $item)?1:0 ;
    $bad = eregi('cc:', $item)?1:0 ;

    // Check if there is Content-Type included in the string
    $bad = eregi('Content-Type', $item)?1:0 ;

    if ($bad) {
        print_error("<b>" . $aLang["Spam mail detected."] .  $aLang["Your message never be sent."] .  $aLang["If you accidentally get this error, please contact us for the resolution."] ."</b>");
    }
    return $item;
}
?>