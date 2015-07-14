<?php
echo "ddssd";
include('connection.php');
include("xmlapi.php");
if(isset($_GET['add']))
{
    if( isset($_POST))
    {
        $username = $_POST['username'];
        $un = $username.'@valleyobcare.com';
        $qry_check= "select * from go_users where username='$un'  and enabled=1";
        $res = mysqli_query($con,$qry_check);
        $row = mysqli_fetch_array($res);
        $qry_check2= "select * from em_accounts where username='$un'";
        $res2 = mysqli_query($con,$qry_check2);
        $qry_check3= "select * from em_aliases where email='$un'";
        $res3 = mysqli_query($con,$qry_check3);
        if((mysqli_num_rows($res)>0) || (mysqli_num_rows($res2)>0) || (mysqli_num_rows($res3)>0) )
        {
            echo "error";
        }
        else{
            $p = $_POST['password'];
            $product_name= 'Group-Office';
            $digest = md5($username.':'.$product_name.':'.$p);
            $user_id = $_POST['user_id'];
            $admin_id = $_POST['admin_id'];
            $data = $_POST;
            $role = $_GET['admin'];
            $data['email']= $un;
            $data['role']= $role;
            $data['username'] = $un;
            $data['password'] = md5($p);
            $data['digest'] = $digest;
            $data['enabled'] = 1;
            $data['acl_id']= 32;
            $data['date_format']='dmY';
            $data['date_separator'] = '/';
            $data['time_format'] = 'h:i a';
            $data['thousands_separator'] = ',';
            $data['decimal_separator'] = '.';
            $data['currency'] = '$';
            $data['logins']=10;
            $data['lastlogin'] = '1416999468';
            $data['ctime'] = '1416209894';
            $data['max_rows_list'] = 30;
            $data['timezone'] = 'Asia/Kolkata';
            $data['start_module'] = 'summary';
            $data['language'] = 'en';
            $data['theme'] = 'Group-Office';
            $data['first_weekday'] = 1;
            $data['sort_name'] = 'last_name';
            $data['mtime'] = '1418965894';
            $data['muser_id'] = 1;
            $data['mute_sound'] = 0;
            $data['mute_reminder_sound'] = 0;
            $data['mute_new_mail_sound'] = 0;
            $data['show_smilies'] = 1;
            $data['auto_punctuation'] = 0;
            $data['list_separator'] = ';';
            $data['text_separator'] = '"';
            $data['files_folder_id'] = 0;
            $data['disk_quota'] = 1000;
            $data['disk_usage'] = 0;
            $data['mail_reminders'] = 0;
            $data['popup_reminders'] = 0;
            $data['password_type'] = 'crypt';
            $data['holidayset'] = 0;
            $data['sort_email_addresses_by_time'] = 0;
            $data['no_reminders'] = 0;
            //$data['password']= 'jaimatadi';
            unset($data['user_id']);
            unset($data['admin_id']);
            $res = insert($data,'go_users');
            if($res){
                $qry = "insert into go_users_groups (group_id,user_id) VALUES ('1',$res)"; 
                $res1= mysqli_query($con,$qry);
                
                if($res1 && $_GET['admin']=='admin')
                {
                    //header("location:superadmin.php?added=1");
                    echo "success";
                }elseif($res1){
                    $qry2 = "insert into go_users_admin_groups (admin_id,user_id) VALUES ('$admin_id','$res')";
                    $res2= mysqli_query($con,$qry2);
                    //header("location:admin.php?added=1&uid=".$user_id);
                    echo "success";
                }
            }
            //code for creating e-mail id for users
            
            // Default whm/cpanel account info
            $ip = "hnzk-hlx6.accessdomain.com";        // should be WHM ip address
            $account = "valleyobcare";        // cpanel user account name
            $passwd ="faisal@2563";       // cpanel user password
            $port = 2083;                 // cpanel secure authentication port unsecure port# 2082
            $email_domain = 'valleyobcare.com'; // email domain (usually same as cPanel domain)
            $email_quota = 250; // default amount of space in megabytes
            /*************End of Setting***********************/
            function getVar($name, $def = '') {
                if (isset($_REQUEST[$name]))
                    return $_REQUEST[$name];
                else
                    return $def;
            }
            // check if overrides passed
            $user_name = $_POST['username'];
            //$email_user = $user_name.'@valleyobcare.com';
            $email_user = $user_name;
            $random = mt_rand(100000,999999);
            $email_pass = $user_name.$random;
            $email_domain = getVar('domain', $email_domain);
            $email_quota = getVar('quota', $email_quota);
            
            $msg = '';
            if (!empty($email_user))
            while(true) {
                $xmlapi = new xmlapi($ip);

                $xmlapi->set_port($port);  //set port number. cpanel client class allow you to access WHM as well using WHM port.

                $xmlapi->password_auth($account, $passwd);   // authorization with password. not as secure as hash.

                // cpanel email addpop function Parameters
                $call = array("domain"=>"$email_domain", "email"=>"$email_user", "password"=>"$email_pass", "quota"=>"$email_quota");

                $xmlapi->set_debug(0);      //output to error file  set to 1 to see error_log.

                $result = $xmlapi->api2_query($account, "Email", "addpop", $call ); // making call to cpanel api

                if ($result->data->result == 1){
                    $msg = $email_user.'@'.$email_domain.' account created';
                } else {
                    $msg = $result->data->reason;
                    break;
                }
                break;
            }
            
            //code for creating e-mail id for users
            $acl_id = '';
            $type = 'NULL';
            $imap_host = 'hnzk-hlx6.accessdomain.com';
            $port = 993;
            $use_ssl = 1;
            $novalidate_cert = 0;
            $username = $user_name.'@valleyobcare.com';
            $email = $user_name.'@valleyobcare.com';
            $password = $user_name.$random;
            $smtp_username = $user_name.'@valleyobcare.com';
            $smtp_password = $user_name.$random;
            $mbroot = '';
            $sent = 'INBOX.Sent';
            $drafts = 'INBOX.Drafts';
            $trash = 'INBOX.Trash';
            $spam = 'Spam';
            $smtp_host = 'hnzk-hlx6.accessdomain.com';
            $smtp_port = 465;
            $smtp_encryption = 'ssl';
            $password_encrypted = 2;
            $ignore_sent_folder = 0;
            $sieve_port = 2000;
            $sieve_usetls = 1;
            $check_mailboxes = 'INBOX';
            $do_not_mark_as_read = 0;
            $name = $_POST['first_name'].','.$_POST['last_name'];
            $mtime = time();
            $description = 'em_accounts.acl_id';
            $query_select = "select max(id) from go_acl_items";
            $query_select_res = mysqli_query($con,$query_select);
            $row_id = mysqli_fetch_array($query_select_res);
            $acl_id = $row_id['max(id)'];
            $query_ins1 = "insert into go_acl_items set user_id='".$res."', description='".$description."',mtime='".$mtime."'";
            $query_ins1_res = mysqli_query($con, $query_ins1);
            if($role == 'admin') {
                $query_ins2 = "insert into go_acl set acl_id='".($acl_id+1)."', user_id=1,group_id=1,level=50";
                $query_ins2_res = mysqli_query($con, $query_ins2);
            }
            else {
                $query_ins2 = "insert into go_acl set acl_id='".($acl_id+1)."', user_id=0,group_id=1,level=50";
                $query_ins2_res = mysqli_query($con, $query_ins2);
            }
            
            $query_ins3 = "insert into go_acl set acl_id='".($acl_id+1)."', user_id='".$res."',group_id=0,level=50";
            $query_ins3_res = mysqli_query($con, $query_ins3);
            $query_ins4 = "insert into em_accounts set user_id='".$res."', acl_id='".($acl_id+1)."',type='".$type."',host='".$imap_host."',port='".$port."',use_ssl='".$use_ssl."', novalidate_cert='".$novalidate_cert."',username='".$username."',password='".$password."',mbroot='".$mbroot."',sent='".$sent."', drafts='".$drafts."',trash='".$trash."',spam='".$spam."',smtp_host='".$smtp_host."',smtp_port='".$smtp_port."',smtp_encryption='".$smtp_encryption."',smtp_username='".$smtp_username."',smtp_password='".$smtp_password."',password_encrypted='".$password_encrypted."',ignore_sent_folder='".$ignore_sent_folder."',sieve_port='".$sieve_port."',sieve_usetls='".$sieve_usetls."',check_mailboxes='".$check_mailboxes."',do_not_mark_as_read='".$do_not_mark_as_read."'";
            $query_ins4_res = mysqli_query($con, $query_ins4);
            $account_id = mysqli_insert_id($con);
            $query_ins5 = "insert into em_aliases set  `account_id`='".$account_id."', `name`='".$name."',`email`='".$email."',`signature`='',`default`=1";
            $query_ins5_res = mysqli_query($con, $query_ins5);
            $a1 = '$label1';$a2 = '$label2';$a3 = '$label3';$a4 = '$label4';$a5 = '$label5';
            $query_ins6 = "insert into em_labels set  `name`='Label 1',`flag`='".$a1."',`color`='7A7AFF',`user_id`='".$res."',`account_id`='".$account_id."',`default`=1";
            $query_ins6_res = mysqli_query($con, $query_ins6);
            $query_ins7 = "insert into em_labels set  `name`='Label 2',`flag`='".$a2."',`color`='59BD59',`user_id`='".$res."',`account_id`='".$account_id."',`default`=1";
            $query_ins7_res = mysqli_query($con, $query_ins7);
            $query_ins8 = "insert into em_labels set  `name`='Label 3',`flag`='".$a3."',`color`='FFBD59',`user_id`='".$res."',`account_id`='".$account_id."',`default`=1";
            $query_ins8_res = mysqli_query($con, $query_ins8);
            $query_ins9 = "insert into em_labels set  `name`='Label 4',`flag`='".$a4."',`color`='FF5959',`user_id`='".$res."',`account_id`='".$account_id."',`default`=1";
            $query_ins9_res = mysqli_query($con, $query_ins9);
            $query_ins10 = "insert into em_labels set  `name`='Label 5',`flag`='".$a5."',`color`='BD7ABD',`user_id`='".$res."',`account_id`='".$account_id."',`default`=1";
            $query_ins10_res = mysqli_query($con, $query_ins10);
        }
    }
}


