<?php require_once __DIR__ . '/_header.php'; ?>

<table>
	<tr><th style = "width: 50px;">ID</th><th>ChannelName</th></tr>
	<?php 
		foreach( $channels as $channel )
		{
			echo '<tr>' .
                 '<td>' . $channel->id . '</td>' . 
                 '<td>' . '<a href="index.php?rt=message/theChannel&channel_id=' . $channel->id . '">' . $channel->name . '</a>' . '</td>' .
			     '</tr>';
		}
	?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>