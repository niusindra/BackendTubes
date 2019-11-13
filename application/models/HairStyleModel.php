<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class HairStyleModel extends CI_Model 
{ 
    private $table = 'hairstyles'; 
    public $id; 
    public $name; 
    public $hair_pict; 
    public $rule = [ 
        [ 
            'field' => 'name', 
            'label' => 'name', 
            'rules' => 'required' 
        ], 
        // [ 
        //     'field' => 'hair_pict', 
        //     'label' => 'hair_pict', 
        //     'rules' => 'required' 
        // ], 
    ]; 
    public function Rules() { return $this->rule; } 
    
    // public function getAll() { return 
    //     $this->db->get('data_mahasiswa')->result(); 
    // } 
    
    public function store($request) { 
        $this->name = $request->name; 
        $this->hair_pict = $this->_uploadImage(); 
        if($this->db->insert($this->table, $this)){ 
            return ['msg'=>'Berhasil','error'=>false];
        } 
        return ['msg'=>'Gagal','error'=>true]; 
    } 
    public function update($request,$id) { 
        $updateData = ['hair_pict' => $request->hair_pict, 'name' =>$request->name]; 
        if($this->db->where('id',$id)->update($this->table, $updateData)){ 
            return ['msg'=>'Berhasil','error'=>false]; 
        } 
        return ['msg'=>'Gagal','error'=>true]; 
    } 
        
    public function destroy($id){ 
        if (empty($this->db->select('*')->where(array('id' => $id))->get($this->table)->row())) 
        return ['msg'=>'Id tidak ditemukan','error'=>true]; 
        if($this->db->delete($this->table, array('id' => $id))){ 
            return ['msg'=>'Berhasil','error'=>false]; 
        } 
        return ['msg'=>'Gagal','error'=>true]; 
    } 

    private function _uploadImage()
    {
        $config['upload_path']          = './upload/hair_pict/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']            = $this->name;
        $config['overwrite']			= true;
        $config['max_size']             = 1024; // 1MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('hair_pict')) {
            return $this->upload->data("file_name");
        }
        else{
            return "default.jpg";
        }
        
        
    }
} 
?>