if(isset($_GET['ajax']))
{
    $qry = "select * from go_users where id!=1 and role='admin' ORDER BY enabled DESC";
    $res = mysqli_query($con,$qry);
    while($row = mysqli_fetch_array($res))
    {
        $data[] = $row; 
    }        
    //print_r($data);
    echo json_encode($data);

}

if(isset($_GET['ajax1']))
{
    $admin_id = $_GET['admin_id'];
    $qry1 = "select * from go_users_admin_groups where admin_id=".$admin_id;
    $res1 = mysqli_query($con,$qry1);
    while($row1 = mysqli_fetch_array($res1))
    {    
        $qry2 = "select * from go_users where id='".$row1['user_id']."' and role='user' ORDER BY enabled DESC";
        $res2 = mysqli_query($con,$qry2);
        while($row = mysqli_fetch_array($res2))
        {
        $data[] = $row;
        }        
    }
    echo json_encode($data);
}

if(isset($_GET['permi']))
{
    if(isset($_POST))
    {
       // extract($_POST);
        $checkeddata = $_POST['checkdata'];
        $row = (explode("&",$checkeddata));
        $arr='';
        $array1 ='';
        foreach($row as $key => $value)
        {
            $arr = (explode('=',$value));
            //$str .=  $key."='".$value."',";
            $result .=$arr[0]."='".$arr[1]."',";
        }
        $result = rtrim($result, ',');
        //echo $result;
        $userid = $_POST['usid'];
        $checkeddata = rtrim($checkeddata, ",");
        $query  =   "select * from go_permission where user_id=$userid";
        $res = mysqli_query($con, $query);
        $num_rows = mysqli_num_rows($res);
        $row = mysqli_fetch_assoc($res);
        if($num_rows==0)
        {    
             $insert = "INSERT INTO go_permission set $result,user_id='$userid'";
             $res = mysqli_query($con,$insert);
             echo "success";
        }
        else
        {
             $qry = "UPDATE  go_permission set $result where user_id=$userid";
             $res = mysqli_query($con,$qry);
             echo "success";

        }
         
    }
}


