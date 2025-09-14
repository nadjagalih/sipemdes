<?php
date_default_timezone_set('Asia/Jakarta');
require_once "SqlInjeksi.php";

$host = "localhost";
// $username = "sipemdes_pemde5ag4lek";
// $password = "eH(s_gOj+vz&";
$username = "root";
$password = "";
$database = "sipemdes_dbpemd3sa";


$db = mysqli_connect($host, $username, $password, $database);

if (!$db) {
  die("Koneksi database gagal: " . mysqli_connect_error());
}

$val = new cek_sql_injeksi;

function sql_injeksi($data)
{
  global $db;
  $firewall = mysqli_real_escape_string($db, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
  return $firewall;
}

function sql_url($url)
{
  global $db;
  $firewall_url = mysqli_real_escape_string($db, stripslashes(strip_tags(htmlspecialchars(preg_replace('/[^A-Za-z0-9]/', ' ', $url, ENT_QUOTES)))));
  return $firewall_url;
}
