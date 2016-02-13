<?php 
	$connect = mysql_connect('localhost','root','');
	
	if(!$connect){
	die('Could not connect: ' . mysql_error());
	exit();
	}

	$db=mysql_select_db('datbasename');
	if(!$db){
	echo "<script> alert('Connection to Database Successful but Sorry Access Denied !')</script>";
	exit();
	}
	
	if(isset($_POST['av_verify'])){

		$bday	= $_POST['av_verify_d'];
		$bmonth = $_POST['av_verify_m'];
		$byear = $_POST['av_verify_y'];
		$av_mail = $_POST['av_mail'];

	if($bday !=''&& $bmonth !=''&& $byear !=''){

		$curMonth = date("m");
		$curDay = date("j");
		$curYear = date("Y");
		
	if($bday > $curDay){

		$num_days = date(t);
		$cur_day = $curDay+$num_days;
		$getday = $cur_day-$bday;
	}

	else{
		$getday = $curDay-$bday;					
	}

	// get age month and year

	$b_month = $bmonth +1;
	
	if($b_month > $curMonth){

		$cur_month = $curMonth+12;
		$getmonth = $cur_month-$b_month;

		//get year age

		if($cur_month){
			$b_year = $byear+1;
			$getyear = $curYear-$b_year;

		}

		else{
			$getyear = $curYear-$b_year;
		}

					//end year age	
	}

	else{

		$getmonth = $curMonth-$b_month;
	}

	$currentage =  $getyear.'-'.$getmonth.'-'.$getday;

	$time = date('m/d/Y');


	$sql ="INSERT INTO table (day,month,year,age,email,subscribe_dt,time) VALUES ('$bday','$bmonth','$byear','$currentage','$av_mail',NOW(),'$time')";

	$datas = mysql_query($sql);
	
	if(!$datas){
		echo "Age not submit not successfully  ";
	}

 	$q = mysql_query("SELECT id, day, month, year, age, email, subscribe_dt, time FROM table WHERE subscribe_dt > DATE_SUB(NOW(), INTERVAL 1 DAY)");

    $count = mysql_data_seek($q,(mysql_num_rows($q)-2));
	//var_dump($count);

    if($count>=1){

	$row = mysql_fetch_assoc($q);
	//var_dump($row['time']);
		  
	if($row['time'] < date('m/d/Y')){

		function create_csv_string($data) {

		$data = mysql_query("SELECT id, day, month, year, age, email, subscribe_dt FROM table WHERE subscribe_dt > DATE_SUB(NOW(), INTERVAL 1 DAY)");

		// Open temp file pointer
		if (!$fp = fopen('php://temp', 'w+')) return FALSE;
		
		fputcsv($fp, array('ID', 'Birth Of Day', 'Birth Of Month', 'Birth Of Year', 'Current Age', 'Visitor Mail Address', 'Visited Date & Time'));
		
		// Loop data and write to file pointer

			while ($line = mysql_fetch_assoc($data)) fputcsv($fp, $line);
			// Place stream pointer at beginning
			rewind($fp);
			// Return the data

			return stream_get_contents($fp);


		}

		

		function send_csv_mail($csvData, $body, $to = 'farrukislam1@gmail.com', $subject = 'Website Report Visitor Age Information', $from = 'david@hestiatobacco.com') {

			// This will provide plenty adequate entropy

			$multipartSep = '-----'.md5(time()).'-----';
			// Arrays are much more readable

			$headers = array(
				"From: $from",
				"Reply-To: $from",
				"Content-Type: multipart/mixed; boundary=\"$multipartSep\""
			);


			// Make the attachment

			$attachment = chunk_split(base64_encode(create_csv_string($csvData))); 

			// Make the body of the message

			$body = "--$multipartSep\r\n"
				. "Content-Type: text/plain; charset=ISO-8859-1; format=flowed\r\n"
				. "Content-Transfer-Encoding: 7bit\r\n"
				. "\r\n"
				. "$body\r\n"
				. "--$multipartSep\r\n"
				. "Content-Type: text/csv\r\n"
				. "Content-Transfer-Encoding: base64\r\n"
				. "Content-Disposition: attachment; filename=\"Website-Report-Age-Information" . date("F-j-Y") . ".csv\"\r\n"
				. "\r\n"
				. "$attachment\r\n"
				. "--$multipartSep--";

			// Send the email, return the result

			return @mail($to, $subject, $body, implode("\r\n", $headers)); 

		}

		$array = array(array(1,2,3,4,5,6,7), array(1,2,3,4,5,6,7), array(1,2,3,4,5,6,7));
		send_csv_mail($array, "Website Report Age Information \r\n \r\n www.hestiatobacco.com");
		
		
      }

	}

else{
	function create_csv_string($data) {

		$data = mysql_query("SELECT id, day, month, year, age, email, subscribe_dt FROM age_email_notification WHERE subscribe_dt > DATE_SUB(NOW(), INTERVAL 1 DAY)");

		// Open temp file pointer
		if (!$fp = fopen('php://temp', 'w+')) return FALSE;
		
		fputcsv($fp, array('ID', 'Birth Of Day', 'Birth Of Month', 'Birth Of Year', 'Current Age', 'Visitor Mail Address', 'Visited Date & Time'));
		
		// Loop data and write to file pointer

			while ($line = mysql_fetch_assoc($data)) fputcsv($fp, $line);
			// Place stream pointer at beginning
			rewind($fp);
			// Return the data

			return stream_get_contents($fp);


		}

		

		function send_csv_mail($csvData, $body, $to = 'farrukislam1@gmail.com', $subject = 'Website Report Visitor Age Information', $from = 'david@hestiatobacco.com') {

			// This will provide plenty adequate entropy

			$multipartSep = '-----'.md5(time()).'-----';
			// Arrays are much more readable

			$headers = array(
				"From: $from",
				"Reply-To: $from",
				"Content-Type: multipart/mixed; boundary=\"$multipartSep\""
			);


			// Make the attachment

			$attachment = chunk_split(base64_encode(create_csv_string($csvData))); 

			// Make the body of the message

			$body = "--$multipartSep\r\n"
				. "Content-Type: text/plain; charset=ISO-8859-1; format=flowed\r\n"
				. "Content-Transfer-Encoding: 7bit\r\n"
				. "\r\n"
				. "$body\r\n"
				. "--$multipartSep\r\n"
				. "Content-Type: text/csv\r\n"
				. "Content-Transfer-Encoding: base64\r\n"
				. "Content-Disposition: attachment; filename=\"Website-Report-Age-Information" . date("F-j-Y") . ".csv\"\r\n"
				. "\r\n"
				. "$attachment\r\n"
				. "--$multipartSep--";

			// Send the email, return the result

			return @mail($to, $subject, $body, implode("\r\n", $headers)); 

		}

		$array = array(array(1,2,3,4,5,6,7), array(1,2,3,4,5,6,7), array(1,2,3,4,5,6,7));
		send_csv_mail($array, "Website Report Age Information \r\n \r\n www.hestiatobacco.com");
	
		}

	}

	
 }