if(isset($_GET['manage']))
{
    if( isset($_POST))
    {
    $data = $_POST;
    $id = $_POST['users_id'];
    $username = $_POST['username'];
    $un = $username.'@valleyobcare.com';
    $qry_check= "select * from go_users where username='$un'  and enabled=1 and id !='$id'";
    $res = mysqli_query($con,$qry_check);
    $row = mysqli_fetch_array($res);
    if(mysqli_num_rows($res)>0)
    {
        echo "error";
    }
    else
        {
            $id = $_POST['users_id'];
            $p = $_POST['password'];
            $product_name= 'Group-Office';
            $user_record_id = $_POST['user_record_id'];
            if($p == "")
            {  unset($data['password']);
            }
            else{
               $data['password'] = md5($p);
               $digest = md5($username.':'.$product_name.':'.$p);
               $data['digest'] = $digest;
            }
            $data['username'] = $un;
            //$data['enabled'] = 1;
            $data['acl_id']= 32;
            $data['date_format']='dmY';
            $data['date_separator'] = '/';
            $data['time_format'] = 'h:i a';
            $data['thousands_separator'] = ',';
            $data['decimal_separator'] = '.';
            $data['currency'] = '$';
            $data['logins']=10;
            $data['lastlogin'] = '1416999468';
            $data['ctime'] = '1416209894';
            $data['max_rows_list'] = 30;
            $data['timezone'] = 'Asia/Kolkata';
            $data['start_module'] = 'summary';
            $data['language'] = 'en';
            $data['theme'] = 'Group-Office';
            $data['first_weekday'] = 1;
            $data['sort_name'] = 'last_name';
            $data['mtime'] = '1418965894';
            $data['muser_id'] = 1;
            $data['mute_sound'] = 0;
            $data['mute_reminder_sound'] = 0;
            $data['mute_new_mail_sound'] = 0;
            $data['show_smilies'] = 1;
            $data['auto_punctuation'] = 0;
            $data['list_separator'] = ';';
            $data['text_separator'] = '"';
            $data['files_folder_id'] = 0;
            $data['disk_quota'] = 1000;
            $data['disk_usage'] = 0;
            $data['mail_reminders'] = 0;
            $data['popup_reminders'] = 0;
            $data['password_type'] = 'crypt';
            $data['holidayset'] = 0;
            $data['sort_email_addresses_by_time'] = 0;
            $data['no_reminders'] = 0;
            unset($data['user_record_id']);
            unset($data['users_id']);
            $res = update($data, 'go_users');
            if($res===true && $_GET['admin']=='admin')
            {
                //header("location:superadmin.php?success=1");
                echo "success";
            }elseif($res===true){
                //header("location:admin.php?success=1&uid=".$user_record_id);
                echo "success";
            }
            else
            {
               echo $res;
            }
        }
    }
} 
 
 if(isset($_GET['deact']))
 {
     $id =  $_POST['id'];
     $qry = "UPDATE go_users set enabled=0 where id=$id";
     $res = mysqli_query($con,$qry);
     if($res)
     {
         echo "success";
     }    
 }    
 
 if(isset($_GET['act']))
 {
     $id =  $_POST['id'];
     $qry = "UPDATE go_users set enabled=1 where id=$id";
     $res = mysqli_query($con,$qry);
     if($res)
     {
         echo "success";
     }    
 }    
  
