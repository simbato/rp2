<?php 


require_once __DIR__ . '/../model/service.class.php';

class ChannelController
{
	public function index() { //lista userovih kanala
		$ser = new Service();
		
		$title = 'My channels';
		$channels = $ser->getAllChannelsByUser($_SESSION['username']);
		require_once __DIR__ . '/../view/my_channels.php';
    }
    public function all(){
        $ser = new Service();

        $title = 'All channels';
		$channels = $ser->getAllChannels();
        require_once __DIR__ . '/../view/all_channels.php';
    }

    public function startNew(){
        require_once __DIR__ . '/../view/create_channel.php';
    }

    public function createNew(){
        $ser = new Service();
        $ser->startNewChannel($_SESSION['username'], $_POST['ime_kanala']);
        header( 'Location: index.php?rt=channel' );
    }
}; 

?>