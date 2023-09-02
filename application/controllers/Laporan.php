<?php
defined('BASEPATH') or exit('No Direct script access allowed');
class Laporan extends CI_Controller
{
 function __construct()
 {
    parent::__construct();
 }
    public function laporan_produk()
    {
        $data['nama'] = 'Laporan Data Produk';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['produk'] = $this->ModelProduk->getproduk()->result_array();
        $data['kategori'] = $this->ModelProduk->getKategori()->result_array();
        $this->load->view('backend/templates/header', $data);
        $this->load->view('backend/templates/sidebar', $data);
        $this->load->view('backend/templates/topbar', $data);
        $this->load->view('backend/produk/laporan_produk', $data);
        $this->load->view('backend/templates/footer');
    }

    public function cetak_laporan_produk()
    {
        $data['produk'] = $this->ModelProduk->getproduk()->result_array();
        $data['kategori'] = $this->ModelProduk->getKategori()->result_array();
    
        $this->load->view('backend/produk/laporan_print_produk', $data);
    }

    public function laporan_produk_pdf()
    {
        {
            $data['produk'] = $this->ModelProduk->getproduk()->result_array();
          
            $this->load->view('backend/produk/laporan_pdf_produk', $data);
            $root       = $_SERVER['DOCUMENT_ROOT'];
            include $root."/furniture/application/third_party/dompdf/autoload.inc.php";
            $dompdf     = new Dompdf\Dompdf();
    
            $paper_size = 'A4'; // ukuran kertas
            $orientation = 'landscape'; //tipe format kertas portrait atau landscape
            $html = $this->output->get_output();
    
            $dompdf->set_paper($paper_size, $orientation);
            // Convert to PDF
            $dompdf->load_html($html);
            $dompdf->render();
          
            $dompdf->stream("laporan_data_produk.pdf", array('Attachment' => 0));
            //nama file pdf yang dihasilkan
        }
    }

    public function export_excel_produk()
    {
        $data = array( 'title' => 'Laporan Produk ',
        'produk' => $this->ModelProduk ->getproduk()->result_array());
        $this->load->view('backend/produk/export_excel_produk', $data);
    }

    public function laporan_transaksi()
    {
        $data['nama'] = 'Laporan Data Penjualan';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['laporan'] = $this->db->query("select * from transaksi p,detail_transaksi d, 
        produk b,user u where d.id_produk=b.id and p.id_user=u.id and p.no_transaksi=d.no_transaksi")->result_array();
        $this->load->view('backend/templates/header', $data);
        $this->load->view('backend/templates/sidebar');
        $this->load->view('backend/templates/topbar', $data);
        $this->load->view('backend/transaksi/laporan_transaksi', $data);
        $this->load->view('backend/templates/footer');
    }
   
    public function cetak_laporan_penjualan()
    {
        $data['laporan'] = $this->db->query("select * from transaksi p,detail_transaksi d, produk b,user u where d.id_produk=b.id and p.id_user=u.id
        and p.no_transaksi=d.no_transaksi")->result_array();
        $this->load->view('backend/transaksi/laporan_print_transaksi', $data);
    }
   
    public function laporan_penjualan_pdf()
    {
    {
    
        $data['laporan'] = $this->db->query("select * from transaksi p,detail_transaksi d,
        produk b,user u where d.id_produk=b.id and p.id_user=u.id
        and p.no_transaksi=d.no_transaksi")->result_array();

        $this->load->view('backend/transaksi/laporan_pdf_transaksi', $data);
        $root       = $_SERVER['DOCUMENT_ROOT'];
        include $root."/furniture/application/third_party/dompdf/autoload.inc.php";
        $dompdf     = new Dompdf\Dompdf();

        $paper_size = 'A4'; // ukuran kertas
        $orientation = 'landscape'; //tipe format kertas portrait atau landscape
        $html = $this->output->get_output();

        $dompdf->set_paper($paper_size, $orientation);
        // Convert to PDF
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream("laporan_data_penjualan.pdf", array('Attachment' => 0));
        //nama file pdf yang dihasilkan
        }
    }
   
    public function export_excel_penjualan()
    {
    $data = array( 'title' => 'Laporan Data Penjualan Produk',
    'laporan' => $this->db->query("select * from transaksi p,detail_transaksi d,
    produk b,user u where d.id_produk=b.id and p.id_user=u.id
    and p.no_transaksi=d.no_transaksi")->result_array());
    $this->load->view('backend/transaksi/export_excel_transaksi', $data);
    }
   
    public function laporan_anggota()
    {
    $data['nama'] = 'Laporan Data Anggota';
    $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
    $data['user'] = $this->ModelUser->getUser()->result_array();
    $this->load->view('backend/templates/header', $data);
    $this->load->view('backend/templates/sidebar', $data);
    $this->load->view('backend/templates/topbar', $data);
    $this->load->view('backend/user/laporan_anggota', $data);
    $this->load->view('backend/templates/footer');
    }
   
   public function cetak_laporan_anggota()
   {
       $data['user'] = $this->ModelUser->getUser()->result_array();
       
       $this->load->view('backend/user/laporan_print_anggota', $data);
   }
   
   public function laporan_anggota_pdf()
   {
       {
           $data['user'] = $this->ModelUser->getUser()->result_array();
   
           $this->load->view('backend/user/laporan_pdf_anggota', $data);
           $root       = $_SERVER['DOCUMENT_ROOT'];
           include $root."/furniture/application/third_party/dompdf/autoload.inc.php";
           $dompdf     = new Dompdf\Dompdf();
   
           $paper_size = 'A4'; // ukuran kertas
           $orientation = 'landscape'; //tipe format kertas portrait atau landscape
           $html = $this->output->get_output();
   
           $dompdf->set_paper($paper_size, $orientation);
           // Convert to PDF
           $dompdf->load_html($html);
           $dompdf->render();
         
           $dompdf->stream("laporan_data_anggota.pdf", array('Attachment' => 0));
           //nama file pdf yang dihasilkan
       }
   }
   
   public function export_excel_anggota()
   {
       $data = array( 'title' => 'Laporan Anggota',
       'user' => $this->ModelUser->getUser()->result_array());
       $this->load->view('backend/user/export_excel_anggota', $data);
   }

}