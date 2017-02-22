<?php session_start(); ?>
<html>
<head>
    <title>ChangeLogger &copy; 2007</title>
</head>

<div align="center"><fieldset>Change Logger</fieldset></div>
<fieldset>
<legend>Changelogger Form</legend>
<div name="changelogger_form" align="center">

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
<p name="version_para">
Version:
    <select name="version">
        <option value="Alpha (0.0.0-1)">Alpha
        <option value="Beta 1 (0.0.1-5)">Beta I
        <option value="Beta 2 (0.0.5-5)">Beta II
        <option value="Charlie (0.1.5-5)">Charlie
        <option value="Release Candidate 1 (0.5.5-5)">Release I
        <option value="Stable (1.0.0-0)">Stable
    </select> <br \>
</p>

<p name="category_para">
Change Category:
    <select name="category">
        <option value="Design (Database)">Design (Database)
        <option value="Filesystem Layout">Filesystem Layout
        <option value="Design (Site)">Design (Site)
        <option value="Web Engine">Web Engine
        <option value="Core Engine">Core Engine
        <option value="Admin Area">Admin Area
        <option value="Client Area">Client Area
        <option value="Services">Services
        <option value="Testing Environment">Testing Environment
    </select> <br \>
</p>

<p name="title_para">
Change Title:
<input type="text" name="change_title"> <br \>
</p>

<p name="notes_para">
Change Notes:
<textarea name="change_notes">

</textarea> <br \> <br \>
</p>

<input type="submit" name="submit" value="Update Changelog">
</form>
<br>
<a href="CHANGELOG">CHANGELOG</a>

</div>
</fieldset>
</html>

<?php
if (@$_POST['submit'])
{
    $handle = fopen("CHANGELOG", "a+");
    fwrite($handle, sprintf("######################################\n# %s  %s        #\n######################################\n Category: %s \n %s \n %s \n ************************** \n", @$_POST[version], date('Y-d-m'),@$_POST[category], strtoupper(@$_POST[change_title]), @$_POST[change_notes])."\n");
    fclose($handle);
} else { ;}
?>