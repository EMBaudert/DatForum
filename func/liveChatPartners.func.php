<?PHP

#Diese Seite aktualisiert die Chatpartner auf der linken Seite im Nachrichtensystem in Echtzeit

require_once 'prepareSQL.func.php'; #Wird in message.func.php benötigt
require_once 'message.func.php';    #Für die Aktualisierung benötigt

   echo getChatPartners($_GET["uid"]); #Funktion gibt den Code für die Chatpartner zurück, "uid" wirde diesem Dokument übergeben

?>