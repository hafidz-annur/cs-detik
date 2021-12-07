#!/usr/bin/php
<?php
require_once "api.php";

// untuk menambahkan ref id 
function insert_ref()
{
    echo "welcome! \n";
    echo "please fill in the references id : ";
    $ref_id = trim(fgets(STDIN));

    return $ref_id;
}

// untuk menambahkan status yang akan diinput
function insert_status()
{
    echo "------------------------- \n";
    echo "select status of transaction \n";
    echo "------------------------- \n";
    echo "[1] Pending \n";
    echo "[2] Paid \n";
    echo "[3] Failed \n";
    echo "------------------------- \n";
    $status = trim(fgets(STDIN));
    return $status;
}

// check data transaksi terlebih dahulu
function check_ref_id($ref_id)
{
    $check = get_transaction_by_id($ref_id);
    if ($check == 1) {
        $step2 = insert_status();
        check_number($ref_id, $step2);
    } else {
        echo "------------------------- \n";
        echo "oops, reference id is not found \n";
        echo "------------------------- \n";
        run();
    }
}

// check status adalah number 
function check_number($ref_id, $status)
{
    echo "------------------------- \n";
    echo "reference id = " . $ref_id . "\n";
    echo "------------------------- \n";
    
    $status_data = ['pending', 'paid', 'failed'];
    if (is_numeric($status)) {
        if ($status > 3 || $status == 0) {
            echo "------------------------- \n";
            echo "oops, please select beetwen 1 - 3 only \n";
            echo "------------------------- \n";
            check_ref_id($ref_id);
        } else {
            update_transaction($ref_id, $status_data[$status - 1]);
            echo "------------------------- \n";
            echo "reference id " . $ref_id . " successfully updated \n";
            echo "------------------------- \n";
        }
    } else {
        echo "------------------------- \n";
        echo "oops, please input with numeric only \n";
        echo "------------------------- \n";
        check_ref_id($ref_id);
    }
}

function run()
{
    $data = insert_ref();
    check_ref_id($data);
}

run();