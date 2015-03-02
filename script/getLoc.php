<?php
$pdo = new PDO('sqlite:' . realpath('location.db'));

$id = (int) isset($_GET['id']) ? $_GET['id'] : 0;

$types = array(1 => 'country', 'state', 'city', 'region');
$data = array(
	'html' => '',
	'status' => '0',
	'type' => ''
);
$sql = "SELECT id, name FROM t_location WHERE parent_id={$id}";
$result = $pdo->query($sql, PDO::FETCH_KEY_PAIR)->fetchAll();

if (!empty($result)) {
	$data['status'] = '1';
	foreach ($result as $key => $name) {
		$data['html'] .= '<option value="' . $key . '">' . mb_convert_encoding($name, 'utf8', 'gbk') . '</option>';
	}
	
	$type = $pdo->query("SELECT type FROM t_location WHERE parent_id={$id} LIMIT 1", PDO::FETCH_COLUMN, 0)->fetchColumn();
	$data['type'] = $types[$type];
}

echo json_encode($data);