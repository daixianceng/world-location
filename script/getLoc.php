<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=test', 'root', '');
$pdo->exec('SET NAMES UTF8');

$id = (int) isset($_GET['id']) ? $_GET['id'] : 0;

$data = array(
	'html' => '',
	'status' => '0',
	'type' => ''
);
$sql = "SELECT * FROM t_location WHERE parent_id={$id}";
$result = $pdo->query($sql);

if ($result && $result->rowCount() > 0) {
	$data['status'] = '1';
	foreach ($result as $row) {
		$data['html'] .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
		$data['type'] = $row['type'];
	}
}

echo json_encode($data);