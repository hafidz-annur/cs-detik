<?php
require_once 'config.php';
require_once 'helper/validasi.php';
// https://www.indonetsource.com/cara-membuat-rest-api-dengan-php-native-dan-mysql

if (!empty($_GET['function'])) {
   // GET DATA 
   if($_GET['function']=='transaction'){
      get_transaction();
   } 
   // INSERT DATA 
   if($_GET['function']=='create'){
      save_transaction();
   } 
}

function get_last_transaction()
{
   global $connect;
   $query = $connect->query("SELECT * FROM user_transaction ORDER BY references_id DESC LIMIT 1");
   $row = mysqli_fetch_object($query);
   return $row->references_id;
}

function get_transaction()
{
   global $connect;
   if (!empty($_GET['ref_id']) && !empty($_GET['merc_id'])) {
      $ref_id = $_GET['ref_id'];
      $merc_id = $_GET['merc_id'];

      $query = $connect->query("SELECT * FROM user_transaction WHERE references_id=$ref_id AND merchant_id=$merc_id ORDER BY created DESC");
   } else if (!empty($_GET['ref_id']) && empty($_GET['merc_id'])) {
      $ref_id = $_GET['ref_id'];

      $query = $connect->query("SELECT * FROM user_transaction WHERE references_id=$ref_id ORDER BY created DESC");
   } else if (empty($_GET['ref_id']) && !empty($_GET['merc_id'])) {
      $merc_id = $_GET['merc_id'];

      $query = $connect->query("SELECT * FROM user_transaction WHERE merchant_id=$merc_id ORDER BY created DESC");
   } else if (empty($_GET['ref_id']) && empty($_GET['merc_id'])) {
      $query = $connect->query("SELECT * FROM user_transaction ORDER BY created DESC");
   }

   if ($query && mysqli_num_rows($query) > 0) {
      $index = 0;
      while ($row = mysqli_fetch_object($query)) {
         $data[$index]['references_id'] = $row->references_id;
         $data[$index]['invoice_id'] = $row->invoice_id;
         $data[$index]['status'] = $row->status;

         $index++;
      }

      $response = array(
         'message' => 'success',
         'data' => $data,
      );
   } else {
      $response = array(
         'message' => 'failed',
         'data' => null
      );
   }


   header('Content-Type: application/json');
   echo json_encode($response);
}

function save_transaction()
{
   global $connect;
   $validasi = [
      'item_name' => ['required'],
      'merchant_id' => ['required', 'numeric', 'max_length:4'],
      'amount' => ['required', 'numeric', 'max_length:4'],
      'payment_type' => ['required'],
      'customer_name' => ['required', 'min_length:4']
   ];

   $valid = validasi($validasi);
   $new_id = get_last_transaction() + 1;

   if ($valid['error'] == null) {

      $item_name = trim($_POST['item_name']);
      $merchant_id = trim($_POST['merchant_id']);
      $amount = trim($_POST['amount']);
      $payment_type = trim($_POST['payment_type']);
      $customer_name = trim($_POST['customer_name']);
      $status = 'pending';
      $created = date('Y-m-d H:i:s');

      $invoice_id = 'inv/' . date('m') . '/' . date('Y') . '/' . $new_id;

      // number va akan terisi random jika payment typenya virtual account
      $payment_type == 'virtual_account' ? $number_va = rand(1111111111, 9999999999) : $number_va = '-';

      $result = mysqli_query($connect, "INSERT INTO user_transaction SET
               invoice_id = '$invoice_id',
               item_name = '$item_name',
               merchant_id = '$merchant_id',
               amount = '$amount',
               payment_type = '$payment_type',
               customer_name = '$customer_name',
               number_va = '$number_va',
               status = '$status',
               created = '$created',
               updated = '$created'");


      if ($result) {
         $response = array(
            'message' => 'success',
            'data' => [
               'references_id' => $new_id,
               'number_va' => $number_va,
               'status' => $status
            ],
         );
      } else {
         $response = array(
            'message' => 'failed',
            'error' => [$connect->error],

         );
      }
   } else {
      $response = array(
         'message' => 'failed',
         'data' => $valid,
      );
   }

   header('Content-Type: application/json');
   echo json_encode($response);
}

function update_transaction($ref_id, $status) 
{
   global $connect;
   $updated = date('Y-m-d H:i:s');
   $result = mysqli_query($connect, "UPDATE user_transaction SET
               status = '$status',
               updated = '$updated'
               WHERE references_id='$ref_id'");

   if($result){
      return 1;
   } else {
      return $connect->error;
   }
}

function get_transaction_by_id($id) 
{
   global $connect;
   $query = $connect->query("SELECT * FROM user_transaction WHERE references_id=$id");

   if($query){
      return 1;
   } else {
      return 0;
   }
}