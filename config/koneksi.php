<?php

$mysqli = new mysqli("localhost","root","","aplikasi-prediksi");

class penjualan{

	public $koneksi;


	function __construct($mysqli)
	{
		$this->koneksi = $mysqli;
	}

	function tampil(){

		$semua=array();

		$ambil = $this->koneksi->query("SELECT * FROM penjualan ORDER BY id_penjualan ASC");
		while($data = $ambil->fetch_assoc()){

			$semua[] = $data;
		}

		return $semua;
	}

	function sum_penjualan(){

		$ambil = $this->koneksi->query("SELECT SUM(penjualan) as jumlah_penjualan FROM penjualan ORDER BY id_penjualan ASC");
		$data = $ambil->fetch_assoc();
		return $data;
	}

	function sum_keuntungan(){

		$ambil = $this->koneksi->query("SELECT SUM(keuntungan) as jumlah_keuntungan FROM penjualan ORDER BY id_penjualan ASC");
		$data = $ambil->fetch_assoc();
		return $data;
	}


}

$penjualan = new penjualan($mysqli);