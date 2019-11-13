<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class BarberModel extends CI_Model 
{ 
    private $table = 'barbers'; 
    public $id; 
    public $name; 
    public $email; 
    public $phone; 
    public $rule = [ 
        [ 
            'field' => 'name', 
            'label' => 'name', 
            'rules' => 'required' 
        ], 
        [ 
            'field' => 'email', 
            'label' => 'email', 
            'rules' => 'required' 
        ],
        [ 
            'field' => 'phone', 
            'label' => 'phone', 
            'rules' => 'required' 
        ],
    ]; 
    public function Rules() { return $this->rule; } 
    
    // public function getAll() { return 
    //     $this->db->get('data_mahasiswa')->result(); 
    // } 
    
    public function store($request) { 
        $this->name = $request->name; 
        $this->email = $request->email; 
        $this->phone = $request->phone; 
        if($this->db->insert($this->table, $this)){ 
            return ['msg'=>'Berhasil','error'=>false];
        } 
        return ['msg'=>'Gagal','error'=>true]; 
    } 
    public function update($request,$id) { 
        $updateData = ['email' => $request->email, 'name' =>$request->name, 'phone' =>$request->phone]; 
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
} 
?>