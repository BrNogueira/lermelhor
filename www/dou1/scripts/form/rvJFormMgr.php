<?php

/*
$oForm = new RvJForm();

$aRVSPublist = $oForm->loadPublishList();
*/
/*
if ( is_file( dirname(dirname(dirname(__FILE__))) . "/rvsStaticWeb.php") && isset($aRVSPublist['ComponentAndUserFramework'])) {
    include( dirname(dirname(dirname(__FILE__))) . "/rvsStaticWeb.php");
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
*/

define("VERSION", "5.0");
define("SEPARATOR", ": ");
define( "NEWLINE" , "\n");

class rvJFormMgr {
    var $aPropConf = array();
    var $form_id = '';
    var $aRVSPublist = array();
    var $questions = array();
    var $aAttachment = array();
    var $aMailAttachmentId = array();
    var $aSenderEmail = array(); 
    var $aRaiseError = array(); 
    function init($form_id)
    {
        $this->aRVSPublist = $this->loadPublishList();
        
        $this->form_id = $form_id;
        $this->aPropConf = $this->_loadGlobals();
        
        if ($this->reCaptcha($this->getIndexPropertiesByTypeName('control_captcha')) === true) {
        	
	         if (isset($this->aPropConf['formID']) === false) {
	            //$this->print_error("<b>Sorry, cannot load globals variable.</b><br />\n");
	            return false;
	        } else if ($this->check_referer() === false) {
	            return false;
	        } else {
	            $_req = $this->setRequest();
	            $aError = $this->validate();
	            if (count($aError) > 0) {
	                $errortext = '';
	                foreach ($aError as $v) {
	                    $errortext .= "<li>{$v}</li>\n";
	                }
	                $this->print_error("<b>There are missing fields on your form please correct them.</b><br />\n" . $v);
	                return false;
	            } else {
	                $this->mail_it();
	                return true;
	            }
	        }
	        
        } //END reCapcha
       
        
    }

    function print_error($reason, $type = 0)
    {
        array_push($this->aRaiseError, $reason);
        //print $reason;
    }
    
    function check_referer()
    {
        if (count($this->aPropConf['referers']) > 0) {
            $found = false;
            $temp = explode("/",getenv("HTTP_REFERER"));
            $referer = $temp[2];
            if ($referer=="") {
                $referer = $_SERVER['HTTP_REFERER'];
                /*FIX PHP 5.3 :: niapaporn*/
                list($remove, $stuff) = preg_split('/\/\//',$referer,2);
                list($home,$stuff)=preg_split('/\//',$stuff,2);
                $referer = $home;
            }
            
            foreach ($this->aPropConf['referers'] as $k) {
            	/*FIX PHP 5.3 :: nipaporn*/
                if (preg_match('/' . $k . '/i', $referer)) {
                    $found = true;
                }
            }
            if ($referer =="") $found = false;
            if (!$found) {
                $this->print_error("You are coming from an <b>unauthorized domain.</b>");
            }
            return $found;
        } else {
            return true;
        }
    }
    
    /**
     * Recaptcha
     * 
     * @param Integer $indexCaptcha
     * @return Boolean 
     */
    function reCaptcha($indexCaptcha)
    {
    	if (isset($indexCaptcha) === false) { 
    	    return true;
    	}
    	
    	require_once(dirname(dirname(dirname(__FILE__))) . '/jotform/lib/recaptcha/recaptchalib.php');
    	define('API_PUBLIC', '6Ld9UAgAAAAAAMon8zjt30tEZiGQZ4IIuWXLt1ky');
        define('API_PRIVATE', '6Ld9UAgAAAAAAMpq26ktw51roN5pmRw6wCrO3lKh ');
        $privatekey = API_PRIVATE;
        $challenge = null;
        $response = null;
        
        if (isset($_POST["anum"]) === true) {
        	$challenge = $_POST["anum"];
        } else if (isset($_POST["recaptcha_challenge_field"]) === true) {
        	$challenge = $_POST["recaptcha_challenge_field"];
        }
        
        if (isset($_POST["qCap"]) === true) {
        	$response = $_POST["qCap"];
        } else if (isset($_POST["recaptcha_response_field"]) === true) {
        	$response = $_POST["recaptcha_response_field"];
        }
        
        $res = recaptcha_check_answer(API_PRIVATE, $_SERVER["REMOTE_ADDR"], $challenge, $response);
        if (!$res->is_valid) {
        	$print = <<<EOF
        	<span style=\"font-family:'Trebuchet MS'; font-size:18px; color:#333\">
        	   Security code (Captcha) wasn't entered correctly.
        	</span>
EOF;
            $this->print_error($print);
            return false;
        }
        
    	return true;
    }
    
    function _loadGlobals()
    {
        
        $pathFileData = dirname(dirname(dirname(__FILE__))) . '/rvsformdata_' . $this->form_id . '.txt';
        if( is_file($pathFileData)) {
            $input = join('',file($pathFileData));
            return unserialize(base64_decode(strtr($input, '-_,', '+/=')));
        } else {
            //$this->print_error('Connot load form data.');
        }
    }
    
    function setRequest()
    {
        foreach ($this->aPropConf['order'] as $k) {
            $name = '';
            if (isset($this->aPropConf['properties'][$k]['name']) === true) {
                $name = $this->aPropConf['properties'][$k]['name'];
            } else {
            	/*FIX PHP 5.3 :: niapaporn*/
                list($_ctrl, $type) = preg_split('/_/', $this->aPropConf['properties'][$k]['type'], 2);
                $name = $type . $k;
            }

            $this->questions[$k] = $this->_getRequest($k, $name);
            
            if ( isset($this->aPropConf['properties'][$k]['required']) === true
                 && isset($this->aPropConf['properties'][$k]['validation']) === true
                 && $this->aPropConf['properties'][$k]['required'] == 'yes' 
                 && strtolower($this->aPropConf['properties'][$k]['validation']) == 'email'
            ) {
                array_push($this->aSenderEmail, $k);
            }
        }
        return true;
    }

    function _getRequest($questionsId, $name)
    {
    	//Fix add space on $name
    	$name = str_replace(' ', '_', trim($name));
        if ($this->aPropConf['properties'][$questionsId]['type'] == 'control_fileupload') {
            return $this->_getRequestFileUpload($name, $questionsId);
        } else {
            if ($this->aPropConf['properties'][999]['sendpostdata'] == 'yes') {
                if (isset($_POST[$name])) {
                    return (gettype($_POST[$name]) == 'array') ? join('|', $_POST[$name]) : $_POST[$name];
                } else {
                    return null;
                }
            } else {
                if (isset($_GET[$name])) {
                    return (gettype($_GET[$name]) == 'array') ? join('|', $_GET[$name]) : $_GET[$name];
                } else {
                    return null;
                }
            }
        }
    }
    
