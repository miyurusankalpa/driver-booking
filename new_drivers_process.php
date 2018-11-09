<?php  //inception
header('Content-Type: application/json');

	include_once 'mysqli.php';

	$error = array(); 	$array = array();
	
	// connecting to database
	$sql = new mysqli($server, $user, $pass, $db);

	if (isset($_POST['register'])) {

		$Firstname = mysqli_real_escape_string($sql, $_POST['Firstname']);
		$Lastname = mysqli_real_escape_string($sql, $_POST['Lastname']);
		$username = mysqli_real_escape_string($sql, $_POST['username']);
		$email = mysqli_real_escape_string($sql, $_POST['Email']);
		$password = mysqli_real_escape_string($sql, $_POST['password']);
		$conpassword = mysqli_real_escape_string($sql, $_POST['Conpassword']);
		$mobileNo = mysqli_real_escape_string($sql, $_POST['mobileNo']);

		//print_r($_POST);
		
		if(empty($Firstname)) {
				array_push($error, "Firstname is required");
		}

		if(empty($Lastname)) {
				array_push($error, "Lastname is required");
		}
		
		if(empty($username) ) {
				array_push($error, "Username is required"); //error msg username
		}
		
		if(empty($email)) {
				array_push($error, "Email is required");  //error msg password
		}
		
		if(empty($password)) {
				array_push($error, "Password is required");
		}
		
		if(empty($conpassword)) {
				array_push($error, "Confirm password is required");
		}

		if($password != $conpassword) {
				array_push($error, "Confim passwords do not match. Try again");
		}

		if(count($error) == 0) {
				$encryptpass = md5($password); //encryption
				$query = "INSERT INTO users (`firstname`, `lastname`, `username`, `email`, `password`, `mobileno`, `group`) VALUES ('$Firstname', '$Lastname', '$username', '$email', '$encryptpass', '$mobileNo','Driver')";
				
				$x = mysqli_query($sql, $query);

				if($x)
				{
					
					$html = '<tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                    <tr>
                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;text-align: center;">
					  <img src="https://chauffeurlk.com/images/logo.png" height="100px"><br>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Hello '.$Firstname.' '.$Lastname.'</p>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Welcome to chauffeurlk. Your username is '.$username.'. To begin using the service please login and check the booking assigned to you.</p>
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                          <tbody>
                            <tr>
                              <td align="center" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                                  <tbody>
                                    <tr>
                                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #3498db; border-radius: 5px; text-align: center;"> <a href="https://chauffeurlk.com/login.php" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Login</a> </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Thanks for using chauffeurlk.</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>';
					
						include_once 'mail.php';
						sendmailbymailgun($email,$username,"Welcome","welcome@chauffeurlk.com","Welcome to chauffeurlk",$html,"admin@chauffeurlk.com");
						
					$array["result"] = "success";
					$array["message"] = "New Driver Registration Successful.";
					goto output;
				} else {
					//echo mysqli_error($sql);
					array_push($error, "Error adding data to the database. Try again");
				}
			}			
	} else array_push($error, "Empty Data.");

	$array["result"] = "error";
	$array["message"] = $error;
	
output:	

	$json = json_encode($array);
	echo $json;

?>
