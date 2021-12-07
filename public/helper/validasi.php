<?php
// https://jagongoding.com/web/php/web-dinamis/validasi-data-form-part-1/

function validasi(array $listInput)
{
    # variabel berisi inputan baik dari metode POST mau pun GET
    $request = $_REQUEST;

    $data['error'] = [];
    # perulangan untuk array terluar (berisi nama input)
    foreach ($listInput as $input => $listValidator) {
        # perulangan untuk sub array (berisi nama peraturan)
        foreach ($listValidator as $validasi) {
            if ($validasi === 'required') {
                $lolos = Required($request[$input]);

                if(!$lolos) {
                    $data['error'][$input][] = 'this '.$input.' field is required';
                }
            } else if ($validasi === 'numeric') {
                $lolos = Numeric($request[$input]);

                if(!$lolos) {
                    $data['error'][$input][] = 'this '.$input.' field must be numeric';
                }
            } else if (substr($validasi,0,10) === 'min_length') {
                $min = (int)substr($validasi,11);
                $lolos = MinLength($request[$input], $min);

                if(!$lolos) {
                    $data['error'][$input][] = 'this '.$input.' field must be at least '.$min.' characters';
                }
            } else if (substr($validasi,0,10) === 'max_length') {
                $max = (int)substr($validasi,11);
                $lolos = MaxLength($request[$input], $max);

                if(!$lolos) {
                    $data['error'][$input][] = 'this '.$input.' field must be a maximum '.$max.' characters';
                }
            } 
        }
    }

    return $data;
}

function Required($nilai)
{
    return (bool) @$nilai;
}

function Numeric($nilai)
{
    return is_numeric($nilai);
}

function MinLength($nilai, $min) {
    if(strlen($nilai)>=$min) {
        return true;
    } else {
        return false;
    }
}

function MaxLength($nilai, $max) {
    if(strlen($nilai)<=$max) {
        return true;
    } else {
        return false;
    }
}