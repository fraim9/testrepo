<?php
echo 'Просрочнные паспорта<br>';


$conn = mysqli_connect('localhost', 'root', 'rt56gHjaaa@9', 'omnipos');
if (!$conn) {
	throw new ErrorException('Can\'t connect to DB');
}

mysqli_query($conn, 'TRUNCATE aml_expired_passport');

$fp = fopen('aml4.csv', 'r');
if (!$fp) {
	throw new ErrorException('Can\'t open the file');
}

$i = 0;
$values = array();
while ($row = fgetcsv($fp, null, ',')) {
	
	$values[] = '("' . addslashes($row[0]) . '", "' . addslashes($row[1]) . '")';
	
	if ($i++ > 10000) {
		$sql = 'INSERT INTO aml_expired_passport (`series`, `number`) VALUES ' . implode(',', $values);
		mysqli_query($conn, $sql);
		if (mysqli_errno($conn)) {
			echo $sql;
			echo '<pre>';
			print_r(mysqli_error($conn));
			echo '</pre><br><br>';
			exit;
		}
		$i = 0;
		$values = array();
	}
}

mysqli_close($conn);


