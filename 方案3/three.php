<?php

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
		$redis_name = 'stock';

		$num = $redis->lLen($redis_name);
		$sql = "update stock set stock = :stock where id = 1";
		
		$stmt = $pdo->prepare($sql);
		$stmt->execute([':stock'=>$num]);
		$redis->close();
	}catch(Exception $e){
		echo $e->message();
	}