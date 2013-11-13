<?php

$json_value = '[[0.684700,0.661400,0.707100,0.637400,0.530300,0.718100,0.572800,0.649500,0.780600,0.728900,0.586300,0.649500,0.661400,0.572800,0.661400,0.750000,0.760300,0.649500,0.559000,0.515400],[-1.000000,0.586300,0.599500,0.484100,0.467700,-1.000000,0.414600,0.572800,0.625000,0.559000,0.467700,0.450700,0.530300,0.500000,0.572800,0.612400,0.661400,0.544900,0.450700,-1.000000],[-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,0.395300,-1.000000,-1.000000],[-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000,-1.000000]]';

$json = '[[17,19,17,29,15,17,16,1,1,0,28,29,29,7,11,2,3,3,30,30],[-1,17,19,17,29,-1,15,15,0,28,9,9,13,13,7,11,2,24,24,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,2,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]';

$aa = json_decode($json, 1); //4*20的数组
$vv = json_decode($json_value, 1);
$a = array(); //20*4的数组
$v = array(); //20*4的数组

//转成20*4的数组
for ($i=0; $i<20; $i++) {

	foreach ($aa as $key => $value) {
		
		$a[$i][] = $value[$i];
	}
	
	foreach ($vv as $key1 => $value1) {
		
		$v[$i][] = $value1[$i];
	}	
}


//用来装结果的数组
$r = array();

$flag = false;

//遍历
for ($i=0; $i<20; $i++) {

	//$tmp_1:  		当前优先
	//$tmp_2:  		下一位优先	
	//$tmp_0:  		当前单个		
	
	unset($tmp_0);
	unset($tmp_1);
	unset($tmp_2);
	
	for ($j = 0; $j < 3; $j++) {
	
		/*
		if ($i == 2 && $a[$i][$j] == 17) {
			
			$a[$i][$j] = -1;
			$v[$i][$j] = -1;
		}
		*/
	
		if ($a[$i][$j] != -1 && $i < 19 && ($key = array_search($a[$i][$j], $a[$i + 1])) !== false) {

			//if ($j > $key) {
			if ($v[$i][$j] < $v[$i+1][$key]) {
				
				//echo "(升)";
				//array_push($tmp, $a[$i][$j] . "(下一位优先)");
				
				if (!isset($tmp_2)) {
					
					$tmp_2 = $a[$i][$j];
					
					if ($i > 0 && $i < 17 && 
					array_search($tmp_2, $a[$i - 1]) !== false &&
					array_search($tmp_2, $a[$i + 1]) !== false &&
					array_search($tmp_2, $a[$i + 2]) !== false && 
					$r[$i] == $tmp_2) {
						
						unset($tmp_2);
					}
				}
			
			//} else if ($j < $key) {
			} else if ($v[$i][$j] > $v[$i+1][$key]) {
				
				//echo "(降)";
				//array_unshift($tmp, $a[$i][$j] . "(当前优先)");
				
				if (!isset($tmp_1)) {
					
					$tmp_1 = $a[$i][$j];
				}
			
			//} else if ($j == $key) {
			} else if ($v[$i][$j] == $v[$i+1][$key]) {
				
				if (!isset($tmp_2) && $r[$i] != $a[$i][$j]) {
									
					$tmp_2 = $a[$i][$j];
				}
				
				//echo "(平)";
				//array_unshift($tmp, $a[$i][$j] . "(看情况)");
				
				/*
				if (isset($tmp_1)) {
				
					$tmp_2 = $a[$i][$j];	
				
				} else {
					
					$tmp_1 = $a[$i][$j];
				}*/

				
				/*
				if ($v[$i][$j] <= $v[$i][$key]) {
					
					if (!isset($tmp_1))
						$tmp_1 = $a[$i][$j];
					
				} else {
					
					if (!isset($tmp_2))
						$tmp_2 = $a[$i][$j];
				}
				*/
				
			}
		
		} else if ($a[$i][$j] != -1) {
			
			//echo "(降)";
			//array_unshift($tmp, $a[$i][$j] . "(当前优先)");
			
			if (!isset($tmp_0) && $i > 0) {
			//if (!isset($tmp_0) && ) {
				
				if (array_search($a[$i][$j], $a[$i - 1]) === false && $j < 2) {
					
					$tmp_0 = $a[$i][$j];
					
				} else if (array_search($a[$i][$j], $a[$i - 1]) !== false && $r[$i-1] != $a[$i][$j] && $j < 2) {
					
					$tmp_0 = $a[$i][$j];
				}
			}
		}
	}
	
	if ($i == 14) {
		
		echo $tmp_1 . " : 1\n";
		echo $tmp_2 . " : 2\n";
		echo $tmp_0 . " : 0\n";
	}
	
	
	if (isset($tmp_1) && !isset($tmp_2) && isset($r[$i])) {
		
		$r[$i+1] = $tmp_1;
		unset($tmp_1);
	}	
	
	if (isset($tmp_1) && !isset($r[$i])) {
		
		$r[$i] = $tmp_1;
		unset($tmp_1);
	}
	
	if (isset($tmp_0) && !isset($r[$i])) {
		
		$r[$i] = $tmp_0;
		unset($tmp_0);
	}

	if (isset($tmp_2) && !isset($r[$i])) {
		
		$r[$i] = $tmp_2;
		unset($tmp_2);
	}
		
	if (!isset($r[$i])) {
		
		$r[$i] = $r[$i][0];
	}
	
	if (isset($tmp_2) && !isset($r[$i+1])) {
		
		$r[$i+1] = $tmp_2;
		unset($tmp_2);
	}

	/*
	if (isset($tmp[0]) && !isset($r[$i])) {
		
		$r[$i] = $tmp[0];
	}
	
	if (isset($tmp[1]) && !isset($r[$i+1])) {
			
		$r[$i+1] = $tmp[1];
	}
	
	if (!isset($r[$i])) {
			
		$r[$i] = 0;
	}
	
	echo $i . ":\n";
	print_r($tmp);
	*/
	
	
}


ksort($r);

print_r($r);

foreach ($r as $item) {
	
	printf("%02d-", $item);
}



/*

[17,17,25,17,29,29,29, 5, 5,31,29, 5, 0,27,13,28,12,29,29,16],
[-1,-1,19,25,17,30,30,29,15,15,31,29, 5, 0,28,15,-1,12,16,29],
[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,15,-1,-1],
[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]



正确的:
25, 17, 29, 30, 29, 5, 15, 31, 29, 5, 0, 27, 13, 28, 15, 12, 29, 16,
算出来的：
25, 17, 29, 30, 30, 5, 15, 15, 15, 15, 15, 15, 28, 28, 28, 29, 16, 16




*/







