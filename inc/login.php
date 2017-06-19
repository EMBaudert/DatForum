<form action="intern.php?p=login" method="POST"><br />
<table style="margin:10px;">
<tr>
<td>Benutzername:</td><td><input type="text" name="username" value="<?PHP if(isset($_POST["username"])){echo $_POST["username"]; }?>"></td>
</tr>
<tr>
<td>Passwort:</td><td><input type="password" name="password"></td>
</tr>
<tr>
<td></td><td align="right"><br><input type="submit" value="Anmelden"></td>
</tr>
</table>
</form>