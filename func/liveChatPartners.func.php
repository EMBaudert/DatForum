<?PHP

#Diese Seite aktualisiert die Chatpartner auf der linken Seite im Nachrichtensystem in Echtzeit

require_once 'prepareSQL.func.php'; #Wird in message.func.php ben�tigt
require_once 'message.func.php';    #F�r die Aktualisierung ben�tigt

   echo getChatPartners($_GET["uid"]); #Funktion gibt den Code f�r die Chatpartner zur�ck, "uid" wirde diesem Dokument �bergeben

?>