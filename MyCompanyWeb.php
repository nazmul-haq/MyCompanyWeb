<?php
/**
 * Addon My company Web
 *
 * @package    WHMCS
 * @author     showket <showket.logicparadise@gmail.com>
 * @copyright  Copyright (c) WHMCS Limited 2005-2013
 * @license    http://www.whmcs.com/license/ WHMCS Eula
 * @version    $Id$
 * @link       http://www.whmcs.com/
 */

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");
use WHMCS\Database\Capsule;
include(__DIR__."/MyCompanyWeb/products.php");

function MyCompanyWeb_config()
{
    $configarray = array(
        "name" => "MyCompanyWeb",
        "description" => "Be a Professional Hosting Provider with MyCompanyWeb. We provide Everything You Need!",
        "version" => "2.1",
        "author" => "SkyNetHosting.Net Inc.",
        "language" => "English",
        "fields" => array(
            "hostname" => array("FriendlyName" => "Install Domain", "Type" => "text", "Size" => "25", "Description" => "e.g: mydomain.com ( without http://www. )", "Default" => "mydomain.com"),
            
            "username" => array("FriendlyName" => "cPanel Username", "Type" => "text", "Size" => "25", "Description" => ""),
            "password" => array("FriendlyName" => "cPanel Password", "Type" => "password", "Size" => "25", "Description" => ""),

        ));
    return $configarray;
}

function MyCompanyWeb_activate()
{
    # Return Result
    return array('status' => 'success', 'description' => 'MyCompanyWeb addon module was activated successfully. Please configure it below.');

}

function MyCompanyWeb_deactivate()
{


    # Return Result
    return array('status' => 'success', 'description' => 'MyCompanyWeb addon module was deactivated successfully.');


}

function MyCompanyWeb_upgrade($vars)
{


}


function MyCompanyWeb_moveFolder($_server, $_user_name, $_user_pass, $local_dir, $remote_dir)
{


    $result = false;
    $ftp_result = MyCompanyWeb_connectFtp($_server, $_user_name, $_user_pass);
    $conn_id = $ftp_result['message'];


    if ($ftp_result['status'] == 'error') {
        $message = $ftp_result['message'];
        echo $message;
        $result = false;
    } else {

        @ftp_mkdir($conn_id, $remote_dir);
        //echo "successfully created $remote_dir\n";
        $handle = opendir($local_dir);
        while (($file = readdir($handle)) !== false) {

            if (($file != '.') && ($file != '..')) {
                if (is_dir($local_dir . $file)) {
//recursive call
                    MyCompanyWeb_moveFolder($_server, $_user_name, $_user_pass, $local_dir . $file . '/', $remote_dir . $file . '/');

                } else
                    $f[] = $file;
            }
        }

        closedir($handle);
        if (count($f)) {
            sort($f);
            @ftp_chdir($conn_id, $remote_dir);
            foreach ($f as $files) {
                $from = @fopen("$local_dir$files", 'r');

                $moveFolder = ftp_fput($conn_id, $files, $from, FTP_BINARY);
                // @ftp_fput($conn_id, $files, $from, FTP_BINARY);
                // check upload status
                if (!$moveFolder) {
                    //echo "FTP upload has failed! From:" . $local_dir . " To: " . $remote_dir;
                    $result = false;
                } else {
                    //echo "Uploaded $local_dir to $remote_dir";
                    $result = true;
                }
            }
        }


        ftp_close($conn_id);


        return $result;
    }
}

function get_all_between($beginning, $end, $string)
{
    $beginningPos = strpos($string, $beginning);
    $endPos = strpos($string, $end);
    if ($beginningPos === false || $endPos === false) {
        return $string;
    }

    $textBetween = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

    return $textBetween;
}

function delete_all_between($beginning, $end, $string)
{
    $beginningPos = strpos($string, $beginning);
    $endPos = strpos($string, $end);
    if ($beginningPos === false || $endPos === false) {
        return $string;
    }

    $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

    return str_replace($textToDelete, '', $string);
}

