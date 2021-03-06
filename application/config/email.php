<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Protocol
|--------------------------------------------------------------------------
|
| The mail sending protocol.
| Values: mail, sendmail, or smtp
*/
$config['protocol']     = 'mail';

/*
|--------------------------------------------------------------------------
| SMTP Host
|--------------------------------------------------------------------------
|
| SMTP Server Address.
|
*/
$config['smtp_host']    = '';

/*
|--------------------------------------------------------------------------
| SMTP Username
|--------------------------------------------------------------------------
|
| SMTP Username.
|
*/
$config['smtp_user']    = '';

/*
|--------------------------------------------------------------------------
| SMTP Password
|--------------------------------------------------------------------------
|
| SMTP Password.
|
*/
$config['smtp_pass']    = '';

/*
|--------------------------------------------------------------------------
| SMTP Port
|--------------------------------------------------------------------------
|
| SMTP Port.
|
*/
$config['smtp_port']    = '25';

/*
|--------------------------------------------------------------------------
| Mail Type
|--------------------------------------------------------------------------
|
| Type of mail. If you send HTML email you must send it as a complete web 
| page. Make sure you don't have any relative links or relative image paths 
| otherwise they will not work.
|
| Values: text or html
*/
$config['mailtype']     = 'html';

/*
|--------------------------------------------------------------------------
| Charset
|--------------------------------------------------------------------------
|
| Character set (utf-8, iso-8859-1, etc.).
|
*/
$config['charset']      = 'utf-8';

/*
|--------------------------------------------------------------------------
| UserAgent
|--------------------------------------------------------------------------
*/
$config['useragent']    = 'Refreak v0.1';

/*
|--------------------------------------------------------------------------
| crlf
|--------------------------------------------------------------------------
|
| Newline character. (Use "\r\n" to comply with RFC 822).
|
*/
$config['crlf']    = "\r\n";
/*
|--------------------------------------------------------------------------
| newline
|--------------------------------------------------------------------------
|
| Newline character. (Use "\r\n" to comply with RFC 822).
|
*/
$config['newline']    = "\r\n";

/* End of file email.php */
/* Location: ./application/config/email.php */
