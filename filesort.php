<?php
/*
* PHP外部排序实例
*/

$temp = 0;
$dataCount = 50000;//需排序的数的个数 默认50万
$lineNum = 100;
//生成数据
$fp = fopen('data.txt', 'w');
for($i=0; $i< $dataCount; $i++)
{
	while( $temp = rand(1000,10000000) )
	{
		fwrite($fp, $temp.',');
		if( $i>0 && $i % $lineNum == 0 ){
			fwrite($fp, "\r\n");
		}
		break;
	}
}
fclose($fp);

//排序开始
$time1 = time();
$data = array();
$fp = fopen('data.txt', 'r');
$first = 0;
$last = 0;
$flag = true;
$len = 0;
$countNum=0;
while( $line = fgets($fp))
{	
	$line = substr($line, 0, strlen($line)-3 );
	$line = explode(',',$line);
	foreach($line as $val){
		array_push($data, $val);
	}
	$len = count($data);
	if( $len>5000 )
	{
		$countNum += $len;
		//排序
		sort($data);//sortData($data, $len);
		if($flag)//第一次
		{
			$resFp = fopen('res.txt','w');
			$first = $data[0];
			$last = $data[$len-1];
			for($i=0; $i<$len; $i++)
			{
				fwrite($resFp, $data[$i].',');
				if($i>0 && $i % $lineNum == 0 ){
					fwrite($resFp, "\r\n");
				}
			}
			fflush($resFp);
			fclose($resFp);
			$flag = false;
		}
		else
		{
			sorthandle($data, $len, $first, $last, $lineNum);
		}
		unset($data);
		$data = array();
		$len = 0;
	}
	else{
		continue;
	}
}

if($len>0){
	$countNum += $len;
	//排序
	sort($data);//sortData($data, $len);
	sorthandle($data, $len, $first, $last, $lineNum);
}

echo "\n耗时：";
echo time()-$time1;
echo "\n实际：{$countNum} 个数";
$numCount = 0;
$resFp = fopen('res.txt','r');
while( $line=fgets($resFp))
{
	$line = substr($line, 0, strlen($line)-3);
	$line = explode(',', $line);
	$numCount += count($line);
}
echo "\n排序后: {$numCount} 个数\n";

//排序处理
function sorthandle(&$data, $len, &$first, &$last, $lineNum )
{	
	if( $data[$len-1]<=$first )//在左边
	{
		echo '左边--';
		$first = $data[0];

		$tFp = fopen('temp.txt','w');
		$i = 0;
		for($i=0; $i<$len; $i++)
		{
			fwrite($tFp, $data[$i].',');
			if( $i>0 && $i % $lineNum == 0 ){
				fwrite($tFp, "\r\n");
			}
		}
		$resFp = fopen('res.txt','r');
		while($line=fgets($resFp))
		{
			fwrite($tFp, $line);
		}
		fflush($tFp);
		fclose($resFp);
		fclose($tFp);
		copy('temp.txt','res.txt');
	}
	else if( $data[0]>=$last )//在右边
	{
		echo '右边--';
		$last = $data[$len-1];

		$resFp = fopen('res.txt','a+');
		$i = 0;
		for($i=0; $i<$len; $i++)
		{
			fwrite($resFp, $data[$i].',');
			if( $i>0 && $i % $lineNum == 0 ){
				fwrite($resFp, "\r\n");
			}
		}
		fflush($resFp);
		fclose($resFp);
	}
	else//交叉
	{
		echo '交叉--';
		if($first >$data[0]){
			$first = $data[0];
		}
		if($last<$data[$len-1]){
			$last=$data[$len-1];
		}

		if(!$tFp = fopen('temp.txt','w')){
			exit('打开文件失败!');
		}
		if( !$resFp = fopen('res.txt','r') ){
			exit('打开文件失败!');
		}
		$j = 0;
		$k = 0;	
		while( $line=fgets($resFp) )
		{
			$line = substr($line, 0, strlen($line)-3 );
			$line = explode(',',$line);
			$sLen = count($line);
			if($line[0]<=$data[$j] && $line[$sLen-1]>=$data[$j])
			{
				for($i=0; $i<count($line) && $j<$len; )//合并排序结果
				{
					if($line[$i]<=$data[$j])
					{
						fwrite($tFp, $line[$i].',');
						$i++;
					}
					else{
						fwrite($tFp, $data[$j].',');
						$j++;
					}
					$k++;
					if( $k%$lineNum == 0 ){
						fwrite($tFp, "\r\n");
					}
				}//end for
				if($j<$len){
					continue;
				}
				else{//$data 已结束
					for(; $i<count($line); $i++)
					{
						fwrite($tFp, $line[$i].',');
						$k++;
						if( $k%$lineNum == 0 ){
							fwrite($tFp, "\r\n");
						}
					}
					break;
				}
			}
			else{
				fwrite($tFp, implode(',', $line).",\r\n");
			}	
		}//end while
					
		if($j<$len){//文件已结束 $data 还有剩余
			for(;$j<$len;$j++){
				fwrite($tFp, $data[$j].',');
				$k++;
				if( $k%$lineNum==0 ){
					fwrite($tFp, "\r\n");
				}
			}
		}
		else if(!feof($resFp))//判断文件是否已经读取完毕
		{	
			while($line=fgets($resFp))
			{	
				fwrite($tFp, $line);
			}
		}
		fflush($tFp);
		fclose($tFp);
		fclose($resFp);
		copy('temp.txt','res.txt');
	}
}

//排序函数-插入排序
function sortData(&$data, $dataCount)
{
sort($data);
/*
$k = 0;
for($i=0; $i<$dataCount-1; $i++)
{
$k = $i ;
for($j=$i+1; $j<$dataCount; $j++)
{
if($data[$j]<$data[$k]){
$k = $j;
}
else{
continue;
}
}
if($k != $i){
$temp = $data[$i];
$data[$i] = $data[$k];
$data[$k] = $temp;
}
}
*/
}

