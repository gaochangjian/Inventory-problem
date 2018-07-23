<?php
//接收用户请求的 
   try{
	$dsn = 'mysql:dbname=stock;host=127.0.0.1';
	$username = 'root';
	$password = '19950510cl';
	$attr=[
	PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
	];
	$pdo=new PDO($dsn,$username,$password,$attr);

	$redis = new Redis();
	$redis -> connect('127.0.0.1',6379);
	$redis_name = "stock";

	$sql='SELECT id,stock FROM 	`stock` WHERE id=1';
	$stmt = $pdo->query($sql);
	$result=$stmt->fetch(PDO::FETCH_ASSOC);
	//设置库存数
   	$stock = $result['stock'];
   	//将库存数进行入队处理
   	for($i=0;$i<$stock;$i++){
   		$redis->lPush($redis_name,1);
   	}
	echo $redis->lLen($redis_name);
	$redis->close();

	}catch(Exception $e){
		echo $e->message();
	}