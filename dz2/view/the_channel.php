<?php require_once __DIR__ . '/_header.php'; ?>

<h2><?php echo $channel->name; ?></h2>
<table>
	<tr>
        <th>Username</th>
        <th>Message</th>
        <th>ThumbsUp</th>
        <th>Date</th>
    </tr>
    <?php 
        $link = "https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQnQ8oqj6VqrfyNvSyhWQ5ko6HLNg2N6FdiZ-m5n_LBGFVYSeew&usqp=CAU";
		foreach( $messages as $mes ) {
            echo '<tr>' .
                '<td>' . $ser->getUserById($mes->id_user)->username . '</td>' . 
                '<td>'; ispis($mes->content); echo '</td>' .
                '<td>' . $mes->thumbs_up . ' <a href="index.php?rt=message/channelThumpUp&message_id='. $mes->id .'"><img src="' . $link . '" height = "23" width="30"></a></td>' .
                '<td>' . $mes->date . '</td>' .
                '</tr>';
		}
	?>
</table>
<form action = "index.php?rt=message/theChannel" method = "post">
    New message
    <input type = "text" name = "nova_poruka">
    <button type = "submit" name = "submit", value = <?php echo $channel->id; ?>>Send</button>
</form>

<?php require_once __DIR__ . '/_footer.php'; ?>