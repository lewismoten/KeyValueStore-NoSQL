<?php
include 'configuration.php';

error_reporting(E_ERROR);
set_error_handler("onError", E_ALL);

function onError($number, $message, $file, $line) {
	showError($message);
}

function validateRequest() {

	$method = $_SERVER['REQUEST_METHOD'];

	if($method !== 'POST') {
		showError('expected method: post');
		exit;
	}


	$size = (int) $_SERVER['CONTENT_LENGTH'];

	if($size > 2048) {

		showError('too much data');
		exit;
	}

}

function getInput() {

	$input = file_get_contents("php://input");

	if($input === false) {

		showError('could not read input');
		exit;

	}

	$pair = json_decode($input);

	if($pair === null) {

		showError('json cannot be decoded');
		exit;

	}

	if(!isset($pair->key)) {
		showError('must provide key');
		exit;
	}

	if(strlen($pair->key) > 255) {

		showError('key is too long');
		exit;
	}

	if(isset($pair->value)) {
		if(strlen($pair->value) > 1024) {

			showError('value is too long');
			exit;
		}
	}

	return $pair;
}

function openDatabase() {

	$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if($db->connect_error) {

		showError('database connection failed');
		exit;
	}

	if($db->connect_errno) {

		showError($db->connect_errno());
		showError('database connection failed');
		exit;
	}

	if($db->error) {

		showError($db->error());
		showError('database connection failed');
		exit;
	}

	return $db;
}


function showError($message) {

	showHeaders();

	$error = new stdClass;
	$error->success = false;
	$error->message = $message;

	echo json_encode($error);
}

function showPair($key, $value) {

	showHeaders();

	$pair = new stdClass;
	$pair->success = true;
	$pair->key = $key;
	$pair->value = $value;

	echo json_encode($pair);

}

function showHeaders() {

	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');

}
?>