function MyCompanyWeb_clientArea($vars)
{


    if (isset($_REQUEST['ajax'])) {






        $file = __DIR__ . "/MyCompanyWeb/index.html";

        $tempFile=__DIR__ . "/MyCompanyWeb/outPut/indextemp.html";
        
       
        $string=html_entity_decode(htmlspecialchars_decode($_POST['html']),ENT_QUOTES, "UTF-8");
        
        
       //$beginningPos = strpos($string, '<!--End LiveChat-->');
        //$length=strlen($string);
        
        //$str=substr_replace($string,"<!--End LiveChat--></body></html>",$beginningPos,$length);
        //$_POST['html']=$str;
        
        
        file_put_contents($tempFile, $string);

        $out = delete_all_between("temporarystartlinks", "temporaryendlinks", $string);
        
        
        



        $out = str_replace(array('pointer-events: none'), 'pointer-events: auto', $out);
        $replace = Array("");
        $processed_page = str_replace($search, $replace, $out);


        file_put_contents($file, $processed_page);

        //file_put_contents($file, html_entity_decode($processed_page));
        
        $remote_file = 'public_html/index.html';
        $ftp_result = MyCompanyWeb_connectFtp($vars['hostname'], $vars['username'], $vars['password']);

        $upC=0;
        $upCFTP=0;
        if ($ftp_result['status'] == 'error') {
            $message = $ftp_result['message'];
            echo "<div class='errorbox'><strong><span class='title'>Error</span></strong><br>".$message."<br></div>";
            exit;
        } else {
            $ftp_conn = $ftp_result['message'];
            try {
                //$installPath = $vars['installpath'];
                $upCFTP = ftp_put($ftp_conn, $remote_file, $file, FTP_BINARY);
                // $up=ftp_put($ftp_conn, $installPath."modules/addons/MyCompanyWeb/MyCompanyWeb/index.html", $file, FTP_BINARY);
                $upC = copy($tempFile, __DIR__ . "/MyCompanyWeb/index.html");
               
                
               
                
                if($upC)
                    unlink($tempFile);
                    
                if($upC && $upCFTP) {
                    echo "successfully uploaded index";
                   
                } else {

                    echo "There was a problem while uploading ";
                    print_r(error_get_last());
                   

                }
                
                
                
            } catch (Exception $e) {
                echo "There was a problem while uploading ".$e->getMessage();
               
                
            }
            
        }

        ftp_close($ftp_conn);
        exit;

    }

    /**update whmcs top header here**/


    if (isset($_REQUEST['topheaderajax'])) {
        $rest = substr(__DIR__,strpos(__DIR__,"public_html")+12);
        $folderwhm = substr($rest,0,strpos($rest,"modules"));
        $installPath="public_html/".$folderwhm;



        $fileheader = __DIR__ . "/MyCompanyWeb/outPut/topheader.tpl";
        $filefooter = __DIR__ . "/MyCompanyWeb/outPut/bottomfooter.tpl";
        $filemailer = __DIR__ . "/MyCompanyWeb/outPut/mailer.php";

        $_POST['htmlheader'] = str_replace(array('pointer-events: none'), 'pointer-events: auto', $_POST['htmlheader']);
        $_POST['htmlfooter'] = str_replace(array('pointer-events: none'), 'pointer-events: auto', $_POST['htmlfooter']);


        $_POST['htmlheader'] = MyCompanyWeb_print_processed_html(html_entity_decode($_POST['htmlheader']), $vars);
        $_POST['htmlfooter'] = MyCompanyWeb_print_processed_html(html_entity_decode($_POST['htmlfooter']), $vars);




        file_put_contents($fileheader,$_POST['htmlheader']);
        file_put_contents($filefooter, $_POST['htmlfooter'].html_entity_decode($_POST['htmlliveChat'],ENT_QUOTES, "UTF-8"));





        $whmcsTemplateName="MyCompanyWeb-MCW-template";
        $remote_file_header = $installPath . 'templates/'.$whmcsTemplateName.'/topheader.tpl';
        $remote_file_footer = $installPath . 'templates/'.$whmcsTemplateName.'/bottomfooter.tpl';
        $ftp_result = MyCompanyWeb_connectFtp($vars['hostname'], $vars['username'], $vars['password']);


        if ($ftp_result['status'] == 'error') {
            $message = $ftp_result['message'];
            echo "<div class='errorbox'><strong><span class='title'>Error</span></strong><br>".$message."<br></div>";
            exit;
        } else {
            $ftp_conn = $ftp_result['message'];
            try {
                $upW = ftp_put($ftp_conn, $remote_file_header, $fileheader, FTP_BINARY);
                $upW = ftp_put($ftp_conn, $remote_file_footer, $filefooter, FTP_BINARY);
                $upW = ftp_put($ftp_conn, $installPath . "mailer.php", $filemailer, FTP_BINARY);


            } catch (Exception $e) {
                $upW = 0;
            }
            if ($upW) {
                echo "successfully uploaded header";
            } else {

                echo "Header and footer upload error";

            }
        }

        ftp_close($ftp_conn);
        exit;
    }


}


