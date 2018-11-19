<?php
/*
 *  CONFIGURE EVERYTHING HERE
 */


// an email address that will be in the From field of the email.
$from = 'mail.gogreenauto.a2hosted.com';

// an email address that will receive the email with the output of the form
$sendTo = 'cole3789@gmail.com';

// subject of the email
$subject = 'New Quote Request';

// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('vehicleYear' => 'Vehicle_Year', 'make' => 'Make', 'model' => 'Model', 'optradio1' => 'Is_Running', 'optradio2' => 'Not_Running', 'location' => 'Location', 'customerName' => 'Customer_Name', 'retEmail' => 'Customer_Email', 'phoneNum' => 'Customer_Phone'); 

// message that will be displayed when everything is OK :)
$okMessage = 'Quote form successfully submitted. Thank you, we will get back to you soon!';

// If something goes wrong, we will display this message.
$errorMessage = 'There was an error while submitting the form. Please try again later';

/*
 *  LET'S DO THE SENDING
 */


// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

try
{

    if(count($_POST) == 0) throw new \Exception('Form is empty');
            
    $emailText = "You have a new message from your quote form\n=============================\n";

    foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email 
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    // All the neccessary headers for the email.
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    // Send email
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
    $encoded = json_encode($responseArray);

    header('Location: ../quote.html');

    echo $encoded;


}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

/*
// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Location: http://gogreenauto.a2hosted.com/quote.html');

    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}

*/
// Start of new script
/*
$year = $_POST['vehicleYear'];
$make = $_POST['make'];
$model = $_POST['model'];
$running = $_POST['optradio1'];
$notRuning = $_POST['optradio2'];
$location = $_POST['location'];
$name = $_POST['customerName'];
$email = $_POST['retEmail'];
$phone = $_POST['phoneNum'];

$email_from = 'mail.gogreenauto.a2hosted.com';
$email_subject = 'New Quote Request';
$email_body = "Name: $name.\n".
              "Email: $email.\n".
              "Phone: $phone.\n".
              "Location: $location.\n".
              "Year: $year.\n".
              "Make: $make.\n".
              "Model: $model.\n".
              "Running: $running.\n"
              "Not Running: $notRuning.\n";
$to = "cole3789@gmail.com";
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $email \r\n";
mail($to,$email_subject,$email_body,$headers);

header("location: quote.html");
*/
?>
