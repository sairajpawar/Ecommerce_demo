<!doctype html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-compatible" Content="IE-edge">
    <meta name="viewport" content="width-device-width">
    <title>Studyleague IT Solutions - Web Intermediate</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/ind.css" rel="stylesheet">
</head>
<body>
<!--    header started-->
<?php
include "header.php";
if(isset($_POST["send_message"]))
{
    $name=mysqli_real_escape_string($con,$_POST["name"]);
    $number=mysqli_real_escape_string($con,$_POST["number"]);
    $email=mysqli_real_escape_string($con,$_POST["email"]);
    $msg=mysqli_real_escape_string($con,$_POST["msg"]);
    $result=mysqli_query($con,"insert into message VALUES ('$name','$number','$email','$msg')");
    if($result)
    {
        echo "<script>Alert('Your message has been successfully send')</script>";
        $to=$email;
        $subject='Feedback';
        $message='Thanks for your feedback we will reply you shortly';
        $header='Form: conatctus@gmail.com'."\r\n";
        $mail=mail($to,$subject,$message,$header);
        if($mail)
        {
            echo "<script>window.open('index.php',_self)</script>";
        }
        else
        {
            echo "<script>alert('Error sending mail')</script>";
            echo "<script>window.open('index.php','_self')</script>";
            exit();
        }
    }
    else
    {
        echo "<script>alert('Something went wrong please try again')</script>";
        echo "<script>window.history.back()</script>";
        exit();
    }
}
?>
<!-- end of header--->

<br>
<!--Product description-->
<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <!-- Map Column -->
            <div class="col-lg-8 mb-4">
                <!-- Embedded Google Map -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d60373.57066060561!2d72.80052321034596!3d18.960225105869817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sbrand+factory!5e0!3m2!1sen!2sin!4v1531498197480" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>            </div>
            <!-- Contact Details Column -->
            <div class="col-lg-4 mb-4">
                <h3>Contact Details</h3>
                <p>
                    Head office- Future Lifestyle Fashions Ltd.
                    <br>BrandFactory, Umang Tower,
                    <br>
                    2nd Floor, Mind Space,
                    <br>
                    Opp Link Road, Malad (West),
                    <br>
                    Mumbai – 400 064.
                    <br>
                    Landmark: Behind Inorbit Mall.
                    <br>
                </p>
                <p>
                    <abbr title="Phone">Phone</abbr>: 9167322014
                </p>
                <p>
                    <abbr title="Email">Email</abbr>:
                    <a href="mailto:name@example.com"> brandfactory@futurelifestyle.in
                    </a>
                </p>
                <p>
                    <abbr title="Hours">Hours</abbr>: Monday - Friday: 9:00 AM to 5:00 PM
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 mb-4">
            <h3>Send us a Message</h3>
            <form name="sentMessage" id="contactForm" method="post" action="">
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Full Name:</label>
                        <input type="text" class="form-control" id="name" required data-validation-required-message="Please enter your name." name="name">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Phone Number:</label>
                        <input type="tel" class="form-control" id="phone" required data-validation-required-message="Please enter your phone number." name="number">
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Email Address:</label>
                        <input type="email" class="form-control" id="email" required data-validation-required-message="Please enter your email address." name="email" >
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Message:</label>
                        <textarea rows="10" cols="100" class="form-control" id="message" required data-validation-required-message="Please enter your message" maxlength="999" style="resize:none" name="msg" ></textarea>
                    </div>
                </div>
                <div id="success"></div>
                <!-- For success/fail messages -->
                <button type="submit" class="btn btn-primary" id="sendMessageButton" name="send_message">Send Message</button>

            </form>
        </div>

    </div>
</div>
<br>
<br>
<!--footer started-->
<?php
include "footer.php";
?>
<!--end of footer-->
<script type="text/javascript" src="vendor/jquery/jquery.js"></script>
</body>
</html>