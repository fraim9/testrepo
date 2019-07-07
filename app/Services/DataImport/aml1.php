<?php
echo 'Список террористов<br>';

$xml = simplexml_load_file('aml1.xml', NULL, LIBXML_NOCDATA);
if (!$xml) {
	throw new ErrorException('Can\'t open XML file');
}

$conn = mysqli_connect('localhost', 'root', 'rt56gHjaaa@9', 'omnipos');
if (!$conn) {
	throw new ErrorException('Can\'t connect to DB');
}

mysqli_query($conn, 'TRUNCATE aml_terrorist');

function clearValue($value, $length = 0) 
{
	$value = str_replace(array('<![CDATA[', ']]>', "\r", "\n"), array('','', '', ''), (string) $value);
	return $length ? mb_substr($value, 0, $length) : $value;
}

function toAtom($date)
{
	if (!strlen($date)) {
		return null;
	}
	if (is_numeric($date)) {
		$dd[2] = $date;
		$dd[1] = 1;
		$dd[0] = 1;
	} else {
		$dd = explode('.', $date);
		if (count($dd) != 3) {
			return false;
		}
	}
	
	$year = intval($dd[2]);
	if (!$year) {
		return null;
	}
	$month = intval($dd[1]);
	$month = $month ? $month : 1;
	$day = intval($dd[0]);
	$day = $day ? $day : 1;
	
	return $year . '-' . $month . '-' . $day;
}

function store($conn, $row) 
{
	$fields = array_map(function($value) { return '`' . $value . '`'; }, array_keys($row));
	$values = array_map(function($value) { return '"' . addslashes($value) . '"'; }, $row);
	$sql = 'INSERT INTO aml_terrorist (' . implode(',', $fields) . ') VALUES (' . implode(',', $values) . ')';
	//echo $sql;
	mysqli_query($conn, $sql);
	if (mysqli_errno($conn)) {
		echo $sql;
		echo '<pre>';
		print_r(mysqli_error($conn));
		echo '</pre><br><br>';
	}
}


//echo 'Позиций в файле: ' . count($xml->TERRORISTS) . '<br>';


foreach ($xml->TERRORISTS as $obj) {
	$matches = array();
	$passport = clearValue($obj->PASSPORT);
	if ($passport && preg_match_all("/([0-9]{4}) ([0-9]{6})/", $passport, $matches)) {
		for ($i=0; $i<count($matches[0]); $i++) {
			
			$row = array();
			//$row->id = clearValue($obj->ID_NEW);
			$row['name'] = clearValue($obj->TERRORISTS_NAME, 150);
			$date = toAtom(clearValue($obj->BIRTH_DATE));
			if ($date) {
				$row['birth_date'] = $date;
			}
			$row['inn'] = clearValue($obj->INN, 12);
			$row['passport'] = clearValue($obj->PASSPORT, 255);
			
			$row['passport_series'] = $matches[1][$i];
			$row['passport_number'] = $matches[2][$i];
			
			$row['description'] = clearValue($obj->DESCRIPTION, 255);
			$row['address'] = clearValue($obj->ADDRESS, 255);
			$row['resolution'] = clearValue($obj->TERRORISTS_RESOLUTION, 255);
			$row['birth_place'] = clearValue($obj->BIRTH_PLACE, 150);
			
			store($conn, $row);
		}
	} else {
		$row = array();
		//$row->id = clearValue($obj->ID_NEW);
		$row['name'] = clearValue($obj->TERRORISTS_NAME, 150);
		$date = toAtom(clearValue($obj->BIRTH_DATE));
		if ($date) {
			$row['birth_date'] = $date;
		}
		$row['inn'] = clearValue($obj->INN, 12);
		$row['passport'] = clearValue($obj->PASSPORT, 255);
		
		$row['passport_series'] = '';
		$row['passport_number'] = '';
		
		$row['description'] = clearValue($obj->DESCRIPTION, 255);
		$row['address'] = clearValue($obj->ADDRESS, 255);
		$row['resolution'] = clearValue($obj->TERRORISTS_RESOLUTION, 255);
		$row['birth_place'] = clearValue($obj->BIRTH_PLACE, 150);
	
		store($conn, $row);
	}

}

// Composer autoloading
//include __DIR__ . '/../vendor/autoload.php';


mysqli_close($conn);


