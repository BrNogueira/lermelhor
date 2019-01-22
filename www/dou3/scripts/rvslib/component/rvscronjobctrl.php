<?php
// $aPublishProjectConf read ini dirname(__FILE__) . '/.conjobcomponent.ini.php'
$fileConJob = dirname(__FILE__) . '/.componentPublishVersion.ini.php';
/*
//$publishPath = realpath("./"); //get by home user
$publishPath = dirname(dirname(dirname(dirname(__FILE__))));

if (is_file($publishPath . '/.rvsPublish.ini.php')) {
	$aCompoConf = parse_ini_file($publishPath . '/.rvsPublish.ini.php', true);
	$backPath = (isset($aCompoConf['component_path'])) ? $aCompoConf['component_path'] : "";
}
$fileConJob =  $publishPath . '/' . $backPath . '.rvsitebuilder/.conjobcomponent.ini.php';
*/
if (is_file($fileConJob)) {
	$aComponents = parse_ini_file($fileConJob, true);
} else {
	exit();	
}
/*
 [4aee1678807da1b39b281671fb1caf0b]
newsletter=1
*/
// Loop $aPublishProjectConf 
foreach ($aComponents as $projectID => $aProjectCompoConf) {
    if (isset($aComponents[$projectID])) {
        // Find $ProjectPublishDir at ????
        $ProjectPublishDir = $aProjectCompoConf['publish_path'];
        
        //TODO:validate comonent is disable cannot run อาจจะทำงานอยู่แล้วใน rvsindex.php
        //TODO:CLI in loging
        //TODO: if system is disable_function, we need to use GET /$ProjectPublishDir . '/rvsindex.php ....???
        
        if (array_key_exists( 'Newsletter', $aComponents[$projectID]) && is_file($ProjectPublishDir . '/rvsindex.php')) {
        /*
        * --moduleName=emailqueue --managerName=emailqueue --action=flush
        * --moduleName=emailqueue --managerName=emailqueue --action=process --deliveryDate=2008-04-08
        * --moduleName=emailqueue --managerName=emailqueue --action=process --deliveryDate=all
        */
            system('php '. $ProjectPublishDir . '/rvsindex.php --moduleName=emailqueue --managerName=emailqueue --action=process --deliveryDate=all');
        } 
        
        if (array_key_exists( 'ComponentAndUserFramework', $aComponents[$projectID]) && is_file($ProjectPublishDir . '/rvsindex.php')) {
            system('php '. $ProjectPublishDir . '/rvsindex.php --moduleName=user --managerName=terminateaccount --action=terminate --deliveryDate=all');
            
        }
    }
}
?>