    function _getRequestFileUpload($name, $questionsID)
    {
        if (isset($_FILES[$name])) {
            array_push($this->aAttachment, $questionsID);
            return $_FILES[$name];
        } else {
            return array();
        }
    }

    function validate()
    {
        $aError = array();
        foreach ($this->aPropConf['order'] as $k) {
            if ( isset($this->aPropConf['properties'][$k]['required']) === true 
                && $this->aPropConf['properties'][$k]['required'] == 'yes' 
                && ($this->questions[$k] == null || $this->questions[$k] == '')
            ) {
                array_push($aError, 'Missing: ' .$this->aPropConf['properties'][$k]['text']);
            } else if (isset($this->aPropConf['properties'][$k]['validation']) === true
                && $this->aPropConf['properties'][$k]['validation'] != 'no'
                && $this->questions[$k] != ''
            ) {
                $_callFunc = '_validate_' . strtolower($this->aPropConf['properties'][$k]['validation']);
                if (method_exists($this, $_callFunc) === true) {
                    $isError = $this->{$_callFunc}($this->questions[$k]);
                    if ($isError != false) {
                        array_push($aError,$this->aPropConf['properties'][$k]['text'] . ', ' . $isError);
                    }
                }
            } else if ($this->aPropConf['properties'][$k]['type'] == 'control_fileupload' && ($this->questions[$k] != null || $this->questions[$k] != array()) && (isset($this->questions[$k]['tmp_name']) && $this->questions[$k]['tmp_name'] != '') ) {
                $maxsize = isset($this->aPropConf['properties'][$k]['maxsize']) ? $this->aPropConf['properties'][$k]['maxsize'] : 1000;
                $filesize = isset($this->questions[$k]['size']) ? $this->questions[$k]['size'] : filesize($this->questions[$k]['tmp_name']);
                $filename = $this->questions[$k]['name'];
                
                 $this->aPropConf['properties'][$k]['extensions'];
                 
                $extensions = isset($this->aPropConf['properties'][$k]['extensions']) 
                              ? $this->aPropConf['properties'][$k]['extensions'] 
                              : 'doc, docx, xls, xlsx, pdf, ppt, pptx, txt, html, htm, rtf, pps, ppsx, zip, tar, gzip, bzip, sit, dmg, jpg, jpeg, gif, png, asf, asx, flv, h264, mov, mp3, mp4, swf, wax, wma, wmv, wvx, wpl, xspf';
                /*FIX PHP 5.3 :: niapaporn*/
                $ext = array_pop(preg_split("/\\./", $filename));
                if ($filesize > $maxsize*1024) {
                    $errorMsg = "File ({$filename}) Too Large: " . $filesize/1024 ." KB. Limit Max Size: {$maxsize}";
                    array_push($aError, $this->aPropConf['properties'][$k]['text'] . $errorMsg);
                    //array_push($aError,$this->aPropConf['properties'][$k]['text']);
                } else if (strpos(strtolower($extensions), strtolower($ext))===false) {
                    $errorMsg = "File ({$filename}) Extension Not Accepted: " . $ext .", accepted Extension: {$extensions}";
                    array_push($aError, $this->aPropConf['properties'][$k]['text'] . $errorMsg);
                    //array_push($aError,$this->aPropConf['properties'][$k]['text']);
                }
            }
        }
        if (isset($this->aPropConf['properties']['999']['spamcheck']) === true 
            && $this->aPropConf['properties']['999']['spamcheck'] == "Enabled"
        ) {
            $md5FormID = md5($this->form_id);
            $oSpamcheck = $this->_loadFsbb();
            $oSpamcheck->setTrap(true, "spambot_$md5FormID");
            $oSpamcheck->setTimeWindow(2,14400);
            $oSpamcheck->keyName = 'fsbb_key' . $this->form_id;
            $oSpamcheck->sesName = 'fsbb_ses' . $this->form_id;
            $isnotSpamBot = $oSpamcheck->isnotSpamBot();
            if ($isnotSpamBot  == false) {
                array_push($aError, "<b>This was an INVALID submission. You have acted like a spambot!</b>");
            }
        }
        
        return $aError;
    }

