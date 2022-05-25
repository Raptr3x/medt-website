<?php
require_once "./functions.php";
require_once "./constants.php";
require_once "./database/db_functions.php";


$conn = create_conn();

if(isset($_POST['name'])){

    $name = sanitize_user_input_text($_POST['name']);
    $combinedDT = date('Y-m-d H:i:s', strtotime($_POST['date'].", ".$_POST['time']));
    $email = sanitize_user_input_text($_POST['email']);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);;
    $people = filter_var($_POST['people'], FILTER_SANITIZE_NUMBER_INT);;


    $usersCol = "fullname, email, phone";
    $usersVal = "'".$name."', '".$email."', '".$number."'";
    insert($conn, CUST, $usersCol, $usersVal);
    $customerID = get_last_id($conn, CUST, "customerID");


    // get free tables
    $people1 = $people+1;
    $tableID = free_sql($conn, "select tableID from free_tables where maxPeople = {$people} or maxPeople = {$people1} LIMIT 1")[0]['tableID'];

    $resCol = "reservationDatetime, numOfPeople, tableID, customerID";
    $resVal = "'".$combinedDT."', ".$people.", ".$tableID.", ".$customerID."";
    insert($conn, RESER, $resCol, $resVal);

}
?>

<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> LuNiBo </title>
        <link rel="stylesheet" href="/css/all.css">
        <link rel="stylesheet" href="/css/fontawesome.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,300&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">
    </head>
<body>
 <section class="home">
    <header>
        
               <a href="#" class="brand">LuNiBo</a>
                <div class="menu">
                    <div class="btn">
                        <i class="fas fa-times close-btn"></i>
                  </div> 
                    <a href="#section-main">HOME</a></li>
                    <a href="#about">ABOUT</a></li>
                    <a href="#menu">MENU</a></li>
                    <a href="#reserve">RESERVE</a></li>
                    <a href="#contact">CONTACT</a></li>
                </div>
                    <div class="btn">
                        <i class="fa fa-bars menu-btn"></i>
                        
                    </div>
            

    </header>

    <section id="section-main">

     <div class="text-box">
        <h1>Das weltbeste Restaurant</h1>
        <p>
            Ja richtig gehoert wir sind das welbeste Restaurant
        </p>
        <a href="#reserve" class="hero-btn">Komm und ueberzeuge dich !</a>
        
    
    </div>
   </section>
  

</section>

<!-------about--------->

<section id="about">
    <h1>Ueber uns</h1> <br>
    
    <div class="row">
        <div class="course-col">
            <h3>Lukas</h3>
            <p>hdaskljfgbsk;dfjbg;kadbowsajbeo;ighbeawso;rdhigfo;<br>;kdhaz;klfgjvhbad;e lifgtop eray;
                lafsdhjjg;kadshf sda;IHFG ;LKS</p>
        </div>
        <div class="course-col">
            <h3>Nikola</h3>
            <p>hdaskljfgbsk;dfjbg;kadbowsajbeo;ighbeawso;rdhigfo;<br>;kdhaz;klfgjvhbad;e lifgtop eray;
                lafsdhjjg;kadshf sda;IHFG ;LKS</p>
        </div>
        <div class="course-col">
            <h3>Bogdan</h3>
            <p>hdaskljfgbsk;dfjbg;kadbowsajbeo;ighbeawso;rdhigfo;<br>;kdhaz;klfgjvhbad;e lifgtop eray;
                lafsdhjjg;kadshf sda;IHFG ;LKS</p>
        </div>
    </div>
</section>

<!----- Menu ----->

<section id="menu">

    <h1>Unser wunderbares und leckeres Menu</h1> <br><br><br><br><br>
    <p>Hier kommen dann die ganzen Bilder mit den Preisen</p>

</section>

<!----- Reserve ----->

   <section id="reserve" >

    <h1>Reserviere einen <br> Tisch</h1> <br><br><br><br>

    <form action="index.php" method="POST">
        <div>
            <span>Your full name ?</span>
            <input type="text" name="name" id="name" placeholder="Write your name here..." required>
        </div>
        <div>
            <span>Your email address ?</span>
            <input type="email" name="email" id="name" placeholder="Write your email here..." required> 
        </div>
        <div>
            <!-- <---this is the select option--->
            <span>How many people ?</span>
            <select name="people" id="people" required>
                <option value=""> <---People---></option>
                <option value="1">1 People</option>
                <option value="2">2 People</option>
                <option value="3">3 People</option>
                <option value="4">4 People</option>
                <option value="4">5 People</option>
                <option value="4">6 People</option>
                <option value="4">7 People</option>
                <option value="4">8 People</option>
                <option value="4">9 People</option>
            </select>
            <!-- this is the select option -->
        </div>
        <div>
            <span>What time ?</span>
            <input type="time" name="time" id="time"  min="10:00" max="23:00" required>
        </div>
        <div>
            <span>What is the date ?</span>
            <input type="date" name="date" id="date" placeholder="date" required>
        </div>
        <div>
            <span>Your phone number ?</span>
            <input type="number" name="number" id="number" placeholder="Write your number here..." required>
        </div> 
        <br>
        <div id="submit">
            <input type="submit" value="SUBMIT" id="submit">
        </div>


    </form>

   </section>

   <section id="contact">

    <!--alert messages start
    <div class="alert-success">
      <span>Message Sent! Thank you for contacting us.</span>
    </div>
    <div class="alert-error">
      <span>Something went wrong! Please try again.</span>
    </div>
    alert messages end-->

    <!--contact section start-->

    <div class="contact-section">
        <div class="contact-info">
          <div><i class="fas fa-map-marker-alt"></i>
            Thaliastraße 125, 1160 Wien, Oesterreich</div>
          <div><i class="fas fa-envelope"></i>panic.n99@htlwienwest.at</div>
          <div><i class="fas fa-phone"></i>+43 660 253 732 33</div>
          <div><i class="fas fa-clock"></i>Mo - SO 10:00 AM to 1:00 PM</div>
        </div>
        <div class="contact-form">
          <h2>Contact Us</h2> 
          <form class="contact" action="" method="post">
            <input type="text" name="name1" class="text-box1" placeholder="Your Name" required>
            <input type="email" name="email1" class="text-box1" placeholder="Your Email" required>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            <input type="submit"  id="send-btn" value="Send">
          </form>
        </div>
      </div>
      
      <!--contact section end-->
    
   </section>

   <script type="text/javascript">
    //javascript for navigation bar effect on scroll
    window.addEventListener("scroll", function(){
      var header = document.querySelector("header");
      header.classList.toggle('sticky', window.scrollY > 0);
    });

    //javascript for responsive navigation sidebar menu
    var menu = document.querySelector('.menu');
    var menuBtn = document.querySelector('.menu-btn');
    var closeBtn = document.querySelector('.close-btn');

    menuBtn.addEventListener("click", () => {
      menu.classList.add('active');
    });

    closeBtn.addEventListener("click", () => {
      menu.classList.remove('active');
    });
    </script>

</body>

</html>