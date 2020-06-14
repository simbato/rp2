<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php';
require_once __DIR__ . '/channel.class.php';
require_once __DIR__ . '/message.class.php';

class Service
{
    function getUserById( $id ) {
        try {
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_users WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        
        $row = $st->fetch();
		if( $row === false )
			return null;
		else
            return new User( $row['id'], $row['username'], $row['password_hash'], 
                $row['email'], $row['registration_sequence'], $row['has_registered'] );
    }

    function getUserByUsername( $username ) {
		try {
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_users WHERE username=:username' );
			$st->execute( array( 'username' => $username ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
            return new User( $row['id'], $row['username'], $row['password_hash'], 
                $row['email'], $row['registration_sequence'], $row['has_registered'] );
    }

    function getAllChannelsByUser($username) {

        $user = $this->getUserByUsername($username);
        
        try {
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_channels WHERE id_user=:id_user');
			$st->execute( array('id_user' => $user->id ) );
		}
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        
        $res = array();
        while( $row = $st->fetch() ){
            $channel = new Channel( $row['id'], $row['id_user'], $row['name'] );
            array_push($res, $channel);
        }
        return $res;
    }

    function getAllChannels() {

        try {
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_channels' );
			$st->execute();
		}
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        
        $res = array();
        while( $row = $st->fetch() ){
            $channel = new Channel( $row['id'], $row['id_user'], $row['name'] );
            array_push($res, $channel);
        }
        return $res;
    }

    function getAllMessagesByUser($username){

        $user = $this->getUserByUsername($username);

        try {
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_messages WHERE id_user=:id_user ORDER BY date asc' );
			$st->execute(array('id_user' => $user->id));
		}
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        
        $res = array();
        while ( $row = $st->fetch() ){
            $message = new Message( $row['id'], $row['id_user'], $row['id_channel'], 
                $row['content'], $row['thumbs_up'],$row['date'] );
            array_push($res, $message);
        }
        return $res;
    }

    function getAllMessagesByChannel($id_channel) {
        
        try {
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_messages WHERE id_channel=:id_channel ORDER BY date asc' );
			$st->execute(array('id_channel' => $id_channel));
		}
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
        
		$res = array();
		while( $row = $st->fetch() ) {
			$message = new Message( $row['id'], $row['id_user'], $row['id_channel'], 
                $row['content'], $row['thumbs_up'],$row['date'] );
            array_push($res, $message);
		}
		return $res;
    }

    function startNewChannel($username, $name) {
        $user = $this->getUserByUsername($username);
        $channels = $this->getAllChannels;
        
       /* $max = 0;
        foreach($channels as $temp){
            if ($max < $temp->id)
                $max = $temp->id;  
        }
        $id = $max + 1;*/
        
        try {
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO dz2_channels(id_user, name) 
                                    VALUES (:id_user, :name)' );
			$st->execute( array( 'id_user' => $user->id, 'name' => $name ) ); 
		}
        catch( PDOException $e ) { exit( "PDO error: " . $e->getMessage() ); }
          
    }

    function getChannelById($id) {
        try {
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM dz2_channels WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

        $row = $st->fetch();
		if( $row === false )
			return null;
		else
            return new Channel( $row['id'], $row['id_user'], $row['name'] );
    }

    public function sendMessage($mess, $username, $id_channel){
        try {
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO dz2_messages(id_user, id_channel, content, thumbs_up, date) 
                                    VALUES (:id_user, :id_channel, :content, :thumbs_up, :date)' );
            $date = date('Y-m-d H:i:s');
            $st->execute( array( 'id_user' => $this->getUserByUsername($username)->id, 'id_channel' => $id_channel , 
                            'content' => $mess, 'thumbs_up' => 0, 'date' => $date) ); 
		}
        catch( PDOException $e ) { exit( "PDO error : " . $e->getMessage() ); }
    }

    public function thumbIncrease($id){
        try {
            $db = DB::getConnection();
            $st = $db->prepare('UPDATE dz2_messages SET thumbs_up = thumbs_up + 1 WHERE id=:id');
            $st->execute( array('id' => $id));
        }
        catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
    }
}


?>