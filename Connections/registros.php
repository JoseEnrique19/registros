<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_registros = "y0nkiij6humroewt.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$database_registros = "ayr7fonkn1nockhg";
$username_registros = "q8pcye2wm8ixc7j8";
$password_registros = "ccr6wah0i64dkryx";
$registros = mysql_pconnect($hostname_registros, $username_registros, $password_registros) or trigger_error(mysql_error(),E_USER_ERROR); 
?>