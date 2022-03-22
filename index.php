<?php

 

    include "quiry_builder.php";
    echo "<h1>Index page</h1>";
    $qb = new Builder();
    echo "<pre>";

    // TESTING THE METHODS
   print_r($qb->select("*","employee")->runQuery());
   print_r($qb->count("EmpID","project")->runQuery());
 
   print_r($qb->update("project",array("ProjectName"),array("C++"),"ProjectName = \"C--\"")->runQuery());
//    print_r($qb->select("*","project","ProjectName = 'whatsapp_clone_2'")->runQuery());
 print_r($qb->insert("employee",array('EmpName','Age','Email','PhoneNO','Address'),array("\"Abdulaziz\"",25,"\"abdulaziz@gmail.com\"",78787,"\"sana'a\""))->runQuery());
