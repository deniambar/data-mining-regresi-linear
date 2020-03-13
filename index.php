<?php include 'config/koneksi.php';

$data_penjualan = $penjualan->tampil();
$sum_penjualan = $penjualan->sum_penjualan();
$sum_keuntungan = $penjualan->sum_keuntungan();
$rata_penjualan = $sum_penjualan['jumlah_penjualan']/count($data_penjualan);
$rata_keuntungan = $sum_keuntungan['jumlah_keuntungan']/count($data_penjualan);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Prediksi Keuntungan</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body style="padding-top: 30px;">
  <div class="container">
    <div class="table-responsive">
      <h3>DATA PENJUALAN (Data Training)</h3>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>NO</th>
            <th>NAMA</th>
            <th>PENJUALAN</th>
            <th>KEUNTUNGAN</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data_penjualan as $key => $value): ?>
            <tr>
              <td><?php echo $key+1; ?></td>
              <td><?php echo $value['pedagang'] ?></td>
              <td><?php echo $value['penjualan'] ?></td>
              <td><?php echo $value['keuntungan'] ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <div class="table-responsive">
      <h3>DATA PREDIKSI KEUNTUNGAN PENJUALAN (Data RUMUS)</h3>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>NO</th>
            <th>NAMA</th>
            <th>PENJUALAN (X)</th>
            <th>KEUNTUNGAN (Y)</th>
            <th>x</th>
            <th>y</th>
            <th>X<sup>2</sup></th>
            <th>Y<sup>2</sup></th>
            <th>XY</th>
          </tr>
        </thead>
        <tbody>
          <?php $total_x2=0; ?>
          <?php $total_xy=0; ?>
          <?php foreach ($data_penjualan as $key => $value): ?>
            <tr>
              <td><?php echo $key+1; ?></td>
              <td><?php echo $value['pedagang'] ?></td>
              <td><?php echo $value['penjualan'] ?></td>
              <td><?php echo $value['keuntungan'] ?></td>
              <td><?php echo $x = $value['penjualan']-$rata_penjualan; ?></td>
              <td><?php echo $y = $value['keuntungan']-$rata_keuntungan; ?></td>
              <td><?php echo $x2 = pow($x, 2); ?></td>
              <td><?php echo pow($y, 2); ?></td>
              <td><?php echo $xy = $x*$y; ?></td>
            </tr>
            <?php $total_x2+=$x2; ?>
            <?php $total_xy+=$xy; ?>
          <?php endforeach ?>
          <?php
          $rata_xy = ($total_xy/count($data_penjualan));
          $rata_x2 = ($total_x2/count($data_penjualan));
          ?>
          <tr>
            <td colspan="2">Jumlah</td>
            <td><?php echo $sum_penjualan['jumlah_penjualan'] ?></td>
            <td><?php echo $sum_keuntungan['jumlah_keuntungan'] ?></td>
            <td></td>
            <td></td>
            <td><?php echo $total_x2 ?></td>
            <td></td>
            <td><?php echo $total_xy; ?></td>
          </tr>
          <tr>
            <td colspan="2">Rata-Rata</td>
            <td><?php echo $rata_penjualan; ?></td>
            <td><?php echo $rata_keuntungan; ?></td>
            <td></td>
            <td></td>
            <td><?php echo $rata_x2; ?></td>
            <td></td>
            <td><?php echo $rata_xy; ?></td>
          </tr>
          <tr>
            <td colspan="2">Nilai b</td>
            <td><?php echo $b = round($total_xy/$total_x2,2); ?></td>
          </tr>
          <tr>
            <td colspan="2">Nilai a</td>
            <?php $hasil = ($b*$rata_penjualan); ?>
            <td><?php echo $a = round(($rata_keuntungan-$hasil),2); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <p>Maka Rumus untuk mencari prediksi keuntungan berdasarkan penjualan berikutnya ialah : Y = <?php echo $a ?> + <?php echo $b ?>X</p>
    <form method="POST">
      <div class="form-group">
        <label>Jumlah Penjualan</label>
        <input type="number" class="form-control" name="jml_penjualan" step="any">
      </div>
      <button name="cek" class="btn btn-primary">Prediksi</button>
    </form>
    <?php
    if(isset($_POST['cek'])){

      echo 'Y = '. $a.' + '.$b.'X';
      echo "<br/>";
      echo 'Y = '. $a.' + '.$b.'('.$_POST['jml_penjualan'].')';
      $y = $a+($b*$_POST['jml_penjualan']);
      echo "<br/>";
      echo "Y = ".$y;
    }
    ?>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>