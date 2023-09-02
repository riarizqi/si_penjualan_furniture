<?php
defined('BASEPATH') or exit('No direct script access allowed');

class produk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();
    }

    //manajemen produk
    public function index()
    {
        $data['nama'] = 'Data Produk';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['produk'] = $this->ModelProduk->getproduk()->result_array();
        $data['kategori'] = $this->ModelProduk->getKategori()->result_array();

        $this->form_validation->set_rules('nama_produk', 'nama produk', 'required|min_length[3]', [
            'required' => 'nama produk harus diisi',
            'min_length' => 'nama produk terlalu pendek'
        ]);
        $this->form_validation->set_rules('id_kategori', 'Kategori', 'required', [
            'required' => 'Nama deskripsi harus diisi',
        ]);
        $this->form_validation->set_rules('deskripsi', 'Nama deskripsi', 'required|min_length[3]', [
            'required' => 'Nama deskripsi harus diisi',
            'min_length' => 'Nama deskripsi terlalu pendek'
        ]);
     
        $this->form_validation->set_rules('harga', 'harga', 'required|numeric', [
            'required' => 'harga harus diisi',
            'numeric' => 'Yang anda masukan bukan angka'
        ]);

        //konfigurasi sebelum gambar diupload
        $config['upload_path'] = './assets/backend/img/upload/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '3000';
        $config['max_width'] = '1024';
        $config['max_height'] = '1000';
        $config['file_name'] = 'img' . time();

        $this->load->library('upload', $config);

        if ($this->form_validation->run() == false) {
            $this->load->view('backend/templates/header', $data);
            $this->load->view('backend/templates/sidebar', $data);
            $this->load->view('backend/templates/topbar', $data);
            $this->load->view('backend/produk/index', $data);
            $this->load->view('backend/templates/footer');
        } else {
            if ($this->upload->do_upload('image')) {
                $image = $this->upload->data();
                $gambar = $image['file_name'];
            } else {
                $gambar = '';
            }

            $data = [
                'nama_produk' => $this->input->post('nama_produk', true),
                'id_kategori' => $this->input->post('id_kategori', true),
                'deskripsi' => $this->input->post('deskripsi', true),
                'harga' => $this->input->post('harga', true),
                'ditransaksi' => 0,
                'dibooking' => 0,
                'image' => $gambar
            ];

            $this->ModelProduk->simpanproduk($data);
            redirect('produk');
        }
    }

    public function hapusproduk()
    {
        $where = ['id' => $this->uri->segment(3)];
        $this->ModelProduk->hapusproduk($where);
        redirect('produk');
    }

    public function ubahproduk()
    {
        $data['nama'] = 'Ubah Data Produk';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['produk'] = $this->ModelProduk->produkWhere(['id' => $this->uri->segment(3)])->result_array();
        $kategori = $this->ModelProduk->joinKategoriproduk(['produk.id' => $this->uri->segment(3)])->result_array();
        foreach ($kategori as $k) {
            $data['id'] = $k['id_kategori'];
            $data['k'] = $k['kategori'];
        }
        $data['kategori'] = $this->ModelProduk->getKategori()->result_array();

        $this->form_validation->set_rules('nama_produk', 'nama produk', 'required|min_length[3]', [
            'required' => 'nama produk harus diisi',
            'min_length' => 'nama produk terlalu pendek'
        ]);
        $this->form_validation->set_rules('id_kategori', 'Kategori', 'required', [
            'required' => 'Nama deskripsi harus diisi',
        ]);
        $this->form_validation->set_rules('deskripsi', 'Nama deskripsi', 'required|min_length[3]', [
            'required' => 'Nama deskripsi harus diisi',
            'min_length' => 'Nama deskripsi terlalu pendek'
        ]);
       
        $this->form_validation->set_rules('harga', 'harga', 'required|numeric', [
            'required' => 'harga harus diisi',
            'numeric' => 'Yang anda masukan bukan angka'
        ]);

        //konfigurasi sebelum gambar diupload
        $config['upload_path'] = './assets/backend/img/upload/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '3000';
        $config['max_width'] = '1024';
        $config['max_height'] = '1000';
        $config['file_name'] = 'img' . time();

        //memuat atau memanggil library upload
        $this->load->library('upload', $config);

        if ($this->form_validation->run() == false) {
            $this->load->view('backend/templates/header', $data);
            $this->load->view('backend/templates/sidebar', $data);
            $this->load->view('backend/templates/topbar', $data);
            $this->load->view('backend/produk/ubah_produk', $data);
            $this->load->view('backend/templates/footer');
        } else {
            if ($this->upload->do_upload('image')) {
                $image = $this->upload->data();
                unlink('assets/backend/img/upload/' . $this->input->post('old_pict', TRUE));
                $gambar = $image['file_name'];
            } else {
                $gambar = $this->input->post('old_pict', TRUE);
            }

            $data = [
                'nama_produk' => $this->input->post('nama_produk', true),
                'id_kategori' => $this->input->post('id_kategori', true),
                'deskripsi' => $this->input->post('deskripsi', true),
                'harga' => $this->input->post('harga', true),
                'image' => $gambar
            ];

            $this->ModelProduk->updateproduk($data, ['id' => $this->input->post('id')]);
            redirect('produk');
        }
    }

    //manajemen kategori
    public function kategori()
    {
        $data['nama'] = 'Kategori Produk';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['kategori'] = $this->ModelProduk->getKategori()->result_array();

        $this->form_validation->set_rules('kategori', 'Kategori', 'required', [
            'required' => 'nama produk harus diisi'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('backend/templates/header', $data);
            $this->load->view('backend/templates/sidebar', $data);
            $this->load->view('backend/templates/topbar', $data);
            $this->load->view('backend/produk/kategori', $data);
            $this->load->view('backend/templates/footer');
        } else {
            $data = [
                'kategori' => $this->input->post('kategori', TRUE)
            ];

            $this->ModelProduk->simpanKategori($data);
            redirect('backend/produk/kategori');
        }
    }

    public function ubahKategori()
    {
        $data['nama'] = 'Ubah Data Kategori';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['kategori'] = $this->ModelProduk->kategoriWhere(['id' => $this->uri->segment(3)])->result_array();


        $this->form_validation->set_rules('kategori', 'Nama Kategori', 'required|min_length[3]', [
            'required' => 'Nama Kategori harus diisi',
            'min_length' => 'Nama Kategori terlalu pendek'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('backend/templates/header', $data);
            $this->load->view('backend/templates/sidebar', $data);
            $this->load->view('backend/templates/topbar', $data);
            $this->load->view('backend/produk/ubah_kategori', $data);
            $this->load->view('backend/templates/footer');
        } else {

            $data = [
                'kategori' => $this->input->post('kategori', true)
            ];

            $this->ModelProduk->updateKategori(['id' => $this->input->post('id')], $data);
            redirect('backend/produk/kategori');
        }
    }

    public function hapusKategori()
    {
        $where = ['id' => $this->uri->segment(3)];
        $this->ModelProduk->hapusKategori($where);
        redirect('backend/produk/kategori');
    }
}
