<?php if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
class Transaksi extends CI_Controller
{
public function __construct()
 {
    parent::__construct();
    cek_login();
    cek_user();
 }
 
    public function index()
    {
      $data['nama'] = "Data Transaksi Penjualan";
      $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
      $data['transaksi'] = $this->ModelTransaksi->joinData();
      $this->load->view('backend/templates/header', $data);
      $this->load->view('backend/templates/sidebar', $data);
      $this->load->view('backend/templates/topbar', $data);
      $this->load->view('backend/transaksi/data-transaksi', $data);
      $this->load->view('backend/templates/footer');
    }
    
    public function daftarBooking()
    {
    $data['nama'] = "Daftar Booking";
    $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
    $data['transaksi'] = $this->db->query("select*from booking")->result_array();
    $this->load->view('backend/templates/header', $data);
    $this->load->view('backend/templates/sidebar', $data);
    $this->load->view('backend/templates/topbar', $data);
    $this->load->view('backend/booking/daftar-booking', $data);
    $this->load->view('backend/templates/footer');
    }

    public function bookingDetail()
    {
    $id_booking = $this->uri->segment(3);
    $data['nama'] = "Booking Detail";
    $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
    $data['agt_booking'] = $this->db->query("select*from booking b, user u where b.id_user=u.id and b.id_booking='$id_booking'")->result_array();
    $data['detail'] = $this->db->query("select id_produk,nama_produk,deskripsi,harga from booking_detail d, produk b where d.id_produk=b.id and d.id_booking='$id_booking'")->result_array();
    $this->load->view('backend/templates/header', $data);
    $this->load->view('backend/templates/sidebar', $data);
    $this->load->view('backend/templates/topbar', $data);
    $this->load->view('backend/booking/booking-detail', $data);
    $this->load->view('backend/templates/footer');
    }

    public function transaksiAct()
    {
    $id_booking = $this->uri->segment(3);
    $lama = $this->input->post('lama', TRUE);
    $bo = $this->db->query("SELECT*FROM booking WHERE id_booking='$id_booking'")->row();
    $tglsekarang = date('Y-m-d');
    $no_transaksi = $this->ModelBooking->kodeOtomatis('transaksi', 'no_transaksi');
    $databooking = [
    'no_transaksi' => $no_transaksi,
    'id_booking' => $id_booking,
    'tgl_transaksi' => $tglsekarang,
    'id_user' => $bo->id_user,
    'tgl_kirim' => date('Y-m-d', strtotime('+' . $lama . ' days', strtotime($tglsekarang))),
    'total_bayar' => 0
    ];
    $this->ModelTransaksi->simpantransaksi($databooking);
    $this->ModelTransaksi->simpanDetail($id_booking, $no_transaksi);
    $total_bayar = $this->input->post('total_bayar', TRUE);
  
    //hapus Data booking yang produknya diambil untuk ditransaksi
    $this->ModelTransaksi->deleteData('booking', ['id_booking' => $id_booking]);
    $this->ModelTransaksi->deleteData('booking_detail', ['id_booking' => $id_booking]);
    //$this->db->query("DELETE FROM booking WHERE id_booking='$id_booking'");
    //update dibooking dan ditransaksi pada tabel produk saat produk yang dibookingdiambil untuk ditransaksi
    $this->db->query("UPDATE produk, detail_transaksi SET produk.ditransaksi=produk.ditransaksi+1, produk.dibooking=produk.dibooking-1 WHERE produk.id=detail_transaksi.id_produk");
    $this->session->set_flashdata('pesan', '<div class="alert alert-message alert-success" role="alert">Data Transaksi Berhasil Disimpan</div>');
    redirect(base_url() . 'transaksi');
    }

    public function ubahStatus()
   {
   $id_produk = $this->uri->segment(3);
   $no_transaksi = $this->uri->segment(4);
   $where = ['id_produk' => $this->uri->segment(3),];
   $tgl = date('Y-m-d');
   $status = 'Lunas';
   //update status menjadi kembali pada saat produk dikembalikan
   $this->db->query("UPDATE transaksi, detail_transaksi SET transaksi.status='$status', transaksi.tgl_kirim='$tgl' WHERE detail_transaksi.id_produk='$id_produk' AND transaksi.no_transaksi='$no_transaksi'");
   //update stok dan ditransaksi pada tabel produk
   $this->db->query("UPDATE produk, detail_transaksi SET produk.ditransaksi=produk.ditransaksi-1, produk.harga=produk.harga+1 WHERE produk.id=detail_transaksi.id_produk");
   $this->session->set_flashdata('pesan', '<div class="laert alert-message alert-success" role="alert"></div>'); 
   redirect(base_url('transaksi'));
   }

}