if(isset($_GET['del']))
{
    $id = $_POST['id'];
    $query_sel = "select * from go_users where id=".$id;
    $query_sel_res = mysqli_query($con, $query_sel);
    $query_sel_row = mysqli_fetch_array($query_sel_res);
    $email_account = $query_sel_row['username'];
    $role = $query_sel_row['role'];
    
    $qry = "Delete from go_users where id=$id";
    $res = mysqli_query($con,$qry);
    $qry_em_accounts= "select * from em_accounts where user_id=".$id;
    $qry_em_accounts_res = mysqli_query($con,$qry_em_accounts);
    $qry_em_accounts_res_row = mysqli_fetch_array($qry_em_accounts_res);
    $account_id = $qry_em_accounts_res_row['id'];
    $qry_em_aliases = "Delete from em_aliases where account_id=".$account_id;
    $qry_em_aliases_res = mysqli_query($con,$qry_em_aliases);
    $qry1 = "Delete from em_accounts where user_id=$id";
    $res1 = mysqli_query($con,$qry1);
    $qry2 = "Delete from ab_contacts where user_id=$id";
    $res2 = mysqli_query($con,$qry2);
    $qry_fs_folders = "Delete from fs_folders where user_id=$id";
    $qry_fs_folders_res = mysqli_query($con,$qry_fs_folders);
    $query_cal_calendars = "Delete from cal_calendars where user_id=$id";
    $query_cal_calendars_res = mysqli_query($con,$query_cal_calendars);
    //code for delete email account in cpanel
    $ip = "hnzk-hlx6.accessdomain.com";          // should be WHM ip address
    $account = "valleyobcare";        // cpanel user account name
    $passwd ="faisal@2563";        // cpanel user password
    $port =2083;                 // cpanel secure authentication port unsecure port# 2082
    $email_domain = 'valleyobcare.com'; // email domain (usually same as cPanel domain)
    $email_quota = 250;
    function getVar($name, $def = '') {
    if (isset($_REQUEST[$name]))
      return $_REQUEST[$name];
    else 
      return $def;
    }
    $email_user = $email_account;
    $email_domain = getVar('domain', $email_domain);
    $email_quota = getVar('quota', $email_quota);
    $xmlapi = new xmlapi($ip);
    $xmlapi->set_port($port);  //set port number. cpanel client class allow you to access WHM as well using WHM port.
    $xmlapi->password_auth($account, $passwd);
    $del = array( 'email' => "$email_user", "domain" => "$email_domain");
    $result = $xmlapi->api2_query('$account','Email','delpop',$del);
    echo "success";

    if($role == 'admin'){
        $id = $_POST['id'];
        $users_id = "select * from go_users_admin_groups where admin_id=".$id;
        $users_id_res = mysqli_query($con, $users_id);
        while($users_id_rows = mysqli_fetch_array($users_id_res)){
            $id = $users_id_rows['user_id'];
            $query_sel = "select * from go_users where id=".$id;
            $query_sel_res = mysqli_query($con, $query_sel);
            $query_sel_row = mysqli_fetch_array($query_sel_res);
            $email_account = $query_sel_row['username'];
            $qry = "Delete from go_users where id=".$id;
            $res = mysqli_query($con,$qry);
            $qry_em_accounts= "select * from em_accounts where user_id=".$id;
            $qry_em_accounts_res = mysqli_query($con,$qry_em_accounts);
            $qry_em_accounts_res_row = mysqli_fetch_array($qry_em_accounts_res);
            $account_id = $qry_em_accounts_res_row['id'];
            $qry_em_aliases = "Delete from em_aliases where account_id=".$account_id;
            $qry_em_aliases_res = mysqli_query($con,$qry_em_aliases);
            $qry1 = "Delete from em_accounts where user_id=".$id;
            $res1 = mysqli_query($con,$qry1);
            $qry2 = "Delete from ab_contacts where user_id=".$id;
            $res2 = mysqli_query($con,$qry2);
            $qry_fs_folders = "Delete from fs_folders where user_id=".$id;
            $qry_fs_folders_res = mysqli_query($con,$qry_fs_folders);
            $query_cal_calendars = "Delete from cal_calendars where user_id=$id";
            $query_cal_calendars_res = mysqli_query($con,$query_cal_calendars);

            //code for delete email account in cpanel
            $ip = "hnzk-hlx6.accessdomain.com";          // should be WHM ip address
            $account = "valleyobcare";        // cpanel user account name
            $passwd ="faisal@2563";        // cpanel user password
            $port =2083;                 // cpanel secure authentication port unsecure port# 2082
            $email_domain = 'valleyobcare.com'; // email domain (usually same as cPanel domain)
            $email_quota = 250;
            $email_domain = getVar('domain', $email_domain);
            $email_quota = getVar('quota', $email_quota);
            $email_user = $email_account;
            $xmlapi = new xmlapi($ip);
            $xmlapi->set_port($port);  //set port number. cpanel client class allow you to access WHM as well using WHM port.
            $xmlapi->password_auth($account, $passwd);
            $del = array( 'email' => "$email_user", "domain" => "$email_domain");
            $result = $xmlapi->api2_query('$account','Email','delpop',$del);
        }
    }
}

