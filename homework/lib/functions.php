<?php
// return a string of random text of a desired length
function random_text($count, $rm_similar = false)
{
    // create list of characters
    $chars = array_flip(array_merge(range(0, 9), range('A', 'Z')));

    // remove similar looking characters that might cause confusion
    if ($rm_similar)
    {
        unset($chars[0], $chars[1], $chars[2], $chars[5], $chars[8],
            $chars['B'], $chars['I'], $chars['O'], $chars['Q'],
            $chars['S'], $chars['U'], $chars['V'], $chars['Z']);
    }

    // generate the string of random text
    for ($i = 0, $text = ''; $i < $count; $i++)
    {
        $text .= array_rand($chars);
    }

    return $text;
}
// jump to pre page

function goback($notice)
{
  echo "<script type=\"text/javascript\">alert('$notice')</script>";
  echo "<script type=\"text/javascript\">history.go(-1)</script>";
} 
// jump to url
function gourl($notice,$url)
{
  echo "<script type=\"text/javascript\">alert('$notice')</script>";
  echo "<script type=\"text/javascript\">location.href='$url'</script>";
} 

function GetByCategoryId($id)
{
	$cid=mysql_query("SELECT NAME FROM YOVAE_CATEGORY WHERE CATEGORY_ID='$id'");
	$oc=mysql_fetch_object($cid);
	return $oc->NAME;
}
//截取utf8中文字符串
//$sourcestr 是要处理的字符串
//$cutlength 为截取的长度(即字数)
function cut_str($sourcestr,$cutlength)
{
$returnstr='';
$i=0;
$n=0;
$str_length=strlen($sourcestr);//字符串的字节数
while (($n<$cutlength) and ($i<=$str_length))
{
$temp_str=substr($sourcestr,$i,1);
$ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码
if ($ascnum>=224) //如果ASCII位高与224，
{
$returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符
$i=$i+3; //实际Byte计为3
$n++; //字串长度计1
}
elseif ($ascnum>=192) //如果ASCII位高与192，
{
$returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
$i=$i+2; //实际Byte计为2
$n++; //字串长度计1
}
elseif ($ascnum>=65 && $ascnum<=90) //如果是大写字母，
{
$returnstr=$returnstr.substr($sourcestr,$i,1);
$i=$i+1; //实际的Byte数仍计1个
$n++; //但考虑整体美观，大写字母计成一个高位字符
}
else //其他情况下，包括小写字母和半角标点符号，
{
$returnstr=$returnstr.substr($sourcestr,$i,1);
$i=$i+1; //实际的Byte数计1个
$n=$n+0.5; //小写字母和半角标点等与半个高位字符宽...
}
}
if ($str_length>$cutlength){
$returnstr = $returnstr . "...";//超过长度时在尾处加上省略号
}
return $returnstr;

}
function test($string)
{
	echo "<script type=\"text/javascript\">alert(".$string.")</script>";
	}
?>
