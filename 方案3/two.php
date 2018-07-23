<?php
//接收用户请求的 
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis_name = 'stock';
    $num = 2;
    try{
    	for($i=0;$i<$num;$i++){
    		$count = $redis->lPop($redis_name);
    		if(!$count){
    			for($j=0;$j<$i;$j++){
    				$redis->rPush($redis_name,'1');
    			}
    			 throw new Exception('库存不足，请尝试减少数目'.$redis->lLen($redis_name).'');
    			}
    		}
    	
    }catch(Exception $e){
    	echo $e->getMessage();
    }