if(isset($_GET['search']))
{
    $str = $_POST['data'];
    $qry = "select * from go_users where id!=1 and role='admin' and (first_name LIKE '%{$str}%' or dob LIKE '%{$str}%' or username LIKE '%{$str}%' or email LIKE '%{$str}%')  order by enabled DESC";
    $res = mysqli_query($con,$qry);
    while($row = mysqli_fetch_array($res))
    {
        $data[] = $row; 
    }        
    echo json_encode($data);
}    
 
if(isset($_GET['searchusers']))
{
    $str = $_POST['data'];
    $admin_id = $_POST['adid'];
    $searchquery = "select * from go_users_admin_groups where admin_id=".$admin_id;
    $searchresults = mysqli_query($con,$searchquery);
    while($searchrow = mysqli_fetch_array($searchresults))
    { 
        $searchquery1 = "select * from go_users where id='".$searchrow['user_id']."' and role='user' and (first_name LIKE '%{$str}%' or dob LIKE '%{$str}%' or username LIKE '%{$str}%' or email LIKE '%{$str}%')  order by enabled DESC";
        $searchresults1 = mysqli_query($con,$searchquery1);
    
        while($searchrow1 = mysqli_fetch_array($searchresults1))
        {
            $data[] = $searchrow1; 
        }        
    }
    echo json_encode($data);
}    
 
