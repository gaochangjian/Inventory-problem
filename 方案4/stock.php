<?php
try{
	$dsn = 'mysql:dbname=stock;host=127.0.0.1';
	$username = 'root';
	$password = '19950510cl';
	$attr=[
	PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
	];
	$pdo=new PDO($dsn,$username,$password,$attr);
	$sql='SELECT id,stock,version FROM 	`stock` WHERE id=1';
	$stmt = $pdo->query($sql);
	$result=$stmt->fetch(PDO::FETCH_ASSOC);
	if($result['stock'] > 0){
		$num = 1;
		var_dump($num);
		$result['stock'] = intval($result['stock']) - intval($num);
		var_dump($result['stock']);
		//乐观锁的实现
		$sql = 'UPDATE `stock` SET stock=:stock,version=:version+1 WHERE id =1 and version =:version';
		
		$stmt = $pdo->prepare($sql);
		$stmt= $stmt->execute([':stock'=>$result['stock'],':version'=>$result['version']]);
		if($stmt){
	        	echo '购买成功';
	        }else{
	        	echo '购买失败，请重试';
	        }
        
	}else{
		throw new Exception("已经没有库存了");
		
	}

}catch(Exception $e){
   echo $e->getMessage();
}


// 库存表
// CREATE TABLE `stock` (
//   `id` int(11) NOT NULL,
//   `stock` int(11) NOT NULL,
//   `version` int(11)
//   PRIMARY KEY (`id`)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

// INSERT INTO `stock` VALUES ('1', '2');
