<?

define('API_PUBLIC', '6Ld9UAgAAAAAAMon8zjt30tEZiGQZ4IIuWXLt1ky');
define('API_PRIVATE', '6Ld9UAgAAAAAAMpq26ktw51roN5pmRw6wCrO3lKh ');


//require_once($_SERVER[DOCUMENT_ROOT].'/lib/recaptcha/recaptchalib.php');

/// RVS START fix captcha
$libPath = dirname(__FILE__) .'/lib/recaptcha/recaptchalib.php';
$libPath2 = dirname(__FILE__) . '/jotform/lib/recaptcha/recaptchalib.php';
$recaptchalibPath = (is_file($libPath2)) ? $libPath2 : $libPath;
require_once($recaptchalibPath);
/// RVS END fix captcha
$publickey = API_PUBLIC; // you got this from the signup page

// Style for reCaptcha field
echo "document.write('<style> ".
 "#recaptcha_logo{ display:none;}".
 "#recaptcha_tagline{display:none;}".
 "#recaptcha_table{border:none !important;}".
 ".recaptchatable .recaptcha_image_cell, #recaptcha_table{ background-color:transparent !important; }".
 "</style>');\n\n";

// Set theme for reCaptcha 
echo "RecaptchaOptions={theme:'clean'};\n\n";
// Get reCaptcha HTML
echo "document.write('".preg_replace("/\n/", "\\n", recaptcha_get_html($publickey, null, !empty($_SERVER['HTTPS'])))."');\n\n";
// contentloaded event
echo "var jotevent = {domLoad:[],domLoaded: function(){if (arguments.callee.done) {return;}arguments.callee.done = true;for (i = 0; i < jotevent.domLoad.length; i++) {jotevent.domLoad[i]();}},onDomLoaded: function(A){this.domLoad.push(A);if (document.addEventListener) {document.addEventListener('DOMContentLoaded', jotevent.domLoaded, null);} else {if (navigator.appVersion.indexOf('MSIE')!=-1) {document.write('<script id=__ie_onload defer ' + ((location.protocol == 'https:') ? 'src=\'javascript:void(0)\'' : 'src=//0') + '><\/script>');document.getElementById('__ie_onload').onreadystatechange = function(){if (this.readyState == 'complete') {jotevent.domLoaded()}}}}window.onload = jotevent.domLoaded}};\n\n";
// Initiate
echo "

jotevent.onDomLoaded(function(){
    if (document.getElementById('uword')) {
        document.getElementById('uword').parentNode.removeChild(document.getElementById('uword'));
    }
    if (window['validate'] !== undefined) {
        document.getElementById('recaptcha_response_field').onblur = function(){
            validate(document.getElementById('recaptcha_response_field'), 'Required');
        }
    }
    document.getElementsByName('recaptcha_challenge_field')[0].setAttribute('name', 'anum');
    document.getElementsByName('recaptcha_response_field')[0].setAttribute('name', 'qCap');
});

";

exit;

include_once "lib/db.php";
include "lib/sql_form.php";
$c = cimg();

echo "document.write(\" ".$c." \")";

?>