function insert($data, $tablename) {
     
    global $con;
    $data_attibute = "";
    $data_values = "";
    foreach ($data as $key => $value) {
    $data_attibute = $data_attibute . $key . ",";
    $data_values = $data_values . "'" . mysqli_real_escape_string($con, $value) . "',";
    }
    $data_attibute = rtrim($data_attibute, ",");
    $data_values = rtrim($data_values, ",");
    $insert = "INSERT INTO $tablename ($data_attibute) values ($data_values)";
    $res = mysqli_query($con,$insert);
    if (!$res) 
    {
        die(mysqli_error($con));
        return FALSE;
    }
   return mysqli_insert_id($con);
}
 
function update($data, $tablename){
     
     global $con ;
     global $id;
     $str="";
     foreach($data as $key => $value){
        $str .=  $key."='".$value."',";
     }
     $string = rtrim($str,",");
     $qry = "UPDATE $tablename set $string where id=$id";

    $res = mysqli_query($con,$qry);
    if($res)
    { return true;}
    else {
        return mysqli_error($con);
    }

}

function encrypt($msg, $k='', $base64 = true, $prefix='{GOCRYPT}') {

		if($msg=="")
			return "";
		
		//Check if mcrypt is supported. mbstring.func_overload will mess up substring with this function
		if (!function_exists('mcrypt_module_open') || ini_get('mbstring.func_overload') > 0)
			return false;

		if (empty($k)) {
			$k = getKey();
			if (empty($k)) {
				throw new \Exception('Could not generate private encryption key. Please check the file permissions of the folder defined as $config[\'file_storage_path\'] in your config.php and the file key.txt in it.');
			}
		}		

		# open cipher module (do not change cipher/mode)
		if (!$td = mcrypt_module_open('rijndael-256', '', 'ctr', ''))
			return false;

		$msg = serialize($msg);			 # serialize
		$iv = mcrypt_create_iv(32, MCRYPT_RAND);	# create iv

		if (mcrypt_generic_init($td, $k, $iv) !== 0) # initialize buffers
			return false;

		$msg = mcrypt_generic($td, $msg);		# encrypt
		$msg = $iv . $msg;				# prepend iv
		$mac = pbkdf2($msg, $k, 1000, 32);	# create mac
		$msg .= $mac;				 # append mac

		mcrypt_generic_deinit($td);			# clear buffers
		mcrypt_module_close($td);			# close cipher module

		if ($base64)
			$msg = base64_encode($msg);# base64 encode?

		return $prefix.$msg;				 # return iv+ciphertext+mac
	}
        