function MyCompanyWeb_copyfolder($source, $destination)
{

    $directory = opendir($source);
    if (!file_exists($destination))
        mkdir($destination);
    while (($file = readdir($directory)) != false) {
        copy($source . '/' . $file, $destination . '/' . $file);
    }

}

function MyCompanyWeb_output($vars)
{

    $modulelink = $vars['modulelink'];

    $version = $vars['version'];


    if (isset($_REQUEST['savesource'])) {

        $pagecontent = html_entity_decode($_REQUEST['mytextarea'],ENT_QUOTES, "UTF-8");
        $indexfile = '../modules/addons/MyCompanyWeb/MyCompanyWeb/index.html';
        $saveChanges = file_put_contents($indexfile, html_entity_decode($pagecontent));

        if($saveChanges)
        {
            echo "<div class='successbox'><strong><span class='title'>Success</span></strong><br>Source Saved Successfully.<br></div>";


        }
        else
        {
            echo "<div class='errorbox'><strong><span class='title'>Error</span></strong><br>Error while Saving Source.<br></div>";
        }

        if(isset($_REQUEST['uploadsource']))
        {

           $res1 = MyCompanyWeb_fileExists($vars);

            if($res1=="REINSTALL")
            {
                MyCompanyWeb_prefix_update($vars,$pagecontent);
            }
            else{
                echo "<div class='errorbox'><strong><span class='title'>Error</span></strong><br>Please install the website and whmcs theme, before updating source changes<br></div>";

            }


        }

    }

    if(isset($_REQUEST['installhosting']))
    {


        global $tblproductgroups;
        global $tblproducts;
        global $tblpricing;



        $groups=array();

        foreach($tblproductgroups as $group)
        {


            $date_time=date('Y-m-d H:i:s');
            $groups[] = "('" . $group['id'] . "','" . $group['name'] . "','" . $group['headline'] . "', '" . $group['tagline'] . "', '" . $group['orderfrmtpl'] . "','" . $group['disabledgateways'] . "','" . $group['hidden'] . "','" . $group['order'] . "','" . $date_time . "','" . $date_time . "')";

        }
        $allQueries = "INSERT INTO  `tblproductgroups` (`id`,`name`,`headline`,`tagline`,`orderfrmtpl`,`disabledgateways`,`hidden`,`order`,`created_at`,`updated_at`) VALUES " . implode(',', $groups) . " ON DUPLICATE KEY UPDATE `hidden`=VALUES(`hidden`), `order`=VALUES(`order`),`created_at`=VALUES(`created_at`),`updated_at`=VALUES(`updated_at`)";

        $resultInsert=full_query($allQueries);
        if($resultInsert)
        {

            $products=array();
            foreach($tblproducts as $k=>$product)
            {

                $date_time=date('Y-m-d H:i:s');
                $products[] = "('" . $product['id'] . "','" . $product['type'] . "', '" . $product['gid'] . "', '" . mysql_real_escape_string( $product['name']) . "','" . mysql_real_escape_string ($product['description']) . "','" . $product['hidden'] . "','" . $product['showdomainoptions'] . "','" . $product['welcomeemail'] . "','" . $product['stockcontrol'] . "','" . $product['qty'] . "','" . $product['proratabilling'] . "','" . $product['proratadate'] . "','" . $product['proratachargenextmonth'] . "','" . $product['paytype'] . "','" . $product['allowqty'] . "','" . $product['subdomain'] . "','" . $product['autosetup'] . "','" . $product['servertype'] . "','" . $product['servergroup'] . "','" . $product['freedomain'] . "','" . $product['freedomainpaymentterms'] . "','" . $product['freedomaintlds'] . "','" . $product['recurringcycles'] . "','" . $product['autoterminatedays'] . "','" . $product['autoterminateemail'] . "','" . $product['configoptionsupgrade'] . "','" . $product['billingcycleupgrade'] . "','" . $product['upgradeemail'] . "','" . $product['overagesenabled'] . "','" . $product['overagesdisklimit'] . "','" . $product['overagesbwlimit'] . "','" . $product['overagesdiskprice'] . "','" . $product['overagesbwprice'] . "','" . $product['tax'] . "','" . $product['affiliateonetime'] . "','" . $product['affiliatepaytype'] . "','" . $product['affiliatepayamount'] . "','" . $product['order'] . "','" . $product['retired'] . "','" . $product['is_featured'] . "','" . $date_time . "','" . $date_time . "')";

            }



            $allQueriesP = "INSERT INTO  `tblproducts` (`id`,`type`,`gid`,`name`,`description`,`hidden`,`showdomainoptions`,
	    `welcomeemail`,`stockcontrol`,`qty`,`proratabilling`,`proratadate`,`proratachargenextmonth`,`paytype`,`allowqty`,`subdomain`,`autosetup`,
	    `servertype`,`servergroup`,`freedomain`,`freedomainpaymentterms`,`freedomaintlds`,`recurringcycles`,`autoterminatedays`,`autoterminateemail`,
	    `configoptionsupgrade`,`billingcycleupgrade`,`upgradeemail`,`overagesenabled`,
	    `overagesdisklimit`,`overagesbwlimit`,`overagesdiskprice`,`overagesbwprice`,`tax`,`affiliateonetime`,`affiliatepaytype`,`affiliatepayamount`,
	    `order`,`retired`,`is_featured`,`created_at`,`updated_at`) VALUES " . implode(',', $products) . " ON DUPLICATE KEY UPDATE `gid`=VALUES(`gid`), `hidden`=VALUES(`hidden`),`showdomainoptions`=VALUES(`showdomainoptions`),`welcomeemail`=VALUES(`welcomeemail`),`stockcontrol`=VALUES(`stockcontrol`),`qty`=VALUES(`qty`),`proratabilling`=VALUES(`proratabilling`),`proratadate`=VALUES(`proratadate`),`proratachargenextmonth`=VALUES(`proratachargenextmonth`),`allowqty`=VALUES(`allowqty`),`servergroup`=VALUES(`servergroup`),`recurringcycles`=VALUES(`recurringcycles`),`autoterminatedays`=VALUES(`autoterminatedays`),`autoterminateemail`=VALUES(`autoterminateemail`),`configoptionsupgrade`=VALUES(`configoptionsupgrade`),`upgradeemail`=VALUES(`upgradeemail`),`overagesenabled`=VALUES(`overagesenabled`),`overagesdisklimit`=VALUES(`overagesdisklimit`),`overagesbwlimit`=VALUES(`overagesbwlimit`),`overagesdiskprice`=VALUES(`overagesdiskprice`),`overagesbwprice`=VALUES(`overagesbwprice`),`tax`=VALUES(`tax`),`affiliateonetime`=VALUES(`affiliateonetime`),`affiliatepaytype`=VALUES(`affiliatepaytype`),`affiliatepayamount`=VALUES(`affiliatepayamount`),`order`=VALUES(`order`),`retired`=VALUES(`retired`),`created_at`=VALUES(`created_at`),`updated_at`=VALUES(`updated_at`)";

            $resultInsertproducts=full_query($allQueriesP);

            if($resultInsertproducts)
            {

                $ids=array();
                foreach($tblpricing as $price){

                    $ids[]=$price['id'];
                    $date_time=date('Y-m-d FH:i:s');
                    $prices[] = "('" . $price['id'] . "','" . $price['type'] . "','" . $price['currency'] . "', '" . $price['relid'] . "', '" . $price['msetupfee'] . "','" . $price['qsetupfee'] . "','" . $price['ssetupfee'] . "','" . $price['asetupfee'] . "','" . $price['bsetupfee'] . "','" . $price['tsetupfee'] . "','" . $price['monthly'] . "','" . $price['quarterly'] . "','" . $price['semiannually'] . "','" . $price['annually'] . "','" . $price['biennially	'] . "','" . $price['triennially'] . "')";
                }


                $delQuery="Delete from `tblpricing` where id IN (" . implode(',', $ids).")";


                $allQueriesPr = "INSERT INTO  `tblpricing` (`id`,`type`,`currency`,`relid`,`msetupfee`,`qsetupfee`,`ssetupfee`,`asetupfee`,`bsetupfee`,`tsetupfee`,
	           `monthly`,`quarterly`,`semiannually`,`annually`,`biennially`,`triennially`) VALUES " . implode(',', $prices);

                $delQ=full_query($delQuery);
                if($delQ)
                    $resultInsertPri=full_query($allQueriesPr);
                if($resultInsertPri)
                {
                    echo "<div class='successbox'><strong><span class='title'>Success</span></strong><br>Hosting Packages Successfully Installed.<br></div>";
                    //Done to check if the package was previously installed or not
                    file_put_contents(__DIR__ . "/MyCompanyWeb/outPut/packageinstalled.txt",1);

                }
                else
                {
                    echo "<div class='errorbox'><strong><span class='title'>Error</span></strong><br>Error while installing Hosting Packages. (Pricing)<br></div>";
                }
            }
            else
            {
                echo "<div class='errorbox'><strong><span class='title'>Error</span></strong><br>Error while installing Hosting Packages. (Products)<br></div>";
            }



        }
        else
        {
            echo "<div class='errorbox'><strong><span class='title'>Error</span></strong><br>Error while installing Hosting Packages. (Groups)<br></div>";
        }


    }

    if (isset($_POST['installtheme'])) {


        $zipfilePath = __DIR__ . "/MyCompanyWeb/uploadTheme";
        try {

            $source = "http://mycompanyweb.us/mcw.zip";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $source);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSLVERSION, 3);
            $data = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            $destination = $zipfilePath . "/uploadTheme.zip";
            $file = fopen($destination, "w+");
            fputs($file, $data);
            fclose($file);
            $downloadFile = 1;
        } catch (Exception $e) {
            $downloadFile = 0;
            print_r($e);
        }
        $up = 0;
        if ($downloadFile) {
            $zip = new ZipArchive;
            if ($zip->open($zipfilePath . "/uploadTheme.zip") === TRUE) {
                $zip->extractTo($zipfilePath);
                $zip->close();
                $local_dir = $zipfilePath . "/mcw/";
                $remote_dir = 'public_html/';
                $uploadmcwtemplate = MyCompanyWeb_moveFolder($vars['hostname'], $vars['username'], $vars['password'], $local_dir, $remote_dir);


                $whmcsTemplateName="MyCompanyWeb-MCW-template";
                $local_whmcs_template_path = __DIR__ . "/MyCompanyWeb/uploadTheme/".$whmcsTemplateName."/";



                $rest = substr(__DIR__,strpos(__DIR__,"public_html")+12);
                $folderwhm = substr($rest,0,strpos($rest,"modules"));

                $installPath="public_html/".$folderwhm;

                $intermediatehtmlfile=file_get_contents($zipfilePath . "/mcw/index.html");

                $remote_whmcs_template_path =$installPath ."templates/".$whmcsTemplateName."/";


                file_put_contents(__DIR__ . "/MyCompanyWeb/index.html",$intermediatehtmlfile);



                if (!file_exists($remote_whmcs_template_path))
                    mkdir($remote_whmcs_template_path);




                $uploadwmcstemplate = MyCompanyWeb_moveFolder($vars['hostname'], $vars['username'], $vars['password'], $local_whmcs_template_path, $remote_whmcs_template_path);


                if ($uploadwmcstemplate) {
                    $up = 1;
                }

                $uploadfunction = MyCompanyWeb_reinstallFreshOnAddon();

                if ($uploadmcwtemplate) {
                    $up = 1;
                }

                if ($up) {

                    try {
                        $updatedUserCount = Capsule::table('tblconfiguration')
                            ->where('setting', 'Template')
                            ->update(
                                [
                                    'value' => 'MyCompanyWeb-MCW-template',
                                ]
                            );




                        echo "<div class='successbox'><strong><span class='title'>Success</span></strong><br>Successfully Installed MCW WHMCS theme and template.<br></div>";
                        $pagecontent=file_get_contents(__DIR__ . "/MyCompanyWeb/index.html");

                        MyCompanyWeb_prefix_update($vars,$pagecontent);
                    } catch (\Exception $e) {
                        echo "<div class='errorbox'><strong><span class='title'>Error</span></strong><br> I couldn't update client names ".$e->getMessage()."<br></div>";
                    }


                } else {
                    echo "<div class='errorbox'><strong><span class='title'>Error</span></strong><br>An Error Occured while uploading files.<br></div>";
                }

            } else {
                echo "<div class='errorbox'><strong><span class='title'>Error, while extracting  zip file</span></strong><br>An Error Occured.<br></div>";
            }

            //remove zip and the folder after installing
            if (file_exists($zipfilePath . "/uploadTheme.zip"))
                unlink($zipfilePath . "/uploadTheme.zip");
            if (file_exists($zipfilePath . "/mcw"))
                system('/bin/rm -rf ' . escapeshellarg($zipfilePath . "/mcw"));
        } else {
            echo "<div class='errorbox'><strong><span class='title'>Error,while downloading zip file</span></strong><br>An Error Occured.<br></div>";
        }


    }




    global $CONFIG;


    $indexfile = '../modules/addons/MyCompanyWeb/MyCompanyWeb/index.html';
    $current = MyCompanyWeb_print_processed_html(file_get_contents($indexfile, FILE_USE_INCLUDE_PATH), $vars);


    $fput = file_put_contents($indexfile, $current);
    if ($fput) {


        $url = $CONFIG['SystemURL'] . "/index.php?m=MyCompanyWeb";
        $res1 = MyCompanyWeb_fileExists($vars);


        if ($res1)
            $install = "REINSTALL";
        else
            $install = "INSTALL";

        if ($install == "REINSTALL")
            $htmlval=<<< EOF
             <script>
	function confirmBox(type)
	{
	if(type==1)
	{
	if(confirm("Reinstalling MCW from original source files. All current changes will be lost. Press OK to confirm."))
	{
	  $("#divLoading").show();
	  $(".messagetext").html("Reinstalling MCW from original source files, Please wait...");
	   return true;
	}
	  else
	   return false;
	}
       if(type==2)
	{
	if(confirm("Reinstalling packaging will overwrite any current changes  . All current changes will be lost. Press OK to confirm."))
	{
	$("#divLoading").show();
	$(".messagetext").html("Reinstalling packaging, Please wait...");
	   return true;
	   }
	  else
	   return false;
	}
        if(type==3)
	{

          if($("#uploadsource").is(":checked"))
          {
	  if(confirm("Your website's index.html, whmcs member area header/footer will be updated. Press OK to confirm."))
	  
	  {
	  $("#divLoading").show();
	  $(".messagetext").html("Updating index.html and whmcs member area header/footer, Please wait...");
	    return true;
	    }
	  else
	    return false;
          }
	}
        
	}
	
	$(document).ready(function(){
	
	$("#sourcebtn").click(function(e){
	e.preventDefault();
	$(".textareadiv").toggle();
	});
	
	setTimeout(function() {
        $(".successbox").hide("blind", {}, 500)
        }, 5000);
        
        setTimeout(function() {
        $(".errorbox").hide("blind", {}, 500)
        }, 5000);
        
	});
	
	
	
	</script>
EOF;
        else
            $htmlval=<<< EOF
             <script>
	function confirmBox(type)
	{
	if(type==1)
	{
	if(confirm("Installing MCW from original source files. Press OK to confirm."))
	{
	  $("#divLoading").show();
	  $(".messagetext").html("Installing MCW from original source files, Please wait...");
	   return true;
	}
	  else
	   return false;
	}
       if(type==2)
	{
	if(confirm("Installing packaging. Press OK to confirm."))
	{
	$("#divLoading").show();
	$(".messagetext").html("Installing packaging, Please wait...");
	   return true;
	   }
	  else
	   return false;
	}
        if(type==3)
	{

          if($("#uploadsource").is(":checked"))
          {
	  if(confirm("Your website's index.html, whmcs member area header/footer will be updated. Press OK to confirm."))
	  
	  {
	  $("#divLoading").show();
	  $(".messagetext").html("Updating index.html and whmcs member area header/footer, Please wait...");
	    return true;
	    }
	  else
	    return false;
          }
	}
        
	}
	
	$(document).ready(function(){
	
	$("#sourcebtn").click(function(e){
	e.preventDefault();
	$(".textareadiv").toggle();
	});
	
	setTimeout(function() {
        $(".successbox").hide("blind", {}, 500)
        }, 5000);
        
        setTimeout(function() {
        $(".errorbox").hide("blind", {}, 500)
        }, 5000);
        
	});
	
	
	
	</script>
EOF;


        echo $htmlval;
        $page = file_get_contents($indexfile);

        $loader='../modules/addons/MyCompanyWeb/MyCompanyWeb/img/mcwloading.gif';

        $installstatus=file_get_contents(__DIR__ . "/MyCompanyWeb/outPut/packageinstalled.txt");
        if($installstatus==0)
            $installpackages="Install Hosting Packages";
        else
            $installpackages="Reinstall Hosting Packages";
        echo '<div id="divLoading" style="display:none;margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: #fff; z-index: 30001; opacity: 0.8;"><p style="font-size:20px;position: absolute; left: 50%; top: 50%; margin-left: -32px; margin-top: -32px;"><span class="messagetext"></span><img style="margin-left:10px;width:60px;" src="'.$loader.'"></p></div>';

        echo "<ul class='nav nav-tabs admin-tabs' role='tablist'>
<li ><a class='tab-top' href='#tab0' role='tab' data-toggle='tab' id='tabLink0' data-tab-id='0' aria-expanded='true'>Hosting Packages</a></li>
<li ><a class='tab-top' href='#tab1' role='tab' data-toggle='tab' id='tabLink1' data-tab-id='1' aria-expanded='true'>Source</a></li>
<li class='active'><a class='tab-top' href='#tab2' role='tab' data-toggle='tab' id='tabLink2' data-tab-id='2' aria-expanded='true'>Design</a></li>
</ul><div class='tab-content admin-tabs'><div  class='tab-pane' id='tab0'><form method='post' action='" . $modulelink . "' onSubmit='return confirmBox(2)'><h1>Install Hosting Packages</h1><input type='submit' class='btn btn-success' name='installhosting' type='submit' value='".$installpackages."'></form></div><div  class='tab-pane' id='tab1'><form method='post' action='" . $modulelink . "' onSubmit='return confirmBox(3)'><textarea name='mytextarea' id='mytextarea' style='width:100%;height: 800px;padding:20px;'>$page</textarea><label>Note: We recommend code editing for advanced users only.</label><div class='row' style='text-align: right;padding: 20px;width: 89%;'><input style='cursor: pointer;' type='checkbox'  id='uploadsource'  name='uploadsource'><label  style='    padding: 10px;cursor: pointer;'for='uploadsource'>Publish changes to website</label>
    <input class='btn btn-success' name='savesource' type='submit' value='Save Source Changers' style='margin-bottom: 20px;margin-top: 20px'></div></form><form method='post' action='" . $modulelink . "' onSubmit='return confirmBox(1)' style='float: right; width: 15%; margin-top: -74px;'><input style='margin-left: 20px;'class='btn btn-success' name='installtheme' type='submit' value='Reset Source Code' ></form></div><div  class='tab-pane active' id='tab2'><form method='post' action='" . $modulelink . "' onSubmit='return confirmBox(1)'><div class='topOverButtons' style='float:right;margin-bottom:20px;'><input style='margin-left: 20px;'class='btn btn-success' name='installtheme' type='submit' value='" . $install . "' ></div></form> <iframe id='iframe'style='width: 100%;height: 800px;' src='$indexfile?$url'></iframe><div></div>";




    }

}

