<?php
try{
	$dsn = 'mysql:dbname=stock;host=127.0.0.1';
	$username = 'root';
	$password = '19950510cl';
	$attr=[
	PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
	];
	$pdo=new PDO($dsn,$username,$password,$attr);
	$pdo->beginTransaction();
		try{
		    $num = $_POST['num'];
		    $sql = "update stock set stock = stock -:stock where id = 1";
	
		    $stmt = $pdo->prepare($sql);
		  //传入参数
		    $stmt->execute([':stock'=>$num]);
		    $sql='SELECT id,stock FROM 	`stock` WHERE id=1';
			$stmt = $pdo->query($sql);
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
		    if($result['stock'] < 0){
			   throw new Exception('库存不足');
			}else{
			   echo '成功';
			}
		  //提交事物，并且 数据库连接返回到自动提交模式
		 
		}catch(PDOException $e){
		    throw new Exception('执行失败'.$e->getMessage());
		    $pdo->rollback();
		}
	$pdo->commit();
}catch(Exception $e){
    echo $e->getMessage();
}


// 库存表
// CREATE TABLE `stock` (
//   `id` int(11) NOT NULL,
//   `stock` int(11) NOT NULL,
//   PRIMARY KEY (`id`)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

// INSERT INTO `stock` VALUES ('1', '2');
