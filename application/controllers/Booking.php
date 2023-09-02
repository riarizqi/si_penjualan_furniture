<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');
date_default_timezone_set('Asia/Jakarta');
class Booking extends CI_Controller
{
 public function __construct()
 {
 parent::__construct();
 cek_login();
 $this->load->model(['ModelBooking', 'ModelUser']);
 }
 public function index()
 {
 $id = ['bo.id_user' => $this->uri->segment(3)];
 $id_user = $this->session->userdata('id_user');
 $data['booking'] = $this->ModelBooking->joinOrder($id)->result();
 $user = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
 foreach ($user as $a) {
 $data = [
 'image' => $user['image'],
 'user' => $user['nama'],
 'email' => $user['email'],
 'tanggal_input' => $user['tanggal_input']
 ];
 }
 $dtb = $this->ModelBooking->showtemp(['id_user' => $id_user])->num_rows();
 if ($dtb < 1) {
 $this->session->set_flashdata('pesan', '<div class="alert alert-massege alert-danger" role="alert">Tidak Ada Produk dikeranjang</div>');
 redirect(base_url());
 } else {
 $data['temp'] = $this->db->query("select image, nama_produk, deskripsi, id_produk from temp where id_user='$id_user'")->result_array();
 }
 $data['nama'] = "Data Booking";
 $this->load->view('frontend/templates/header');
 $this->load->view('frontend/templates/sidebar', $data);
 $this->load->view('frontend/booking/data-booking', $data);
 $this->load->view('frontend/templates/modal');
 $this->load->view('frontend/templates/footer');
 }

 public function tambahBooking()
 {
 $id_produk = $this->uri->segment(3);
 //memilih data produk yang untuk dimasukkan ke tabel temp/keranjang melalui variabel $isi
 $d = $this->db->query("Select*from produk where id='$id_produk'")->row();
 //berupa data2 yang akan disimpan ke dalam tabel temp/keranjang
 $isi = [
 'id_produk' => $id_produk,
 'nama_produk' => $d->nama_produk,
 'id_user' => $this->session->userdata('id_user'),
 'email_user' => $this->session->userdata('email'),
 'tgl_booking' => date('Y-m-d H:i:s'),
 'image' => $d->image,
 'harga' => $d->harga
 ];
 //cek apakah produk yang di klik booking sudah ada di keranjang
 $temp = $this->ModelBooking->getDataWhere('temp', ['id_produk' => $id_produk])->num_rows();
 $userid = $this->session->userdata('id_user');
 //cek jika sudah memasukan 3 produk untuk dibooking dalam keranjang
 $tempuser = $this->db->query("select*from temp where id_user ='$userid'")->num_rows();
 //cek jika masih ada booking produk yang belum diambil
 $databooking = $this->db->query("select*from booking where id_user='$userid'")->num_rows();
 if ($databooking > 0) {
 $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">
 Masih Ada booking produk sebelumnya yang belum diambil.<br> Ambil produk yang dibooking atau tunggu 1x24 Jam 
 untuk bisa booking kembali </div>');
 redirect(base_url());
 }
 //jika produk yang diklik booking sudah ada di keranjang
 if ($temp > 0) {
 $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">
 produk ini Sudah anda booking </div>');
 redirect(base_url() . 'home');
 }
 //jika produk yang akan dibooking sudah mencapai 3 item
 if ($tempuser == 3) {
 $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">
 Booking produk Tidak Boleh Lebih dari 3</div>');
 redirect(base_url() . 'home');
 }
 //membuat tabel temp jika belum ada
 $this->ModelBooking->createTemp();
 $this->ModelBooking->insertData('temp', $isi);
 //pesan ketika berhasil memasukkan produk ke keranjang
 $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">
 produk berhasil ditambahkan ke keranjang </div>');
 redirect(base_url() . 'home');
 }

 public function hapusbooking()
 {
 $id_produk = $this->uri->segment(3);
 $id_user = $this->session->userdata('id_user');
 
 $this->ModelBooking->deleteData(['id_produk' => $id_produk], 'temp');
 $kosong = $this->db->query("select*from temp where id_user='$id_user'")->num_rows();
 if ($kosong < 1) {
 $this->session->set_flashdata('pesan', '<div class="alert alert-massege alert-danger" role="alert">
 Tidak Ada produk dikeranjang</div>');
 redirect(base_url());
 } else {
 redirect(base_url() . 'booking');
 }
 }
 
 public function bookingSelesai($where)
 {
 //mengupdate harga dan dibooking di tabel produk saat proses booking diselesaikan
 $this->db->query("UPDATE produk, temp SET produk.dibooking=produk.dibooking+1, 
 produk.harga=produk.harga-1 WHERE produk.id=temp.id_produk");
 $tglsekarang = date('Y-m-d');
 $isibooking = [
 'id_booking' => $this->ModelBooking->kodeOtomatis('booking', 'id_booking'),
 'tgl_booking' => date('Y-m-d H:m:s'),
 'batas_bayar' => date('Y-m-d', strtotime('+2 days', strtotime($tglsekarang))),
 'id_user' => $where
 ];
 //menyimpan ke tabel booking dan detail booking, dan mengosongkan tabel temporari
 $this->ModelBooking->insertData('booking', $isibooking);
 $this->ModelBooking->simpanDetail($where);
 $this->ModelBooking->kosongkanData('temp');
 redirect(base_url() . 'booking/info');
 }

 public function info()
 {
 $where = $this->session->userdata('id_user');
 $data['user'] = $this->session->userdata('nama');
 $data['nama'] = "Selesai Booking";
 $data['useraktif'] = $this->ModelUser->cekData(['id' => $this->session->userdata('id_user')])->result();
 $data['items'] = $this->db->query("select*from booking bo, booking_detail d, 
 produk bu where d.id_booking=bo.id_booking and d.id_produk=bu.id and bo.id_user='$where'")->result_array();

 $this->load->view('frontend/templates/sidebar', $data);
 $this->load->view('frontend/booking/info-booking', $data);

 $this->load->view('frontend/templates/footer');
 }

 public function exportToPdf()
 {
     $id_user = $this->session->userdata('id_user');
     $data['user'] = $this->session->userdata('nama');
     $data['judul'] = "Cetak Bukti Booking";
     $data['useraktif'] = $this->ModelUser->cekData(['id' => $this->session->userdata('id_user')])->result();
     $data['items'] = $this->db->query("select*from booking bo, booking_detail d, produk bu where d.id_booking=bo.id_booking and d.id_produk=bu.id and bo.id_user='$id_user'")->result_array();
     
     $sroot 		= $_SERVER['DOCUMENT_ROOT'];
     include $sroot."/furniture/application/third_party/dompdf/autoload.inc.php";
     $dompdf = new Dompdf\Dompdf();

     $this->load->view('frontend/booking/bukti-pdf', $data);

     $paper_size  = 'A4'; // ukuran kertas
     $orientation = 'landscape'; //tipe format kertas potrait atau landscape
     $html = $this->output->get_output();
 
     $dompdf->set_paper($paper_size, $orientation);
     // //Convert to PDF
     $dompdf->load_html($html);
     $dompdf->render();
     $dompdf->stream("bukti-booking-$id_user.pdf", array('Attachment' => 0));
     // // nama file pdf yang di hasilkan
 }



}