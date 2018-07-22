<?php
try{
	$dsn = 'mysql:dbname=stock;host=127.0.0.1';
	$username = 'root';
	$password = '19950510cl';
	$attr=[
	PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
	];
	$pdo=new PDO($dsn,$username,$password,$attr);
	$sql='SELECT id,stock FROM 	`stock` WHERE id=1';
	$stmt = $pdo->query($sql);
	$result=$stmt->fetch(PDO::FETCH_ASSOC);
	if($result['stock'] > 0){
		$num = $_POST['num'];
		$result['stock'] = intval($result['stock']) - intval($num);
		$sql = 'UPDATE `stock` SET stock=:stock WHERE id =1';
		$stmt = $pdo->prepare($sql);//与处理
		try{
			$stmt= $stmt->execute([':stock'=>$result['stock']]);
		}catch(Exception $e){
			throw new Exception("已经没有库存了");
		}
		if($stmt){
	        	echo '成功';
	        }else{
	        	echo '失败';
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
//   `stock` int(11) unsigned DEFAULT NULL,
//   PRIMARY KEY (`id`)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

// INSERT INTO `stock` VALUES ('1', '2');