    function _loadFsbb()
    {
        if ( is_file( dirname(dirname(dirname(__FILE__))) . "/rvsStaticWeb.php") && isset($this->aRVSPublist['ComponentAndUserFramework'])) {
            include_once ( dirname(dirname(dirname(__FILE__))) . "/rvsStaticWeb.php");
    // include fsbb and use SGL_Fsbb
            if (class_exists('SGL_Fsbb')) {
                $rvblocker = &SGL_Fsbb::singleton();
            } else {
                include_once(dirname(dirname(dirname(__FILE__))) . '/scripts/fsbb/fsbb.php');
                $rvblocker=new formSpamBotBlocker();
            }
        } else {
            include_once(dirname(dirname(dirname(__FILE__))) . '/scripts/fsbb/fsbb.php');
            $rvblocker=new formSpamBotBlocker();
        }
        return $rvblocker;
    }
    function _validate_email($email)
    {
    	/*FIX PHP 5.3 :: niaporn*/
    	if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z-]+\.)+[a-z]{2,6}$/i", $email)) {
    		return "enter a valid email address.";
    	} else {
    		return false;
    	}
    }
    
    function _validate_alphabetic($alphabetic)
    {
    	/*FIX PHP 5.3 :: nipaporn*/
    	if (!preg_match("/[^0-9\.\,\s\-\_]/i", $alphabetic)) {
    		return "cannot contain non-alphabetic characters.";
    	} else {
    		return false;
    	}
    }
    
    function _validate_numeric($numeric)
    {
    	/*FIX PHP 5.3 :: nipaporn*/
    	if (!preg_match("/[^a-zA-Z\s\-\_\']/i", $numeric)) {
    		return "cannot contain non-numeric characters. ({$numeric})";
    	} else {
    		return false;
    	}
    }

    function loadPublishList()
    {
        $path = dirname(dirname(dirname(__FILE__))) . '/.rvsPublish.ini.php';
        $aRVSPublist = (is_file($path)) ? parse_ini_file($path, true) : array();
        return $aRVSPublist;
    }
    
    function randId($numbit=0)
    {
        $result ='';
        for ($i=0; $i<$numbit;$i++) {
            $result .= rand(0,9);
        }   
        return $result;
    }
    
	function mail_it()
    {
    	//test customer
        //$recipient =  'darawan@rvglobalsoft.com';
        $recipient = $this->aPropConf['properties'][999]['email_addr'];
        $subject = $this->aPropConf['properties'][999]['conf_subj'];
        $subject = str_replace("{qForm Title}", $this->aPropConf['title'], $subject);

        $charset = (isset($this->aPropConf['charset']) === true) ? $this->aPropConf['charset'] : 'utf-8';
     
        $headers  = "MIME-Version: 1.0" . NEWLINE;
        
        if (count($this->aSenderEmail) > 0 ) {
            $_countMail = 0;
            foreach ($this->aSenderEmail as $v) {
                $email = $this->questions[$v];

                if ($_countMail == 0) {
                    $headers .= "From: " . $this->formMailFilter($email) . NEWLINE;
                    $headers .= "Reply-To: ". $this->formMailFilter($email) . NEWLINE;
                } else {
                	  $headers .= "From: " . $this->formMailFilter($email) . NEWLINE;
                    $headers .= "Reply-To: ". $this->formMailFilter($email) . NEWLINE;
                }
                $_countMail++;
            }
        } else {
        	$email = $recipient;
        	$headers .= "From: " . $this->formMailFilter($email) . NEWLINE;
        }
        
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
        switch ($suhosin) {
            case 1:
                break;
            case 2:
                break;
            default:
                // remove send to double
                //$headers .= "To: " . formMailFilter($recipient[0]) . "\n";
        }
        
        $bcc = (isset($this->aPropConf['properties'][999]['mail_cc']) === true && $this->aPropConf['properties'][999]['mail_cc'] != '') 
                ? $this->aPropConf['properties'][999]['mail_cc']
                : null;
        if (is_null($bcc) === false) {
            //$headers .= "Bcc: " .    $email = formMailFilter($bcc) . "\n";
        }
        
        
        
        $mailCharset = $this->formMailFilter($charset);
        
        $boundary1 = "===============" . $this->randId(19) . "==";
        
        $attachment_sent = 1; 
        $attachment_name ='';
        $attachmentMessage = '';
        if (count($this->aAttachment) > 0) {
            foreach ($this->aAttachment as $v) {
                if($this->questions[$v]['error'] == 0){
                $attachment_type = (isset($this->questions[$v]['type']) === true) ? $this->questions[$v]['type'] : 'application/unknown';
                $attachment_name = (isset($this->questions[$v]['name']) === true) ? $this->questions[$v]['name'] : '';

                $fp = fopen($this->questions[$v]['tmp_name'] ,  "r");
                $attachment_chunk = fread($fp, filesize($this->questions[$v]['tmp_name']));
                $attachment_chunk = base64_encode($attachment_chunk);
                $attachment_chunk = chunk_split($attachment_chunk);
                
                $attachmentMessage .= NEWLINE . "--{$boundary1}" . NEWLINE;
                $attachmentMessage .= "Content-Type: " . $this->formMailFilter($attachment_type) . ";" . NEWLINE . "\tname=\"" . $this->formMailFilter($attachment_name) . "\"" . NEWLINE;
                $attachmentMessage .= "Content-Transfer-Encoding: base64" . NEWLINE;
                /*FIX PHP 5.3 :: niapaporn*/
                list($acc, $domain) = preg_split('/@/', $email, 2);
                $domain = $this->formMailFilter($domain);
                
                $this->aMailAttachmentId[$v] = "part$v." . $this->randId(8) . "." . $this->randId(8) . "@$domain";
                //$attachmentMessage .= "Content-ID: <" . $this->aMailAttachmentId[$v] . ">\n";
                
                $attachmentMessage .= "Content-Disposition: attachment;" . NEWLINE . "\tfilename=\"" . $this->formMailFilter($attachment_name) . "\"" . NEWLINE . NEWLINE;
                $attachmentMessage .= $attachment_chunk;
                $attachmentMessage .= NEWLINE . NEWLINE;
                }
            }
        }

        $signature = <<<EOF
--=20
This message is automatically generated by {$this->aPropConf['url']}.
EOF;

        $signatureHtml = <<<EOF
<pre class="moz-signature" cols="72">--
This message is automatically generated by <a class="moz-txt-link-freetext" href="{$this->aPropConf['url']}">{$this->aPropConf['url']}</a>.
</pre>
EOF;

        $contentHtml = $this->formatHtmlMail($signatureHtml);
        $contentPlain = $this->formatTextMail($signature);
        
        $headers .= "X-Mailer: DT Formmail". VERSION . NEWLINE;
        $headers .= "Content-Type: multipart/mixed;" . "\tboundary=\"{$boundary1}\"" . NEWLINE;

        $message  = "This is a multi-part message in MIME format." . NEWLINE;
        $message .= "--{$boundary1}" . NEWLINE;
        $message .= "Content-Type: multipart/alternative;" . NEWLINE;
        $message .= "This is a multi-part message in MIME format." . NEWLINE;
        
        $message .= "--{$boundary1}" . NEWLINE; 
        $message .= "Content-Type: text/plain;" . NEWLINE . "\tcharset=\"{$mailCharset}\" format=flowed" . NEWLINE;
        $message .= "Content-Transfer-Encoding: quoted-printable" . NEWLINE . NEWLINE;
        $message .= "{$contentPlain}" . NEWLINE . NEWLINE;
        
       // $message .= NEWLINE . "--{$boundary1}" . NEWLINE;
       // $message .= "Content-Type: multipart/related;" . NEWLINE;
        
        $message .= NEWLINE . "--{$boundary1}" . NEWLINE;
        $message .= "Content-Type: text/html; charset=\"{$mailCharset}\"" . NEWLINE;
        $message .= "Content-Transfer-Encoding: 8bit" . NEWLINE . NEWLINE;
        $message .=  "{$contentHtml}" . NEWLINE . NEWLINE;

        if ($attachmentMessage != '') {
        	$message .= $attachmentMessage;
        }
        
        $message .= NEWLINE . "--{$boundary1}--" . NEWLINE;
        
        $isSendMail = ($this->isAllowSendMail() === false) ? false : true;
        $indexPayment = $this->getIndexPropertiesByTypeName('control_paypal');
        
        //echo 'Recipient ' . $recipient . '<hr>';
        //echo 'Subject ' . $subject . '<hr>';
        //echo 'MSG ' . $message .  '<hr>';
        //echo 'Headers ' . $headers . '<hr>';exit;
        
        if ($isSendMail === false) {
            /// Admin has disable
            $this->print_error('Sorry, your admin disable send mail.');
        } else if (isset($this->aPropConf['properties'][$indexPayment]['type'])  && $this->aPropConf['properties'][$indexPayment]['type'] == 'control_paypal') {
        	
        	$pathProject = dirname(dirname(dirname(__FILE__)));
        	$this->currentKeyDataPostMail = trim(md5(microtime()));
        	
        	$filename = $pathProject . "/postdata_" . $this->form_id . ".php";
        	$contentMail = $this->buildContentMail(addslashes($recipient), addslashes($subject), addslashes($message), addslashes($headers));
        	$this->writeContentMail($contentMail, $filename, $this->currentKeyDataPostMail);
        	
        	$filename = $pathProject . "/rvthankform_" . $this->form_id . ".php";
        	$phpScriptAppend = $this->phpScriptAppendSendMail();
        	$this->writeScriptAppendSendMail($filename, $phpScriptAppend);
        	
        	$this->buildPayment($indexPayment);
        	
        } else if(!mail($recipient, $subject, $message, $headers)) {
	            /// Have problem on send mail 
	            $this->print_error("<b>Cannot connect to sendmail server. Sending email from {$email} to {$recipient} failed.</b>");
	    } else {
	        	 echo <<<EOF
<script>
    function redirect(){
        if(top != self){
            top.location.replace('{$this->aPropConf['thankurl']}');
        } else {
           location.replace('{$this->aPropConf['thankurl']}');
        }
    }
    redirect();
</script>     
EOF;
	    }
    }
	
    function formatTextMail($signature='')
    {
        $result = '';
        if ($this->aPropConf['is_preview'] === true) {
            $result .= "This mail for testting submit RVSiteBuilder form mail.\n\n";
        }
        foreach ($this->aPropConf['order'] as $k) {
            if ($this->aPropConf['properties'][$k]['type'] == 'control_fileupload' || $this->aPropConf['properties'][$k]['type'] == 'control_button') {
                continue;
            } else {
                $question =$this->aPropConf['properties'][$k]['text'];
                $answer = stripslashes($this->questions[$k]);
                $result .= "{$question}: {$answer}" . NEWLINE;
            }
        }
        $result .= $signature;
        return $result;
    }
    
    function formatHtmlMail($signature='')
    {
        $url = $this->aPropConf['url'];
        $formResult = $this->getFormHtmlResult();
$contents = <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <body bgcolor="#f7f9fc">
        <table bgcolor="#f7f9fc" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="30">&nbsp;</td>
        </tr>
        <tr>
            <td align="center">
                <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" bgcolor="#FFFFFF">
                        {$formResult}
                    </td>
                </tr>
                </table>
            </td>
        </tr>
        <tr>
        <td height="30">&nbsp;</td>
        </tr>
        </table>
        <br /><br />
        {$signature}
    </body>
</html>
  
EOF;
        return $contents;
    }
    
    function getFormHtmlResult()
    {
        $result = '';
        $attachment = '';
        $x = 0;
    if ($this->aPropConf['is_preview'] === true) {
            $result .= <<<EOF
            <b>This mail for testting submit RVSiteBuilder form mail.</b><br /><br />
            
EOF;
        }
        
        $result .= <<<EOF
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
                <tr>
                    <td bgcolor="#f9f9f9" width="170" style="text-decoration:underline; padding:5px !important;"><b>Question</b></td>
                    <td bgcolor="#f9f9f9" style="text-decoration:underline; padding:5px !important;"><b>Answer</b></td>
                </tr>
                
EOF;
        
        
        foreach ($this->aPropConf['order'] as $k) {
            //$alt = ($x%2 != 0)? "#f9f9f9" : "white";
            $alt = ($x%2 != 0)? "#bfbfbf;" : "white";
            if ($this->aPropConf['properties'][$k]['type'] == 'control_button' || $this->aPropConf['properties'][$k]['type'] == 'control_captcha'
                    || $this->aPropConf['properties'][$k]['type'] == 'control_pagebreak') {
                continue;
            } else if ($this->aPropConf['properties'][$k]['type'] == 'control_fileupload') {
                $question = $this->aPropConf['properties'][$k]['text'];
                $answer = nl2br(stripslashes($this->questions[$k]['name']));
                $result .= <<<EOF
                <tr>
                    <td bgcolor="{$alt}" style="padding:5px !important;" width="170"><b>{$question} (attachment):</b></td>
                    <td bgcolor="{$alt}" style="padding:5px !important;">File name "{$answer}"</td>
                </tr>
                
EOF;
/*
                if ($this->questions[$k]['type'] == 'image/jpeg') {
                    $attachmentId = $this->aMailAttachmentId[$k];
                    $imgId = $this->randId(4);
                    $attachment .= <<<EOF
                    <img id="rvrvsrvrvRVS_RV__r0000_v{$imgId}" src="cid:{$attachmentId}" />
                    
EOF;
                    
                }
*/                
         
          // fix email error
             } else if (isset($this->aPropConf['properties'][$k]['type']) && ($this->aPropConf['properties'][$k]['type'] == 'control_text' || $this->aPropConf['properties'][$k]['type'] == 'control_head')) {
               $question = stripslashes($this->aPropConf['properties'][$k]['text']);                              
               $result .= <<<EOF
               <tr>
                   <td bgcolor="{$alt}" style="padding:5px !important;" colspan="2"><b>{$question}</b></td>
               </tr>
EOF;
          } else {
                $question = stripslashes($this->aPropConf['properties'][$k]['text']);
                $answer = nl2br(stripslashes($this->questions[$k]));
                $result .= <<<EOF
                <tr>
                    <td bgcolor="{$alt}" style="padding:5px !important;" width="170"><b>{$question}:</b></td>
                    <td bgcolor="{$alt}" style="padding:5px !important;">{$answer}</td>
                </tr>

EOF;
            }
            $x++;
        }
        $result .= <<<EOF
        </table>
        {$attachment}

EOF;
        return $result;
    }
    
    function isAllowSendMail()
    {
        $projectId = (isset($this->aRVSPublist['project_id'])) ? $this->aRVSPublist['project_id'] : '';
        $path = dirname(dirname(dirname(dirname(__FILE__)))) .'/.rvsitebuilder/projects/'. $projectId . '/scripts/Tryout/setting.ini.php';
        $aConf =  (is_file($path)) ? parse_ini_file($path, true) : array();
        return (isset($aConf['allowSendMail']) && $aConf['allowSendMail'] != 1) ? false : true;
    }
    
    function formMailFilter($item)
    {
        $bad = 0;

        // remove the ending \n
        $item=preg_replace("/[\r\n]/","",$item);

        // Check if there is the bcc: included in the string
        /*FIX PHP 5.3 :: nipaporn*/
        $bad = preg_match('/bcc:/i', $item)?1:0 ;
        $bad = preg_match('/cc:/i', $item)?1:0 ;

        // Check if there is Content-Type included in the string
        /*FIX PHP 5.3 :: nipaporn*/
        $bad = preg_match('/Content-Type/i', $item)?1:0 ;

        if ($bad) {
            $this->print_error("<b>Spam mail detected. Your message never be sent. If you accidentally get this error, please contact us for the resolution.</b>");
        }
        return $item;
    }
	
    /**
     * buildPayment - Build payment - IF payment type single or sWm GOTO function buildSingleProduct
     * 														- Else if  payment type mult or multSub GOTO funtion buildSingleMultipleProduct
     * 														- Else if payment type sinSubInfo or sWmS GOTO funtion buildSingleSubscripProduct
     * 														- Else if payment type donation GOTO funtion buildDonation
     * 
     * @param Stromg $indexPayment - Current index payment.
     */
    function buildPayment($indexPayment)
	{
		if (isset($this->aPropConf['properties'][$indexPayment]['pType']) && $this->aPropConf['properties'][$indexPayment]['pType'] != '') {
			switch ($this->aPropConf['properties'][$indexPayment]['pType']) {
	            case 'single' :
	            case 'sWm' :
	            	       $this->buildSingleProduct($indexPayment, $this->aPropConf['properties'][$indexPayment]['pType']);  
	            	       break;
	            case 'mult' :
	            case 'multSub' :	
	                       $this->buildSingleMultipleProduct($indexPayment, $this->aPropConf['properties'][$indexPayment]['pType']);
	                       break;
	            case 'sinSubInfo' :
	            case 'sWmS' :
	            	       $this->buildSingleSubscripProduct($indexPayment, $this->aPropConf['properties'][$indexPayment]['pType']);
	                       break;          
	            case 'donation' :
	                       $this->buildDonation($indexPayment, $this->aPropConf['properties'][$indexPayment]['pType']);
	                       break;
	            	       
	            default : break;
			 }
			 
		} ///TODO etc case.
	}
	
	function getSessPayment()
	{
		$sessID = (isset($_COOKIE['SGLSESSID'])) ? $_COOKIE['SGLSESSID'] : '';
		return trim(md5(microtime() . $sessID));
	}
	
	/**
	 * Get index properties by type name
	 * 
	 * @param String $typeName
	 * @return Integer  -Index project type if aPropConf == $typeName
	 *                                  or NULL if  aPropConf != $typeName      
	 */
	function getIndexPropertiesByTypeName($typeName)
	{
	    $indexPayment = null;
	    
	    if (isset($this->aPropConf['properties']) === true) {
		    foreach ($this->aPropConf['properties'] as $k => $v) {
		        if (isset($this->aPropConf['properties'][$k]['type']) && $this->aPropConf['properties'][$k]['type'] == $typeName) {
		            $indexPayment = $k;
		            break;
		        }
		    }
	    }
	    
	    return $indexPayment;
	}
	
	function getNoShipping($indexPayment)
	{
		return (isset($this->aPropConf['properties'][$indexPayment]['payeradress']) && $this->aPropConf['properties'][$indexPayment]['payeradress'] == true) ? '1' : '0';
	}
	
	function getNotifyUrl()
	{
		$notifyUrl = "";
		
		///TODO test builder url
		if (isset($GLOBALS['HTTP_URL'])) {
			return urlencode($GLOBALS['HTTP_URL'] . "ipns/ipn.php");
		} else if (isset($_SERVER['REQUEST_URI'])) {
			return urlencode($_SERVER['REQUEST_URI']."ipns/ipn.php");
		}
		
		return $notifyUrl;
	}
	
	function getBridge($indexPayment)
	{
		$aInfoBridge = array();
		
		if (isset($this->aPropConf['properties'][$indexPayment]['bridge']) && $this->aPropConf['properties'][$indexPayment]['bridge'] != 'undefined') {
			/*FIX PHP 5.3 :: niapaporn*/
			$aBridge = preg_split("/&/", $this->aPropConf['properties'][$indexPayment]['bridge']);
			
			if (is_array($aBridge) === true) {
				
				foreach ($aBridge as $v) {
					list($key, $val) = preg_split("/=/", $v);
	
					$aInfoBridge[$key] = urlencode($val);
				}
				
			}
			
		}
		
		return $aInfoBridge;
	}
	
	function getBridgeUrl($indexPayment)
	{
		$bridgeUrl = "";
		$aInfoBridge = $this->getBridge($indexPayment);
		
		if (is_array($aInfoBridge) === true && count($aInfoBridge) > 0) {
			
			foreach ($aInfoBridge as $k => $v) {
				$k = preg_replace('/amp;/','',$k);
				
				switch ($k) {
					    case 'address'   : $k = 'address1'; break;
                        case 'firstname' : $k = 'first_name'; break;
                        case 'lastname'  : $k = 'last_name'; break;
                        case 'phone'     : $k = 'night_phone_a'; break;
					    default :  break;
				}
				
				if (isset($v) === true && $v != '') {
				    if (isset($this->aPropConf['properties'][$v]['type']) === true
				        && $this->aPropConf['properties'][$v]['type'] == 'control_textbox'
				        && isset($this->questions[$v]) === true
				        ) {
				        	$v = stripslashes($this->questions[$v]);	
				    }
				}
				
				$bridgeUrl .= $k . "=" . $v . "&";
			}
		}

		
		return $bridgeUrl;
	}
	
	function getCurrency($indexPayment)
	{
		$currentcy = "USD";
		
		if (isset($this->aPropConf['properties'][$indexPayment]['curr']) && $this->aPropConf['properties'][$indexPayment]['curr'] != '') {
			$currentcy = $this->aPropConf['properties'][$indexPayment]['curr'];
		}
		
		return $currentcy;
	}
	
	function getSid()
	{
		$sid = (time()-1134190800);
		
		if (isset($_SERVER['REMOTE_ADDR'])) {
			$sid = $sid . substr(preg_replace("/\D/", "", $_SERVER['REMOTE_ADDR']), 0, 9);
		}
		
		return $sid;
	}
	
	function getPeriod($indexPayment)
	{
		$aPeriod = array();
		
		if (isset($this->aPropConf['properties'][$indexPayment]['period']) && $this->aPropConf['properties'][$indexPayment]['period'] != '') {
			/*FIX PHP 5.3 :: niapaporn*/
			$aPeriod = preg_split('/:/', $this->aPropConf['properties'][$indexPayment]['period']);
			
			if (count($aPeriod) > 0) {
			    	if (isset($aPeriod[0])) {
			    		$aPeriod[0] = substr($aPeriod[0], 0, 1);
			    	} /// TODO else
			    	
			}
		}
		
		return $aPeriod;
	}
	
	function getTrial($indexPayment)
	{
	    $aTrial = array();
	    
	    if (isset($this->aPropConf['properties'][$indexPayment]['trial']) && $this->aPropConf['properties'][$indexPayment]['trial'] != '') {
	        /*FIX PHP 5.3 :: niapaporn*/
	    	$aTrial = preg_split('/:/', $this->aPropConf['properties'][$indexPayment]['trial']);
	        
	        if (count($aTrial) > 0) {
	                if (isset($aTrial[0])) {
	                    $aTrial[0] = substr($aTrial[0], 0, 1);
	                } /// TODO else
	                
	        }
	    }
	    
	    return $aTrial;
	}
	
	function getTermOf1stTrialPeriodUrl($indexPayment, $paymentType)
	{
		$getTermOf1stTrialPeriodUrl = '';
		$aTerm = $this->getTrial($indexPayment);
		
		if (count($aTerm) == 2 && isset($aTerm[1]) && $aTerm[1] != 0) {
			$getTermOf1stTrialPeriodUrl = "a1=0&";
	        $getTermOf1stTrialPeriodUrl .= "p1=". $aTerm[1] ."&";
	        $getTermOf1stTrialPeriodUrl .= "t1=" . $aTerm[0] ."&";
		} else {
			$aTerm = $this->getPeriod($indexPayment);
			
			if (count($aTerm) == 2) {
				$getTermOf1stTrialPeriodUrl = "a1=". $this->getTotolPriceSetup($indexPayment, $paymentType) ."&";
	            $getTermOf1stTrialPeriodUrl .= "p1=". $aTerm[1] ."&";
	            $getTermOf1stTrialPeriodUrl .= "t1=" . $aTerm[0] ."&";
			}
		}
		
		return $getTermOf1stTrialPeriodUrl;
	}
	
	function getTermRegularSubscription($indexPayment, $paymentType)
	{
		$termRegularSubscription = $this->getTermOf1stTrialPeriodUrl($indexPayment, $paymentType);
		$aTerm = $this->getPeriod($indexPayment);
	
		if (count($aTerm) == 2) {
			$termRegularSubscription .= "a3=" . $this->getTotalPrice($indexPayment, $paymentType) . "&";
	        $termRegularSubscription .= "p3=" . $aTerm[1] . "&";
	        $termRegularSubscription .= "t3="  . $aTerm[0] . "&";
		}
		    
	    return $termRegularSubscription;
	}
	
	function getTotolPriceSetup($indexPayment, $paymentType)
	{
		$totalPriceSetup = 0;
		$aProductPrice = $this->getProductPrice($indexPayment, $paymentType);
		$aSetup = $this->getSetup($indexPayment, $paymentType);
		
		///TODO compute
		if (is_array($aProductPrice) === true && count($aProductPrice) > 0 && is_array($aSetup) === true && count($aSetup) > 0) {
			foreach ($aProductPrice as $k => $v) {
				$totalPriceSetup += ($aProductPrice[$k] + $aSetup[$k]);
			}
			
			return $totalPriceSetup;
	    } else if (is_array($aSetup) === false && is_numeric($aSetup ) === false) {
	    	$aSetup = 0;
	    }
		
		return (is_numeric($aProductPrice) === true) ? $aProductPrice + $aSetup : 0 + $aSetup;
	}
	
	function buildSingleProduct($indexPayment, $paymentType)
	{
		$link = null;
		$domainPaypal = "https://www.paypal.com/cgi-bin/webscr?";
		//$domainPaypal = "https://www.sandbox.paypal.com/cgi-bin/webscr?";
		$sessPayment = $this->getSessPayment();
		
		 if (isset($this->aPropConf['properties'][$indexPayment]['type']) && $this->aPropConf['properties'][$indexPayment]['type'] == 'control_paypal') {
		       $link = $domainPaypal; 
		       $link .= "business=" . $this->getBusinessAccount($indexPayment) . "&";
		       $link .= "item_name=" . $this->getItemUrl($indexPayment, $paymentType) . "&";
		       $link .= "amount=" . $this->getTotalPrice($indexPayment, $paymentType) . "&";
		       $link .= "currency_code=" . $this->getCurrency($indexPayment) . "&";
		       $link .= "rm=2&"; 
		       $link .= "cmd=_xclick&";
		       $link .= "no_shipping=" . $this->getNoShipping($indexPayment) . "&";
		       $link .= "notify_url=" . $this->getNotifyUrl() . "&";
		       $link .= "return=" . $this->getUrlThank() . "&";
		       $link .= "custom=" . $sessPayment . "-" . $this->aPropConf['formID'] . "-" . $this->getSid() . "&";
		       $link .= "session=" . $sessPayment . "&";
		       $link .= $this->getBridgeUrl($indexPayment);
		 }
		 
		 if (isset($link) === true) {
	?>
				<script type='text/javascript'>
				     window.location.href= "<?php echo $link; ?>";
				</script>
	<?php
		 }
	}
	
	function buildSingleMultipleProduct($indexPayment, $paymentType)
	{
		$link = null;
		$domainPaypal = "https://www.paypal.com/cgi-bin/webscr?";
		//$domainPaypal = "https://www.sandbox.paypal.com/cgi-bin/webscr?";
		$sessPayment = $this->getSessPayment();
	
		if (isset($this->aPropConf['properties'][$indexPayment]['type']) && $this->aPropConf['properties'][$indexPayment]['type'] == 'control_paypal') {
			$link = $domainPaypal;
			$link .= "business=" . $this->getBusinessAccount($indexPayment) . "&";
			$link .= "upload=1&";
			$link .= $this->getItemUrl($indexPayment, $paymentType);
			$link .= $this->getTotalPrice($indexPayment, $paymentType);
			$link .= "currency_code=" . $this->getCurrency($indexPayment) . "&";
			$link .= "rm=2&";
			$link .= "cmd=_cart&";
			$link .= "no_shipping=" . $this->getNoShipping($indexPayment) . "&";
			$link .= "notify_url=" . $this->getNotifyUrl() . "&";
			$link .= "return=" . $this->getUrlThank() . "&";
			$link .= "custom=" . $sessPayment . "-" . $this->aPropConf['formID'] . "-" . $this->getSid() . "&";
			$link .= "session=" . $sessPayment . "&";
			$link .= $this->getBridgeUrl($indexPayment);
		}
	    
	     if (isset($link) === true) {
	?>
	            <script type='text/javascript'>
	                 window.location.href= "<?php echo $link; ?>";
	            </script>
	<?php
	
	     }
	}
	
	function buildSingleSubscripProduct($indexPayment, $paymentType)
	{
		$link = null;
	    $domainPaypal = "https://www.paypal.com/cgi-bin/webscr?";
	    //$domainPaypal = "https://www.sandbox.paypal.com/cgi-bin/webscr?";
	    $sessPayment = $this->getSessPayment();
		
	     if (isset($this->aPropConf['properties'][$indexPayment]['type']) && $this->aPropConf['properties'][$indexPayment]['type'] == 'control_paypal') {
	     	 $link = $domainPaypal; 
	         $link .= "business=" . $this->getBusinessAccount($indexPayment) . "&";
	         $link .= "item_name=" . $this->getItemUrl($indexPayment, $paymentType) . "&";
	         $link .= $this->getTermRegularSubscription($indexPayment, $paymentType);
	         $link .= "currency_code=" . $this->getCurrency($indexPayment) . "&";
	         $link .= "rm=2&";
	         $link .= "src=1&";
	         $link .= "cmd=_xclick-subscriptions&";
	         $link .= "no_shipping=" . $this->getNoShipping($indexPayment) . "&";
	         $link .= "notify_url=" . $this->getNotifyUrl() . "&";
	         $link .= "return=" . $this->getUrlThank() . "&";
	         $link .= "custom=" . $sessPayment . "-" . $this->aPropConf['formID'] . "-" . $this->getSid() . "&";
	         $link .= "session=" . $sessPayment . "&";
	         $link .= $this->getBridgeUrl($indexPayment);
	     }
	     
	     if (isset($link) === true) {
	?>
	            <script type='text/javascript'>
	                 window.location.href= "<?php echo $link; ?>";
	            </script>
	<?php
	     }
	}
	
	function buildDonation($indexPayment, $paymentType)
	{
	    $link = null;
	    $domainPaypal = "https://www.paypal.com/cgi-bin/webscr?";
	    //$domainPaypal = "https://www.sandbox.paypal.com/cgi-bin/webscr?";
	    $sessPayment = $this->getSessPayment();
	    
	     if (isset($this->aPropConf['properties'][$indexPayment]['type']) && $this->aPropConf['properties'][$indexPayment]['type'] == 'control_paypal') {
	           $link = $domainPaypal; 
	           $link .= "business=" . $this->getBusinessAccount($indexPayment) . "&";
	           $link .= "item_name=" . $this->getItemUrl($indexPayment, $paymentType) . "&";
	           $link .= "amount=" . $this->getTotalPrice($indexPayment, $paymentType) . "&";
	           $link .= "currency_code=" . $this->getCurrency($indexPayment) . "&";
	           $link .= "rm=2&"; 
	           $link .= "cmd=_donations&";
	           $link .= "no_shipping=" . $this->getNoShipping($indexPayment) . "&";
	           $link .= "notify_url=" . $this->getNotifyUrl() . "&";
	           $link .= "return=" . $this->getUrlThank() . "&";
	           $link .= "custom=" . $sessPayment . "-" . $this->aPropConf['formID'] . "-" . $this->getSid() . "&";
	           $link .= "session=" . $sessPayment . "&";
	           $link .= $this->getBridgeUrl($indexPayment);
	     }
	     
	     if (isset($link) === true) {
	?>
	            <script type='text/javascript'>
	                 window.location.href= "<?php echo $link; ?>";
	            </script>
	<?php
	     }
	}
	
	function getBusinessAccount($indexPayment)
	{
		$businessAccount = "";
		
		if (isset($this->aPropConf['properties'][$indexPayment]['account']) && $this->aPropConf['properties'][$indexPayment]['account'] != '') {
			
			$businessAccount = ($this->validateEmail($this->aPropConf['properties'][$indexPayment]['account']) === true) 
			                                          ? $this->aPropConf['properties'][$indexPayment]['account'] 
			                                          : $businessAccount;
		}
		
		return $businessAccount; 
	}
	
	function validateEmail($email)
	{
/*FIX PHP 5.3 :: nipaporn*/
		return (preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z-]+\.)+[a-z]{2,6}$/i", $email)) ? true : false;
	}
	
	function getSetup($indexPayment, $paymentType)
	{
	    $setup = 0;
	    
	    if (isset($this->aPropConf['properties'][$indexPayment]['setup']) && $this->aPropConf['properties'][$indexPayment]['setup'] != '' 
	            && $this->aPropConf['properties'][$indexPayment]['setup'] != 'undefined') {
	        return $this->_validate_paymentType($indexPayment, $paymentType, 'setup');
	    }
	    
	    return $setup;
	}
	
	function getItem($indexPayment, $paymentType)
	{
		$aItem = array();
		
		if (isset($this->aPropConf['properties'][$indexPayment]['item1']) && $this->aPropConf['properties'][$indexPayment]['item1'] != '') {
			return $this->_validate_paymentType($indexPayment, $paymentType, 'item1');
		}
		
		return $aItem;
	}
	
	function getProductId($indexPayment, $paymentType)
	{
		$aProductId = array();
		
		if (isset($this->aPropConf['properties'][$indexPayment]['pids']) && $this->aPropConf['properties'][$indexPayment]['pids'] != '') {
			return $this->_validate_paymentType($indexPayment, $paymentType, 'pids');
		}
	
		return $aProductId;
	}
	
	function getItemUrl($indexPayment, $paymentType)
	{
		$itemUrl = "";
		$aItem = $this->getItem($indexPayment, $paymentType);
		$aProductId = $this->getProductId($indexPayment, $paymentType);
		
		if (isset($_POST['paypal' . $indexPayment]) && is_array($_POST['paypal' . $indexPayment]) === true 
		       && ($paymentType == 'mult' || $paymentType == 'multSub')) {
	
			if (is_array($aItem) === true && is_array($aProductId) === true && count($aItem) > 0 && count($aProductId) > 0) {
				
				foreach ($_POST['paypal' . $indexPayment] as $k => $v) {
					
					$aKeys = array_keys($aProductId, $v);
	
					if (isset($aKeys[0])) {
						$itemUrl .= 'item_name_';
						$itemUrl .= $k+1;
						$itemUrl .= '=';
						$itemUrl .= $aItem[$aKeys[0]];
						$itemUrl .= '&';
					}				
				}
	
			}
			
	    } else {
	    	//$itemUrl = ($aItem != '' && $aProductId != '') ? $aItem . ',' . $aProductId : $itemUrl;
	        $itemUrl = ($aItem != '' && $aProductId != '') ? $aItem : $itemUrl;
	    }
	    
	    return $itemUrl;
	}
	
	function getProductPrice($indexPayment, $paymentType)
	{
		$aProductPrice = array();
	    
	    if (isset($this->aPropConf['properties'][$indexPayment]['price']) && $this->aPropConf['properties'][$indexPayment]['price'] != '') {
	        return $this->_validate_paymentType($indexPayment, $paymentType, 'price');
	    }
	    
	    return $aProductPrice;
	}
	
	function getTotalPrice($indexPayment, $paymentType)
	{
		$totalProduct = 0;
		$amount = '';
		$aProductId = $this->getProductId($indexPayment, $paymentType);
		$productPrice = $this->getProductPrice($indexPayment, $paymentType);
		
		if (isset($_POST['donation_amount']) && $_POST['donation_amount'] != '') {
		   return (is_numeric($_POST['donation_amount']) === true) ? $_POST['donation_amount'] : 0;
		}
	
		if (isset($_POST['paypal' . $indexPayment]) && is_array($_POST['paypal' . $indexPayment]) === true 
		       && ($paymentType == 'mult' || $paymentType == 'multSub')) {
	
			if (is_array($productPrice) === true && is_array($aProductId) === true && count($productPrice) > 0 && count($aProductId) > 0) {
				
				foreach ($_POST['paypal' . $indexPayment] as $k => $v) {
	
					$aKeys = array_keys($aProductId, $v);
					
					if (isset($aKeys[0])) {
						$amount .= 'amount_';
						$amount .= $k+1;
						$amount .= '=';
						$amount .= $productPrice[$aKeys[0]] . '&';
					}
				}
	
			}
			
			return $amount;
	
		} else {
		   $totalProduct = (isset($productPrice) && $productPrice != '') ? $productPrice : $totalProduct;
		}
		
		return $totalProduct;
	}
	
	function getUrlThank()
	{
		$dataPostMail = 0;
		if (isset($this->currentKeyDataPostMail)) {
			$dataPostMail = $this->buildPostMail($this->currentKeyDataPostMail, $this->form_id);
		}
		
		if (isset($this->aPropConf['thankurl']) && $this->aPropConf['thankurl'] != '') {
			return $this->aPropConf['thankurl'] . '?sendmail=' . $dataPostMail;
		}
		
	    return $this->aPropConf['url'] . '?sendmail=' . $dataPostMail;
	}
	
	function _validate_paymentType($indexPayment, $paymentType, $dataType)
	{
		$aData = array();
		
		if ($paymentType == 'single' || $paymentType == 'sinSubInfo' || $paymentType == 'donation') {
			return $this->aPropConf['properties'][$indexPayment][$dataType];
		} else if ($paymentType == 'sWm' || $paymentType == 'sWmS') {
		   return $this->getSingleWithMulti($indexPayment, $dataType);
		} else if ($paymentType == 'mult' || $paymentType == 'multSub') {
			return $this->compileDataType($indexPayment, $dataType);
		} //// TODO paymentType etc.
		
		return $aData;
	}
	
	function compileDataType($indexPayment, $dataType)
	{
	    $aData = array();
	    /*FIX PHP 5.3 :: niapaporn*/
	    $aData = preg_split('/:/', $this->aPropConf['properties'][$indexPayment][$dataType]);
	    
	    if (count($aData) > 0) {
	        foreach ($aData as $k => $v) {
	                $aData[$k] = $v;
	         }
	    } else {
	            return $this->aPropConf['properties'][$indexPayment][$dataType];
	    }
	    
	    return $aData;
	}
	
	function getSingleWithMulti($indexPayment, $dataType)
	{
		 if (isset($_POST['paypal' . $indexPayment]['0']) && $_POST['paypal' . $indexPayment]['0'] != '') {
		 	
		   $aData = $this->compileDataType($indexPayment, $dataType);
		
		   if (is_array($aData) === false) {
		       return $aData;
		   }
		   
	       $aProductId = $this->compileDataType($indexPayment, 'pids');
	    	
	        if (is_array($aProductId) === true) {
	            $aKeys = array_keys($aProductId, $_POST['paypal' . $indexPayment]['0']);
	            
	            if (isset($aKeys[0])) {
	                return $aData[$aKeys[0]];
	            }            
	        }
	        
	    }
	    
	    return '';
	}
	
    /**
     * writeScriptAppendSendMail - Write php script dirname(dirname(dirname(__FILE__))) . "/rvthankform_" . $this->form_id . ".php"
     * 
     * @param String $filename - File name for write script
     * @param String $phpScriptAppend - Content script
     */
    function writeScriptAppendSendMail($filename, $phpScriptAppend)
    {
    	if(is_writable($filename)) {
    		if (file_exists($filename) === true) {
    			htmlspecialchars($phpScriptAppend);
    			$handle = fopen($filename, "w+");
    			fwrite($handle, $phpScriptAppend . file_get_contents($filename));
    			fclose($handle);
    		}
    	}
    	
    }
    
    /**
     * phpScriptAppendSendMail - Build php script for write script.
     * 
     * @return String $dataScriptAppendSendMail - String php script 
     */
    function phpScriptAppendSendMail()
    {
		$dataScriptAppendSendMail = <<<EOF
<?php ///RVS_START_SENDMAIL
	if (isset(\$_GET['sendmail'])) {
	
		\$getPost = base64_decode(strtr(\$_GET['sendmail'], '-_,', '+/='));
		//@eval(\$getPost);
		\$aData = explode(",", \$getPost);

		//\$aData[0] - key
		//\$aData[1] - id file
		if (isset(\$aData[0]) && isset(\$aData[1])) {
		
			\$filename	= dirname(__FILE__) . '/postdata_' . trim(\$aData[1]) . '.php';
			if (is_file(\$filename) === true) {
				require_once \$filename;
				
				if (isset(\$aCurrentKey[trim(\$aData[0])])) {
					\$getContentSendMail = base64_decode(strtr(\$aCurrentKey[trim(\$aData[0])], '-_,', '+/='));
					
					@eval(\$getContentSendMail);
					if (isset(\$recipient) && isset(\$subject) && isset(\$message) && isset(\$headers)) {
						@mail(stripslashes(\$recipient), stripslashes(\$subject), stripslashes(\$message), stripslashes(\$headers));
			    	}
    			}
    		}
    			
    	}
		
	}
?>
EOF;

    	return $dataScriptAppendSendMail;
    }
    
    
    /**
     * buildContentMail - Build content mail those recipient, subject, message, headers
     * 									and encode content mail on base64.
     * 
     * @param String $recipient : Recipient mail
     * @param String $subject : Subject mail
     * @param String $message : Message mail
     * @param String $headers : Header mail
     * @return String $contentMail - Encode content mail on base64
     */
    function buildContentMail($recipient, $subject, $message, $headers)
    {
    	$contentMail = <<< EOF
\$recipient = '{$recipient}';
\$subject = '{$subject}';
\$message = '{$message}';
\$headers = '{$headers}';
EOF;

		return strtr(base64_encode($contentMail), '+/=', '-_,');
    }
	
    /**
     * writeContentMail - Write content mail to file dirname(dirname(dirname(__FILE__))) /postdata_" . $this->form_id . ".php.
     * 									 For get cotentmail by $key
     * 										
     * 
     * @param String $contentMail - Content mail encode content mail on base64.
     * 														 - Content mail those recipient, subject, message, headers
     * @param $filename - File name for write content mail
     * @param $key - Current key content mail
     */
    function writeContentMail($contentMail, $filename, $key)
    {
    		$contentMail = <<<EOF
<?php    		
	\$aCurrentKey['{$key}'] = '{$contentMail}';
?>
    		
EOF;

    		$handle = fopen($filename, "a+");
	    	fwrite($handle, $contentMail);
	    	fclose($handle);
    }
    
    /**
     * buildPostMail - Build post data mail, encode data mail on base64.
     * 							  For send data to paypal and redirect data mail from site paypal to thank form sitebuilder
     * 
     * @param String $currentKeyDataPostMail - Current key post data mail for current private post data mail
     * 																				  from site paypal to thak form sitebuilder 
     * @param String $formID - Form Id
     * @return String $postMail - Encode content mail on base64
     */
	function buildPostMail($currentKeyDataPostMail, $formID)
	{
		$postMail = <<< EOF
		{$currentKeyDataPostMail},{$formID}
EOF;

		return strtr(base64_encode($postMail), '+/=', '-_,');
	}
}

?>