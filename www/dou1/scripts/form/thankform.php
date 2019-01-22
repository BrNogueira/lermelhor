<script type="text/javascript" >
function goBack()
{
	var rvs_is_ie = document.all? true: false;
	if(rvs_is_ie){
		var pageLocation = window.location.href;
		var isPreview =  pageLocation.match('RvSitebuilderPreview');	
		if(isPreview != null){
			history.go(-2);				
		}			
		else{
			history.go(-1);
		}
	}		
	else {history.go(-1);	}	
}
</script>
<center>
<table border="0" cellpadding="0" cellspacing="0">
<tbody>
 <tr><td>
<?php


/** Set Array $aLang
 *  Contain user translated langauge
 */
$rvsDefaultLangFile =   'english-utf-8.php';
if(isset($RVS_LANG)){
	$rvsLangFile = $RVS_LANG . '.php';
}

if(is_readable('scripts/form/language/' . $rvsLangFile)){
	include 'language/' . $rvsLangFile;
}
elseif(is_readable('scripts/form/language/' . $rvsDefaultLangFile)){
	include 'language/' . $rvsDefaultLangFile;
}
else {
    $aLang['The form was not submitted for the following reasons:'] = 'The form was not submitted for the following reasons:';
	$aLang['Please click'] = 'Please click';
	$aLang['here'] = 'here' ;
	$aLang['to return to the form and try again.'] = 'to return to the form and try again.' ; 
}

if (isset($_REQUEST['error'])) {
    echo $aLang['The form was not submitted for the following reasons:'] . "\n";
    echo "<ul><font color=\"red\">\n";
    echo $_REQUEST['error'] . "\n";
    echo "</font></ul>\n";
    echo $aLang['Please click'] . ' <a href="javascript:goBack()" >' . $aLang['here'] . '</a> ' . $aLang['to return to the form and try again.'] . "\n";
    echo "<br /><br />";
}
else {
    echo $THANK_MSG . "\n";
    echo "<br /><br />";
}
?>
</td></tr>
</tbody>
</table>
</center>