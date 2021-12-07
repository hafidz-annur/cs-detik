# Case Study - Detik.com

### Tutorial
<ol>
  <li>Clone file github di folder xampp/htdocs (windows) || /opt/lampp/htdocs (Linux)</li>
  <li>Buka dan jalankan <strong>xampp</strong></li>
  <li>Jalankan apache dan mysql</li>
  <li>Buka localhost/phpmyadmin</li>
  <li>Buatlah database dengan name cs_detik</li>
</ol>

### Cara migrasi database dan menambahkan data dummy
<ol>
  <li>Masuk visual studio code</li>
  <li>Tambahkan folder <b>cs-detik</b> ke workspace</li>
  <li>Klik kanan folder -> buka terminal atau bisa buka dari command line dan masuk ke folder <b>cs-detik</b></li>
  <li>ketik di command / terminal untuk migrasi database,
    
    vendor/bin/phinx migrate -e development
  </li>
  <li>ketik di command / terminal untuk menambahkan data dummy,
    
    vendor/bin/phinx seed:run -e development
  </li>
</ol>

### End Point - Rest API
<table>
  <tr style="width:100%">
    <th>No</th>
    <th>Description</th>
    <th>End Point</th>
    <th>Method</th>
    <th>Params</th>
  </tr>
  <tr style="width:100%">
    <td>1</td>
    <td>Mengambil semua data transaksi</td>
    <td>http://127.0.0.1/cs-detik/public/api.php?function=transaction</td>
    <td>GET</td>
    <td>-</td>
  </tr>
  <tr style="width:100%">
    <td>2</td>
    <td>Mengambil data transaksi berdasarkan reference id</td>
    <td>http://127.0.0.1/cs-detik/public/api.php?function=transaction&ref_id={ref_id}</td>
    <td>GET</td>
    <td>-</td>
  </tr>
  <tr style="width:100%">
    <td>3</td>
    <td>Mengambil data transaksi berdasarkan merchant id</td>
    <td>http://127.0.0.1/cs-detik/public/api.php?function=transaction&merc_id={merc_id}</td>
    <td>GET</td>
    <td>-</td>
  </tr>
  <tr style="width:100%">
    <td>4</td>
    <td>Mengambil data transaksi berdasarkan reference id dan merchant id</td>
    <td>http://127.0.0.1/cs-detik/public/api.php?function=transaction&ref_id={ref_id}&merc_id={merc_id}</td>
    <td>GET</td>
    <td>-</td>
  </tr>
  <tr style="width:100%">
    <td>5</td>
    <td>Menambahkan data transaksi baru</td>
    <td>http://127.0.0.1/cs-detik/public/api.php?function=transaction/create</td>
    <td>POST</td>
    <td>
    <ul>
        <li>item_name</li>
        <li>merchant_id</li>
        <li>customer_name</li>
        <li>amount</li>
        <li>payment_type</li>
      </ul>
    </td>
  </tr>
</table>
