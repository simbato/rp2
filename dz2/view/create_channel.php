<?php require_once __DIR__ . '/_header.php'; ?>

<form action = "index.php?rt=channel/createNew" method = "post">
    Unesite ime kanala
    <input type = "text" name = "ime_kanala">
    <button type = "submit" name = "submit">Stvori kanal!</button>
</form>

<?php require_once __DIR__ . '/_footer.php'; ?>