function MyCompanyWeb_prefix_update($vars,$pagecontent)
{
    $file = __DIR__ . "/MyCompanyWeb/index.html";
    $tempFile=__DIR__ . "/MyCompanyWeb/outPut/indextemp.html";
    file_put_contents($tempFile, $pagecontent);

    $out = delete_all_between("temporarystartlinks", "temporaryendlinks", $pagecontent);

    $out = str_replace(array('pointer-events: none'), 'pointer-events: auto', $out);
    $processed_page = MyCompanyWeb_print_processed_html($out, $vars);
    file_put_contents($file,$processed_page);
    $remote_file = 'public_html/index.html';

    /****** For Header And Footer******/
    $headerpart=get_all_between("<!-- top menu - start -->","<!-- top menu - end -->",$processed_page);
    $footerpart='<footer class="footer">'.get_all_between("<!--footer start here-->","<!--footer end here-->",$processed_page).'</footer>';
    $liveChatpart=get_all_between("<!--Start LiveChat-->","<!--End LiveChat-->",$processed_page);
    $headerpart=html_entity_decode($headerpart,ENT_QUOTES, "UTF-8");
    $footerpart=html_entity_decode($footerpart,ENT_QUOTES, "UTF-8");
    $liveChatpart=html_entity_decode($liveChatpart,ENT_QUOTES, "UTF-8");
    $rest = substr(__DIR__,strpos(__DIR__,"public_html")+12);
    $folderwhm = substr($rest,0,strpos($rest,"modules"));
    $installPath="public_html/".$folderwhm;

    $fileheader = __DIR__ . "/MyCompanyWeb/outPut/topheader.tpl";
    $filefooter = __DIR__ . "/MyCompanyWeb/outPut/bottomfooter.tpl";
    $filemailer = __DIR__ . "/MyCompanyWeb/outPut/mailer.php";
    file_put_contents($fileheader,$headerpart);
    file_put_contents($filefooter, $footerpart.$liveChatpart);

    $whmcsTemplateName="MyCompanyWeb-MCW-template";
    $remote_file_header = $installPath . 'templates/'.$whmcsTemplateName.'/topheader.tpl';
    $remote_file_footer = $installPath . 'templates/'.$whmcsTemplateName.'/bottomfooter.tpl';




    $ftp_result = MyCompanyWeb_connectFtp($vars['hostname'], $vars['username'], $vars['password']);
    $upC=0;
    if ($ftp_result['status'] == 'error') {
        $message = $ftp_result['message'];
        echo "<div class='errorbox'><strong><span class='title'>Error</span></strong><br>".$message."<br></div>";

    } else {
        $ftp_conn = $ftp_result['message'];
        try {
            $upC = ftp_put($ftp_conn, $remote_file, $file, FTP_BINARY);
            $upC = copy($tempFile, __DIR__ . "/MyCompanyWeb/index.html");
            if($upC)
                unlink($tempFile);
        } catch (Exception $e) {

            $upC = 0;
        }
        if ($upC) {

            echo "<div class='successbox'><strong><span class='title'>Success</span></strong><br>Successfully uploaded index.html page.<br></div>";
        } else {


            echo "<div class='errorbox'><strong><span class='title'>Error</span></strong><br>There was a problem while uploading index file chnages.<br></div>";

        }



        try {
            $upW = ftp_put($ftp_conn, $remote_file_header, $fileheader, FTP_BINARY);
            $upW = ftp_put($ftp_conn, $remote_file_footer, $filefooter, FTP_BINARY);
            $upW = ftp_put($ftp_conn, $installPath . "mailer.php", $filemailer, FTP_BINARY);


        } catch (Exception $e) {
            $upW = 0;
        }
        if ($upW) {
            echo "<div class='successbox'><strong><span class='title'>Success</span></strong><br>Successfully uploaded header/footer in MCW WHMCS member area template.<br></div>";
        } else {

            echo "<div class='errorbox'><strong><span class='title'>Error</span></strong><br>Header and footer upload error<br></div>";

        }




    }

    ftp_close($ftp_conn);
}

