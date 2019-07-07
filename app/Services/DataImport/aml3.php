<?php
echo 'Счета в списке блокировок<br>';

$xml = simplexml_load_file('aml3.xml', NULL, LIBXML_NOCDATA);
if (!$xml) {
	throw new ErrorException('Can\'t open XML file');
}

$conn = mysqli_connect('localhost', 'root', 'rt56gHjaaa@9', 'omnipos');
if (!$conn) {
	throw new ErrorException('Can\'t connect to DB');
}

mysqli_query($conn, 'TRUNCATE aml_person_blocked');

function clearValue($value, $length = 0) 
{
	$value = str_replace(array('<![CDATA[', ']]>', "\r", "\n"), array('','', '', ''), (string) $value);
	$value = preg_replace('/\s+/', ' ', $value);
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
	$values = array_map(function($value) { return ($value === null) ? 'NULL' : '"' . addslashes($value) . '"'; }, $row);
	$sql = 'INSERT INTO aml_person_blocked (' . implode(',', $fields) . ') VALUES (' . implode(',', $values) . ')';
	//echo $sql;
	mysqli_query($conn, $sql);
	if (mysqli_errno($conn)) {
		echo $sql;
		echo '<pre>';
		print_r(mysqli_error($conn));
		echo '</pre><br><br>';
	}
}


foreach ($xml->СписокАктуальныхРешений->Решение as $subjectList) {
	
	if (!$subjectList->СписокСубъектов) {
		continue;
	}
	
	foreach ($subjectList->СписокСубъектов->Субъект as $obj) {
		
		//echo '<pre>';
		//print_r($obj);
		//echo '</pre>';
		
		$row = array();
		$faceType = '';
		
		// Юр Лицо
		if ($obj->ТипСубъекта->Идентификатор == 1) {
			$faceType = 'legal';
			
			$row['name'] = clearValue($obj->ЮЛ->Наименование, 150);
			$row['name_lat'] = clearValue($obj->ЮЛ->НаименованиеЛат, 150);
		}
		
		
		// Физ Лицо
		if ($obj->ТипСубъекта->Идентификатор == 2) {
			$faceType = 'natural';
			
			$row['name'] = clearValue($obj->ФЛ->ФИО, 150);
			$row['name_lat'] = clearValue($obj->ФЛ->ФИОЛат, 150);
			$row['inn'] = clearValue($obj->ФЛ->ИНН, 12);
			
			if ($obj->ФЛ->ДатаРождения) {
				$row['birth_date'] = clearValue($obj->ФЛ->ДатаРождения);
			}
			if ($obj->ФЛ->МестоРождения) {
				$row['birth_place'] = clearValue($obj->ФЛ->МестоРождения, 150);
			}
			
			if ($obj->ФЛ->СписокДрНаименований->ДрНаименование) {
				$altNames = array();
				foreach ($obj->ФЛ->СписокДрНаименований->ДрНаименование as $altName) {
					$altNames[] = clearValue($altName->ФИО);
				}
				$row['name_alt'] = clearValue(count($altNames) ? implode(', ', $altNames) : '', 255);
			}
			
			if ($obj->ФЛ->СписокДокументов->Документ) {
				$docs = array();
				foreach ($obj->ФЛ->СписокДокументов->Документ as $doc) {
					$d = new stdClass();
					$d->series = clearValue($doc->Серия);
					$d->number = clearValue($doc->Номер);
					$d->date = clearValue($doc->ДатаВыдачи);
					$d->issued = clearValue($doc->ОрганВыдачи, 150);
					$docs[] = $d;
				}
				$row['docs'] = $docs;
			}
		}
		
		if ($obj->СписокАдресов->Адрес) {
			$addresses = [];
			foreach ($obj->СписокАдресов->Адрес as $address) {
				$addresses[] = clearValue($address->ТекстАдреса);
			}
			$row['address'] = clearValue(count($addresses) ? implode(', ', $addresses) : '', 255);
		}
		
		$row['resolution'] = clearValue($obj->РешениеПоСубъекту, 255);
		$row['description'] = clearValue($obj->Примечание, 255);
		
		//echo '<pre>';
		//print_r($row);
		//echo '</pre>';
		
		if ($faceType == 'legal') {
			store($conn, $row);
		}
		
		if ($faceType == 'natural') {
			if (isset($row['docs'])) {
				$docs = $row['docs'];
				unset($row['docs']);
				foreach ($docs as $doc) {
					$row['passport_series'] = $doc->series ? $doc->series : null;
					$row['passport_number'] = $doc->number ? $doc->number : null;
					$row['passport_issued_date'] = strlen($doc->date) ? $doc->date : null;
					$row['passport_issued_by'] = $doc->issued ? $doc->issued : null;
					store($conn, $row);
				}
			} else {
				store($conn, $row);
			}
		}
	}
	
	
	
}


mysqli_close($conn);


