# DatForum

Herzlich willkommen auf der Entwicklungsseite von unserem Forum!

# Allgemeines

Unser Forum ist sehr vielfältig einsetzbar und für alle Zwecke passend.

# Installation

Für die Funktion der Seite mit einem lokalen XAMPP-Server müssen für die Datenbank folgende Dinge beachtet werden:
* In der MySQL Konfig Datei my.ini müssen folgende Zeilen verändert werden (XAMPP v3.2.2):
* Zeile 30: basedir = "~PathToForum~/db/mysql"
* Zeile 32: datadir = "~PathToForum~/db/mysql/data"
* Zeile 137: innodb_data_home_dir = "~PathToForum~/db/mysql/data"
* Zeile 139: innodb_log_group_home_dir = "~PathToForum~/db/mysql/data"
Hierbei bezeichnet ~PathToForum~ den Dateipfad bis zum Stammverzeichnis, wo auch diese ReadMe liegt.

# Contributers

* Ruudii8
* EMBaudert

# Features

* Different Users
* Different Usergroups (Admin, Moderator)
* Profilansicht mit Änderungsmöglichkeiten
* Eigenes Profilbild
* Eiegene Signatur mit Formatierungszeichen (Fett/Italic/Unterstrichen/Durchgestrichen)
* Internes Nachrichtensystem in Echtzeit
* Impressum
* Registrieren mit Nutzungsbedingungen und Sicherheitsfrage
* Login nur alle 5 Sekunden möglich
* Login Merken Funktion über Cookies
* Sehr sichere Passwortverschlüsselung mit sha512
* Hintergrundmusik
* Vielzählige Sicherheitsvorkehrungen
* Skriptsicherheit von Benutzereingaben
* Zum Besuchen der Website muss Javascript aktiviert sein

* Menu with submenus
* Suchfunktion
* Threads with Answers and quotes
* Mail (Newsletter, Updates)

# Bemerkungen der Entwickler

In nahezu jedem Ordner befindet sich eine "index.php", die den Besucher auf die richtige Indexseite leitet, um sicher zu stellen, dass niemand die Ordnerstruktur durchsuchen kann.
Die erstellten Benutzer nutzen hauptsächlich zu Demonstrationszwecken. Zur leichteren Bedienung hier die wichtigsten Nutzerdaten:
user: Moderator pass: moderator
user: Admin pass: admin
user: SystemOfADoom pass: system
user: Rudi pass: *Leerzeichen*
user: MagicM pass: testpass1

# Bekannte Bugs

