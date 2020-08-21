<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uriExplode = explode( '/', $uri );
$opts = array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  
//Basically adding headers to the request
$context = stream_context_create($opts);
$api_url = urlencode('https://onsterion-mp-commerce-php.herokuapp.com/notifications');
//$api_url = 'php://input';

$jsonContent = json_decode(file_get_contents($api_url,false,$context), TRUE);

// all of our endpoints start with /person
// everything else results in a 404 Not Found
if ($uriExplode[1] !== 'notifications') 
{
    header("HTTP/1.1 404 Not Found");
    exit();
}

/*// everything else results in a 404 Not Found
if ($uriExplode[2] !== 'notifications') 
{
    header("HTTP/1.1 404 Not Found");
    exit();
}*/

$requestMethod = $_SERVER["REQUEST_METHOD"];
$response = [];
$response['status_code_header'] = 'HTTP/1.1 200 OK';
$response['body'] = "Success";

switch ($requestMethod) 
{
    case 'GET':
        $response['body'] = "Success GET";
        break;
    case 'POST':
        $response['body'] = "Success POST";
        break;
    case 'PUT':
        $response['body'] = "Success PUT";
        break;
    case 'DELETE':
        $response['body'] = "Success PDELETEUT";
        break;
    default:
        $response['body'] = "Success Default";
        break;
}

$response['body'] = json_encode($jsonContent);

// Response
header($response['status_code_header']);

if ($response['body']) 
{
    echo $response['body'];
}

// Send Email

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

$to = "lucas@kubeymachine.com";
$subject = "Mercado Pago Notification";
$txt = json_encode($jsonContent);
$headers = "From: lucas@kubeymachine.com";

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp-relay.sendinblue.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'support@kubeymachine.com';                     // SMTP username
    $mail->Password   = '5pDhJT8RbkSLgEPX';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('suppor@kubeymachine.com', 'Mailer');
    $mail->addAddress($to, 'Lucas Pallares');     // Add a recipient
    $mail->addReplyTo($to, 'Information');

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Mergado Pago Certif Notificacion';
    $mail->Body    = json_encode($jsonContent);
    $mail->AltBody = json_encode($jsonContent);

    $mail->send();
    //echo 'Message has been sent';
} 
catch (Exception $e) 
{
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>