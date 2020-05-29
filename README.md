# RWFA - Reflective Writing Feedback Application
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<hr>
<h2>Final year dissertation project for the University of Sussex. </h2>
<p>RWFA is a reflective writing feedback application. This is built using modern web technologies to create a web application for end-users to use for the purposes of bettering their reflective writing. </p>
<hr>
<h3>3-Tier architecture is used in comprosing the web app, A MVC of sorts</h3>
<p><b>Presentation Layer</b> - Built via PHP web forms that are presented as the user interface. Handle the view and display of key information deliverd by the business logic layer. Using display libraries comproised of modern javascript libraries also such as <a href="https://github.com/jquery/jquery">jQuery</a> and  <a href="https://github.com/popperjs/popper-core">Popper</a>.</p>
<br>
<p><b>Business Logic Layer</b> - Using PHP backing scripts that handle connections and manage the user state and system state overall while the web applicaiton is being utilised. Allows for the end-user to view information in a stateful manner. The backing scripts are validated to prevent common types of attacks such as XSS and Injection.  </p>
<br>
<p><b>Data Access Layer</b> - The base data managment system is comprised of an MySQL server running phpMyAdmin for administrative purposes and managment system, built with the InnoDB engine. This server stores all system information pertaining to the web application in an efficent, structured design.</p>
<br>
<p class="text-muted">Created by Sumedh Nimkar </p>
