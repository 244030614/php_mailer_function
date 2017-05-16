<?php
require_once 'PHPMailer-5.2.14/class.phpmailer.php';
require_once 'PHPMailer-5.2.14/class.smtp.php';
//  /*
//   * [send_mail 发送邮件]
//   * @zeo
//   * @param   string   必填  $from          //发件人地址
//   * @param   string   必填  $from_name     //发件人名称
//   * @param   array    必填  $sendto       //array( 
                                             //    收件人地址      'send_email'=>array('xxxxxx@qq.com'),
                                             //    抄送地址        'add_cc'=>array('xxxxxx@qq.com'),
                                             //    密送地址        'add_bcc'=>array('xxxxx@qq.com'),)
//   * @param   string   必填  $subject      //邮件标题
//   * @param   string   必填  $body         //邮件内容
//   * @param   bool    非必填 $html        //是否以html格式发送
//   * @param   array   非必填 $file_src    //附件 array('/opt/www/1.jpg','/opt/www/2.jpg')
//   * @param   array   非必填 $host        //邮箱服务器 如填写该字段则必须填写用户名密码(建议使用，若不填写则发送邮件会进垃圾箱)
//   * @param   array   非必填 $username    //邮箱服务器用户名
//   * @param   array   非必填 $password    //邮箱服务器密码
//   * @DateTime 2016-12-21
//   * */
//调用示例
// send_mail(
//       'zeo@aiyintech.com',     //发件人邮箱
//       'zeo',                   //发件人昵称
//       array(
//         'send_email'=>array('244030614@qq.com'),
//         'add_cc'=>array('1224797122@qq.com'),
//         'add_bcc'=>array('1224797122@qq.com'),
//         ),
//       '邮件标题',                //邮件标题
//       '邮件正文',                //邮件正文
//       false,                    //是否使用html格式发送
//       array('/opt/www/cust_resource/realplay_img/1000002/1.jpg'), //发送的文件路径(不能以中文开头)
//       'smtp.exmail.qq.com',     //smtp服务器
//       'zeo@aiyintech.com',      //smtp 邮箱用户名
//       'Ssq123123'               //smtp 邮箱密码
//       );
function send_mail($from,$from_name,$sendto,$subject,$body,$html=false,$file_src=array(),$host='',$username='',$password=''){
 		$mail = new PHPMailer(true);
		$mail->CharSet  = 'UTF-8'; 		   //设置编码		
		$mail->From     = $from;   		   //发件人邮箱
    $mail->FromName = $from_name;	   //发件人名称
    $mail->Subject  = $subject;      //邮件标题
    $mail->Body     = $body;         //邮件内容
		//是否使用邮箱服务器发送邮件			
 		if(!empty($host)){
			$mail->isSMTP(); 	
			$mail->Host     = $host;     //使用邮箱服务器
			$mail->SMTPAuth = true;      // 启用SMTP验证功能
			$mail->Username = $username; //你的服务器邮箱账号
			$mail->Password = $password; // 邮箱密码
			$mail->Port     = 25;        //邮箱服务器端口号
 		}else{
 			 $mail->isMail(); 			 //使用php mail()发送邮件
 		}
 		//是否使用HTML格式
 		if($html){
 			$mail->IsHTML(true);		
 		}else{
 			$mail->IsHTML(false);		
 		}
 		//是否发送附件
 		if(!empty($file_src)){
 			foreach ($file_src as $key => $value) {
 				$mail->AddAttachment($value); 
 			} 			
  	}
		//设置收件地址
		foreach ($sendto['send_email'] as $k => $v) {
			$mail->AddAddress($v);   
		}
		//设置抄送地址
		if(isset($sendto['add_cc'][0])){
			foreach ($sendto['add_cc'] as $k => $v) {
				$mail->AddCC($v);
			}
  	}
		//设置密送地址
		if(isset($sendto['add_bcc'][0])){
		  	foreach ($sendto['add_bcc'] as $k => $v) {
				  $mail->AddBCC($v);
			}	
		}
		//发送邮件
		$a = $mail->Send();
		if (!$a) {
			error_log("邮件发送失败原因:$mail->ErrorInfo");
			return false;		  
		}
		return true;
 }
