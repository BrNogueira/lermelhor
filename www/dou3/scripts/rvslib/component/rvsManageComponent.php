<?php
class rvsManageComponent
{
    function rvsManageComponent()
    {
        return true;
    }

    function getRvsitebuildDir()
    {
        $rvsDir = dirname(__FILE__);
        $i = 0;
        do {
            if (is_dir($rvsDir . '/.rvsitebuilder')) {
                return $rvsDir;
            }
            $rvsDir = dirname($rvsDir);
            $i++;
        } while ($i < 30);
        die('Cannot find home dir.');
    }

    /**
     * validate component if disable redirect to rvsMasterTemplate.php 
     *
     * @param unknown_type $componentName
     * $componentName = Online_Form
     * $componentName = Photo_Album
     * $componentName = GuestBook
     * 
     * component config ROOT
     * RVS_USER_HOME/.rvsitebuilder/.componentconf/.componentVersionControl.ini
     * RVS_USER_HOME/.rvsitebuilder/.componentconf/.{projectId}.ini
     * 
     * component config USER
     * RVS_PUBLISH_PATH/{folder}/.rvsPublish.ini.php
     * 
     * $compoFinalValue = false component is Enable
     * $compoFinalValue = true component is Disable
     */
    function validateManageComponent($componentName = "")
    {
        //$publishPath = dirname(dirname(dirname(dirname(__FILE__))));
        $publishPath = realpath("./");
        
        if (is_file($publishPath . '/.rvsPublish.ini.php')) {
            $aCompoConf = parse_ini_file($publishPath . '/.rvsPublish.ini.php', true);
            $backPath = (isset($aCompoConf['component_path'])) ? $aCompoConf['component_path'] : "";
            $projectId = (isset($aCompoConf['project_id'])) ? $aCompoConf['project_id'] : "";
            $compoversion = (isset($aCompoConf[$componentName])) ? $aCompoConf[$componentName] : "";
            
            $homePath = rvsManageComponent::getRvsitebuildDir();
            //set path
            $compoPathConf = $homePath . '/.rvsitebuilder/.componentconf/.componentVersionControl.ini';
            $compoProjectConf = $homePath . '/.rvsitebuilder/.componentconf/' . $projectId . '.ini';
            //get config
            if (is_file($compoPathConf)) {
                $aCompoVersionConf = parse_ini_file($compoPathConf, true);
            }
            if (is_file($compoProjectConf)) {
                $aCompoProjectConf = parse_ini_file($compoProjectConf, true);
            }
            //return status
            $compoVersionControlStatus = (isset($aCompoVersionConf['DefaultProject'][$componentName]))
                                                                ? $aCompoVersionConf['DefaultProject'][$componentName]
                                                                : false;
            $compoNameControlStatus =    (isset($aCompoVersionConf[$componentName][$compoversion]))
                                                                ? $aCompoVersionConf[$componentName][$compoversion]
                                                                : false;
            $compoProjectControlStatus = (isset($aCompoProjectConf[$componentName][$compoversion]))
                                                                ? $aCompoProjectConf[$componentName][$compoversion]
                                                                : false;
                                                                
            if ($compoVersionControlStatus == 1) {
                $compoFinalValue = 1;
            } elseif ($compoNameControlStatus == 1) {
                $compoFinalValue = 1;
            } elseif ($compoProjectControlStatus == 1) {
                $compoFinalValue = 1;
            } else {
                $compoFinalValue = 0;
            }
            //$compoFinalValue = ($compoProjectValue) ? $compoProjectValue : $compoDefaultValue;
            
            /*
            echo "<pre>";
            echo $publishPath . '/.rvsPublish.ini.php' . '<br>';
            print_r($aCompoConf);
            echo $compoPathConf . "<br>";
            print_r($aCompoVersionConf);

            echo $compoProjectConf . "<br>";
            print_r($aCompoProjectConf);

            echo "<br>Version control status: " . $compoVersionControlStatus;
            echo "<br>cName control status: " . $compoNameControlStatus;
            echo "<br>Project controlstatus: " . $compoProjectControlStatus;
            echo "<br>Final: " . $compoFinalValue;
             */
            
            if ($compoFinalValue == 1) {
                $redirect = $aCompoConf['publish_url'] . '/rvsMasterTemplate.php?componentname=' . $componentName;
                header("Location: " . $redirect);
                exit;
            }
        }
    }
}
?>