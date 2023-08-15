<?php

namespace App\Modules\Api\Controllers;

use App\Core\ApiController;
use App\Modules\Api\Models\BeritaAcaraModel;
use CodeIgniter\HTTP\ResponseInterface;

class ApiBeritaAcaraController extends ApiController
{
    public function __construct()
    {
        $this->rules = [
            'nama'      => 'required',
            'nomor'    => 'required',
            'tanggal'      => 'required',
            'media'     => 'uploaded[media]|mime_in[media,image/png,image/jpeg,application/pdf]|max_size[media, 1536]',
            'keterangan'      => 'required',
        ];
        $this->messages = [
            'nama'      => ['required' => 'nama is required'],
            'nomor'    => ['required' => 'nomor is required'],
            'tanggal'      => ['required' => 'tanggal is required'],
            'media'     => [
                'uploaded'  => 'media wasn\'t uploaded',
                'mime_in'   => 'media invalid mime',
                'max_size'  => 'file size is too big', 
            ],
            'keterangan'      => ['required' => 'keterangan is required'],
        ];
    }

    // datatables
    public function datatables()
    {
        $draw               = $this->request->getPost('draw');
        $searchQuery        = $this->request->getPost('search');
        $length             = $this->request->getPost('length');
        $start              = $this->request->getPost('start');
        $order              = $this->request->getPost('order') ?? [];

        $resData            = [];

        $beritaAcaraModel   = new BeritaAcaraModel();
        $data               = $beritaAcaraModel->getDatatables($searchQuery['value'], $start, $length, $order);
        $recordsTotal       = $beritaAcaraModel->getTotalRecords($searchQuery['value'], $order);
        $recordsFiltered    = $beritaAcaraModel->getTotalFilteredRecords();

        $num = $start;
        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"$item->id\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"$item->id\">{$num}.";
            $row[]      = "{$item->nama}";
            $row[]      = "{$item->nomor}";
            $row[]      = "{$item->tanggal}";
            $row[]      = "{$item->keterangan}";
            $row[]      = "{$item->created_at}";
            $row[]      = $this->buildCustomActionButtons($item->id);

            $resData[] = $row;
        }

        $output = [
            'draw'  => $draw,
            'recordsTotal'  => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'  => $resData,
        ];

        return $this->respond($output, ResponseInterface::HTTP_OK);
    }

    // create berita acara
    public function create()
    {
        $validation = $this->validateData($this->request);
        if (!$validation['is_valid'])
            return $this->failValidationErrors($validation['errors']);

        $data['nama']    = $this->request->getPost('nama');
        $data['nomor']  = $this->request->getPost('nomor');
        $data['tanggal']    = $this->request->getPost('tanggal');
        $data['keterangan']    = $this->request->getPost('keterangan');

        $mediaFile   = $this->request->getFile('media');
        $filename = $this->generateFileName($mediaFile->getExtension(), 'beritaacara_');
        $data['file_full_path'] = 'uploads/beritaacara/'.$filename;
        $data['file_origin_name'] = $mediaFile->getClientName();
        $data['file_extension'] = $mediaFile->getExtension();
        $data['file_size'] = $mediaFile->getSize();

        $beritaAcaraModel = new BeritaAcaraModel();
        
        $loggedUser = $this->request->header('logged_user')->getValue();
        $beritaAcaraModel->setLoggedUsername($loggedUser);

        $isAdded = $beritaAcaraModel->createBeritaAcara($data);
        if (!$isAdded)
            return $this->fail('Terjadi kesalahan, gagal ditambahkan!');

        // upload a file
        $filepath = ROOTPATH.'public/uploads/beritaacara/';
        $mediaFile->move($filepath, $filename);

        return $this->respondCreated([
            'status'    => ResponseInterface::HTTP_CREATED,
            'message'   => 'Berita acara telah ditambahkan!'
        ]);
    }

    private function buildCustomActionButtons(int $id)
    {
        $showUrl = site_url('dashboard/beritaacara/'.$id.'/show');
        return "<div class=\"text-center\">
                    <a href=\"javascript:void(0)\" onclick=\"window.open('$showUrl', 'ShowDocument', 'width=800, height=1200')\" class=\"btn btn-primary btn-sm mr-2\"><i class=\"fas fa-eye\"></i></a>
                    <button type=\"button\" class=\"btn btn-info btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-pencil-alt\"></i></button>
                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-item-id=\"$id\"><i class=\"fas fa-trash\"></i></button>
                </div>";
    }
}
