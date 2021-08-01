<?php 
    require 'Entity/Message.php';
    require 'Form/MessageForm.php';
    require 'Datatable/MessageTable.php';
    require 'Controller/MessageController.php';
    require 'Controller/MessageFrontController.php';

    require 'Entity/Newsletter.php';
    require 'Form/NewsletterForm.php';
    require 'Datatable/NewsletterTable.php';
    require 'Controller/NewsletterController.php';
    require 'Controller/NewsletterFrontController.php';

    \dclass\devups\Controller\Controller::addEventListener("after", "create", strtolower(Message::class));