function MyCompanyWeb_print_processed_html($string, $vars)
{


       $rest = substr(__DIR__,strpos(__DIR__,"public_html")+12);
        $whmcsfolder= substr($rest,0,strpos($rest,"modules"));
      
        

    $hostname = trim($vars['hostname']);
    if (strlen(trim($whmcsfolder)) == 0)
       $whmcshost = trim($vars['hostname']);
    else
        $whmcshost = trim($vars['hostname']) . "/" . $whmcsfolder;

$whmcshost=rtrim($whmcshost,"/");
    $search = Array("members.replace-with-yourdomainname.com","replace-with-yourdomainname.com","replace-with-your-domain.com");
    $replace = Array($whmcshost,$hostname,$hostname);
    $processed_string = str_replace($search, $replace, $string);

    return $processed_string;
}


function MyCompanyWeb_fileExists($vars)
{
    $rsult = false;
    $ftp_result = MyCompanyWeb_connectFtp($vars['hostname'], $vars['username'], $vars['password']);
 
    if ($ftp_result['status'] == 'error') {
        $message = $ftp_result['message'];
        echo $message;
        exit;
    } else {
        
        $ftp_conn = $ftp_result['message'];
        $contents = ftp_nlist($ftp_conn, "public_html");
        if (is_array($contents)) {
            if (in_array("mailer.php", $contents)) {
                $rsult = true;
            }
        }
        
    }

    return $rsult;
}


