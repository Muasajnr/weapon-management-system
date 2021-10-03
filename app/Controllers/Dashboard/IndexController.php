<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\DocumentModel;
use App\Models\FirearmModel;

class IndexController extends BaseController
{
    public function index() {
        return redirect()->to('/dashboard/home');
    }

    public function home()
    {
        return view('dashboard/home/index', [
            'page_title' => 'Home'
        ]);
    }

    public function master()
    {
        return redirect()->to('/dashboard/master/jenis-inventaris');
    }

    public function inventory_types()
    {
        return view('dashboard/master/inventory_types/index', [
            'page_title' => 'Jenis Inventory'
        ]);
    }

    public function firearms_types()
    {
        return view('dashboard/master/firearms_types/index', [
            'page_title' => 'Jenis Senjata Api'
        ]);
    }

    public function firearms_brands()
    {
        return view('dashboard/master/firearms_brands/index', [
            'page_title' => 'Merk Senjata Api'
        ]);
    }

    public function stocks()
    {
        return view('dashboard/stock/index', [
            'page_title' => 'Data Stok Senjata'
        ]);
    }

    public function firearms()
    {
        return view('dashboard/firearms/index', [
            'page_title' => 'Data Senjata Api'
        ]);
    }

    public function firearms_add()
    {
        return view('dashboard/firearms/add', [
            'page_title' => 'Tambah Senjata Api'
        ]);
    }

    public function firearms_edit($id)
    {
        $firearmModel = new FirearmModel();
        $dataEditFirearm = $firearmModel->getDataEditFirearm($id);
        return view('dashboard/firearms/edit', [
            'page_title'    => 'Edit Senjata Api',
            'firearm_id'    => $id,
            'inventory_type'    => $dataEditFirearm->inventory_type,
            'inventory_type_id'    => $dataEditFirearm->inventory_type_id,
            'firearm_type'    => $dataEditFirearm->firearm_type,
            'firearm_type_id'    => $dataEditFirearm->firearm_type_id,
            'firearm_brand'    => $dataEditFirearm->firearm_brand,
            'firearm_brand_id'    => $dataEditFirearm->firearm_brand_id,
            'firearm_number'    => $dataEditFirearm->firearm_number,
            'bpsa_number'    => $dataEditFirearm->bpsa_number,
            'condition'    => $dataEditFirearm->condition,
            'description'    => $dataEditFirearm->description
        ]);
    }

    public function borrowings_ongoing()
    {
        return view('dashboard/borrowings/index', [
            'page_title' => 'Sedang dipinjam'
        ]);
    }

    public function borrowings_histori()
    {
        return view('dashboard/borrowings/history', [
            'page_title' => 'Histori'
        ]);
    }

    public function returnings()
    {
        return view('dashboard/returnings/index', [
            'page_title' => 'Pengembalian Senjata Api'
        ]);
    }

    public function documents()
    {
        return view('dashboard/documents/index', [
            'page_title' => 'Berita Acara'
        ]);
    }

    public function documents_add()
    {
        return view('dashboard/documents/add', [
            'page_title' => 'Tambah Berita Acara'
        ]);
    }

    public function documents_edit($id)
    {
        $documentModel = new DocumentModel();
        $documentEditData = $documentModel->getDocumentEditData($id);
        return view('dashboard/documents/edit', [
            'page_title' => 'Edit Berita Acara',
            'doc_id'    => $id,
            'doc_edit_data' => $documentEditData
        ]);
    }

    public function documents_show($id)
    {
        $documentModel = new DocumentModel();
        $documentData = $documentModel->getOne($id);
        return view('dashboard/documents/show', [
            'page_title' => 'Lihat Berita Acara',
            'doc_media' => $documentData->doc_media,
            'doc_name'  => $documentData->doc_name,
            'doc_ext'   => $documentData->uploaded_media_ext,
        ]);
    }

    public function reports()
    {
        return view('dashboard/report/index', [
            'page_title' => 'Laporan'
        ]);
    }

    public function users()
    {
        return view('dashboard/users/index', [
            'page_title' => 'Data User'
        ]);
    }
}
