<?php require_once __DIR__ . '/_header.php'; ?>

<h2><?php echo "Poruke korisnika " . $_GET['name']; ?></h2><br>
<table>
	<tr>
        <th>Channel</th>
        <th>Message</th>
        <th>Link</th>
        <th>ThumbsUp</th>
        <th>Date</th>
    </tr>
    <?php 
        $link = "https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQnQ8oqj6VqrfyNvSyhWQ5ko6HLNg2N6FdiZ-m5n_LBGFVYSeew&usqp=CAU";
		foreach( $messages as $mes ) {
            $channel = $ser->getChannelById($mes->id_channel);
			echo '<tr>' .
                 '<td>' . $channel->name . '</td>' . 
                 '<td>'; ispis($mes->content); echo '</td>' .
                 '<td>' . '<a href="index.php?rt=message/theChannel&channel_id=' . $channel->id . '">Link</a>' . '</td>' .
                 '<td>' . $mes->thumbs_up . ' <a href="index.php?rt=message/userThumbUp&message_id='. $mes->id . '&name=' . $_GET['name'] .'"><img src="' . $link . '" height = "23" width="30"></a>' . '</td>' .
                 '<td>' . $mes->date . '</td>' .
			     '</tr>';
		}
	?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>