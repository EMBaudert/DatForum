<h1>Login</h1>
<form action="intern.php?p=login" method="POST"><br />
<table>
<tr>
<td>Benutzername:</td><td><input type="text" name="username" value="<?PHP if(isset($_POST["username"])){echo $_POST["username"]; }?>"></td>
</tr>
<tr>
<td>Passwort:</td><td><input type="password" name="password"></td>
</tr>
<tr>
<td></td><td><br><input type="submit" value="Anmelden"></td>
</tr>
</table>
</form>