<?php
class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {  
        $data = [
        'nama' => "Katalog Produk",
        'produk' => $this->ModelProduk->getproduk()->result(),
        ];
        //jika sudah login dan jika belum login10
        if ($this->session->userdata('email')) {
        $user = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['user'] = $user['nama'];
        $this->load->view('frontend/templates/header', $data);
        $this->load->view('frontend/templates/sidebar', $data);
        $this->load->view('frontend/produk/daftarproduk', $data);
        $this->load->view('frontend/templates/modal');
        $this->load->view('frontend/templates/footer', $data);
        } else {
        $data['user'] = 'Pengunjung';
        $this->load->view('frontend/templates/header', $data);
        $this->load->view('frontend/templates/sidebar', $data);
        $this->load->view('frontend/produk/daftarProduk', $data);
        $this->load->view('frontend/templates/modal');
        $this->load->view('frontend/templates/footer', $data);
        }
    }


    public function detailproduk()
    {
    $id = $this->uri->segment(3);
    $produk = $this->ModelProduk->joinKategoriproduk(['produk.id' => $id])->result();
    $data['user'] = "Pengunjung";
    $data['title'] = "Detail Produk";
    
    foreach ($produk as $fields) {
    $data['nama'] = $fields->nama_produk;
    $data['deskripsi'] = $fields->deskripsi;
    $data['kategori'] = $fields->kategori;
    $data['gambar'] = $fields->image;
    $data['ditransaksi'] = $fields->ditransaksi;
    $data['dibooking'] = $fields->dibooking;
    $data['harga'] = $fields->harga;
    $data['id'] = $id;
    }
  
    $this->load->view('frontend/templates/sidebar', $data);
    $this->load->view('frontend/produk/detail-produk', $data);

    $this->load->view('frontend/templates/footer', $data);
    }
}