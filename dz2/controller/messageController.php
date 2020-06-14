<?php

require_once __DIR__ . '/../model/service.class.php';

function ispis($s){
    $polje = explode(" ", $s);
    foreach($polje as $p){
        if ($p[0] != '@'){
            echo $p . ' ';
        }
        else {
            $p1 = ltrim($p, "@"); 
            $p1 = preg_replace("/[^A-Za-z0-9 ]/", '', $p1);
            echo '<a href="index.php?rt=message/otherMessages&name=' . $p1 . '">' . $p . '</a> ';
       }
    }
}

class MessageController
{
    public function userMessages(){
        $ser = new Service();
		
        $title = 'My messages';
        
        $messages = $ser->getAllMessagesByUser($_SESSION['username']);
        require_once __DIR__ . '/../view/my_messages.php';
    }

    public function otherMessages(){
        if ($_GET['name'] == $_SESSION['username'])
            header( 'Location: index.php?rt=message/userMessages');
        $ser = new Service();
		
        $title = $_GET['name'] . ' messages';
        
        $messages = $ser->getAllMessagesByUser($_GET['name']);
        if (!empty($messages))
            require_once __DIR__ . '/../view/user_messages.php';
        else{
            echo 'Ne postoji korisnik ' . $_GET['name'] . '<br>';
            echo 'Vračam na početnu stranicu.';
            $channels = $ser->getAllChannelsByUser($_SESSION['username']);
            require_once __DIR__ . '/../view/my_channels.php';
        }
    }

    public function theChannel(){
        
        if (isset($_POST['submit']) && isset($_POST['nova_poruka']) && $_POST['nova_poruka'] != ""){
            $ser = new Service();
            $ser->sendMessage($_POST['nova_poruka'], $_SESSION['username'], $_POST['submit']);
            header( 'Location: index.php?rt=message/theChannel&channel_id=' . $_POST['submit'] );
        }

        if (isset($_GET['channel_id'])){
            $ser = new Service();
            $_SESSION['channel_id'] = $_GET['channel_id'];

            $channel = $ser->getChannelById($_GET['channel_id']);
            $title = $channel->name;
            $messages = $ser->getAllMessagesByChannel($_GET['channel_id']);
            
            require_once __DIR__ . '/../view/the_channel.php';
        }
        else{
            echo "Greška: vračam na početnu stranicu";
            require_once __DIR__ . '/../view/my_channels.php';
        }
    }

    public function myThumbUp(){
        $ser = new Service();

        if (isset($_GET['message_id'])){
            $ser->thumbIncrease($_GET['message_id']);

            header( 'Location: index.php?rt=message/userMessages' );
        }
    }
    public function channelThumpUp(){
        if (isset($_GET['message_id'])){
            $ser = new Service();
            $ser->thumbIncrease($_GET['message_id']);

            header( 'Location: index.php?rt=message/theChannel&channel_id=' . $_SESSION['channel_id']  );
        }
    }

    public function userThumbUp(){
        if (isset($_GET['message_id'])){
            $ser = new Service();
            $ser->thumbIncrease($_GET['message_id']);

            header( 'Location: index.php?rt=message/otherMessages&name=' . $_GET['name']);
        }
    }
}


?>