//  function file_get_contents ($filename, $use_include_path = false, $context = null, $offset = -1, $maxlen = null) {}    
 function pbkdf2($p, $s, $c, $kl, $a = 'sha256') {

		$hl = strlen(hash($a, null, true)); # Hash length
		$kb = ceil($kl / $hl);		# Key blocks to compute
		$dk = '';			 # Derived key
		# Create key
		for ($block = 1; $block <= $kb; $block++) {

			# Initial hash for this block
			$ib = $b = hash_hmac($a, $s . pack('N', $block), $p, true);

			# Perform block iterations
			for ($i = 1; $i < $c; $i++)

			# XOR each iterate
				$ib ^= ($b = hash_hmac($a, $b, $p, true));

			$dk .= $ib; # Append iterated block
		}

		# Return derived key of correct length
		return substr($dk, 0, $kl);
	}      
 function getKey() {
                $file_storage_path = '/home/';
		$key_file = $file_storage_path. 'key.txt';

		if (file_exists($key_file)) {
			$key = file_get_contents($key_file);
		} else {

			$key = randomPassword(20);
			//if (file_put_contents($key_file, $key)) {
			//chmod($key_file, 0400);
			//} else {
			//	return false;
			//}
		}
		return $key;
	}
//  function file_put_contents ($filename, $data, $flags = 0, $context = null) {}
      
       function randomPassword($password_length = 0, $characters_allow = 'a-z,1-9', $characters_disallow = 'i,o' ) {

		if($password_length==0)
		{
			$password_length=6;
		}

		// Generate array of allowable characters.
		$characters_allow = explode(',', $characters_allow);

		for ($i = 0; $i < count($characters_allow); $i ++) {
			if (substr_count($characters_allow[$i], '-') > 0) {
				$character_range = explode('-', $characters_allow[$i]);

				for ($j = ord($character_range[0]); $j <= ord($character_range[1]); $j ++) {
					$array_allow[] = chr($j);
				}
			} else {
				$array_allow[] = $characters_allow[$i];
			}
		}

		// Generate array of disallowed characters.
		$characters_disallow = explode(',', $characters_disallow);

		for ($i = 0; $i < count($characters_disallow); $i ++) {
			if (substr_count($characters_disallow[$i], '-') > 0) {
				$character_range = explode('-', $characters_disallow[$i]);

				for ($j = ord($character_range[0]); $j <= ord($character_range[1]); $j ++) {
					$array_disallow[] = chr($j);
				}
			} else {
				$array_disallow[] = $characters_disallow[$i];
			}
		}

		mt_srand(( double ) microtime() * 1000000);

		// Generate array of allowed characters by removing disallowed
		// characters from array.
		$array_allow = array_diff($array_allow, $array_disallow);

		// Resets the keys since they won't be consecutive after
		// removing the disallowed characters.
		reset($array_allow);
		$new_key = 0;
		while (list ($key, $val) = each($array_allow)) {
			$array_allow_tmp[$new_key] = $val;
			$new_key ++;
		}

		$array_allow = $array_allow_tmp;
		$password = '';
		while (strlen($password) < $password_length) {
			$character = mt_rand(0, count($array_allow) - 1);

			// If characters are not allowed to repeat,
			// only add character if not found in partial password string.
//			if ($repeat == 0) {
				if (substr_count($password, $array_allow[$character]) == 0) {
					$password .= $array_allow[$character];
				}
//			} else {
//				$password .= $array_allow[$character];
//			}
		}
		return $password;
	}

//class test extends Crypt{
   // function eecho(){
    //    echo "rgfserg";
   // }
//}
//$obj = new test();
 //   echo Crypt::encrypt('password');
//echo $obj->eecho;
  //      echo encrypt('test@123');
?>