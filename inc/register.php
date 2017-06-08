<h1>Registrieren</h1>
<form action="intern.php?p=register" method="POST"><br />
<table>
<tr>
<td>Benutzername:</td><td><input type="text" name="username" value="<?PHP if(isset($_SESSION["username"])){echo $_SESSION["username"]; }?>"></td>
</tr>
<tr>
<td>Vorname:</td><td><input type="text" name="firstname" value="<?PHP if(isset($_SESSION["firstname"])){echo $_SESSION["firstname"]; }?>"></td>
</tr>
<tr>
<td>Nachname:</td><td><input type="text" name="secondname" value="<?PHP if(isset($_SESSION["secondname"])){echo $_SESSION["secondname"]; }?>"></td>
</tr>
<tr>
<td>E-Mail Adresse:</td><td><input type="text" name="email" value="<?PHP if(isset($_SESSION["email"])){echo $_SESSION["email"]; }?>"></td>
</tr>
<tr>
<td>Passwort:</td><td><input type="password" name="password"></td>
</tr>
<tr>
<td>Passwort wiederholen:</td><td><input type="password" name="password2"></td>
</tr>
<tr>
<td></td><td><br><input type="submit" value="Registrieren"></td>
</tr>
</table>
</form>