function MyCompanyWeb_sidebar($vars)
{


}

function MyCompanyWeb_reinstallFreshOnAddon()
{

    $installPath=__DIR__."/../../../";
    //$res = copy(__DIR__ . "/MyCompanyWeb/outPut/FreshInstallFiles/index.html", __DIR__ . "/MyCompanyWeb/index.html");
    $fileheaderFresh = __DIR__ . "/MyCompanyWeb/outPut/FreshInstallFiles/topheader.tpl";
    $filefooterFresh = __DIR__ . "/MyCompanyWeb/outPut/FreshInstallFiles/bottomfooter.tpl";
    $whmcsTemplateName="MyCompanyWeb-MCW-template";
    $res = copy($fileheaderFresh, $installPath . "templates/".$whmcsTemplateName."/topheader.tpl");
    $res = copy($filefooterFresh, $installPath . "templates/".$whmcsTemplateName."/bottomfooter.tpl");
    if (!$res) {
        echo "<div class='errorbox'><strong><span class='title'>Error</span></strong><br>Error Installing Fresh files.<br></div>";
    }
    return $res;
}

function MyCompanyWeb_connectFtp($serverurl, $username, $password)
{
    $ftp_conn = ftp_connect($serverurl); //or die("Could not connect to $ftp_server");
    $response = array();
    if (!$ftp_conn) { //check if connection is not created
        $response['status'] = 'error';
        $response['message'] = 'Invalid Install Domain';
    } else {
        $login = ftp_login($ftp_conn, $username, $password);
        if (!$login) {
            $response['status'] = 'error';
            $response['message'] = 'error: Invalid cPanel username or password';
        } else {
            $response['status'] = 'success';
            $response['message'] = $ftp_conn;
        }
    }
    /*if(!ftp_pasv($ftp_conn, true))
    {
        if($response['status']!='error')
        {
            $response['status']='error';
            $response['message']='Please make sure your input is correct.';
        }
    }*/
    return $response;
}


