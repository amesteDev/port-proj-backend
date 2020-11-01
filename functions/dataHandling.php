<?php

function countData($dataSet){
	$counted = count(get_object_vars($dataSet));
	return $counted;
}