<?php 
use Restserver \Libraries\REST_Controller ; 
Class HairStyle extends REST_Controller{

    public function __construct(){ 
        header('Access-Control-Allow-Origin: *'); 
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE"); 
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding"); 
        parent::__construct(); $this->load->model('HairStyleModel'); $this->load->library('form_validation'); 
    } 
    public function index_get(){ 
        return $this->returnData($this->db->get('hairstyles')->result(), false); 
    } 
    public function index_post($id = null){ 
        $validation = $this->form_validation; 
        $rule = $this->HairStyleModel->rules(); 
        if($id == null){ 
            array_push($rule,
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
            ); 
        } else{ 
            array_push($rule, 
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
            ); 
        } 
        $validation->set_rules($rule); 
        if (!$validation->run()) { 
            return $this->returnData($this->form_validation->error_array(), true); 
        } 
        $hairstyle = new HairStyleData(); 
        $hairstyle->name = $this->post('name'); 
        $hairstyle->hair_pict = $this->post('hair_pict'); 
        if($id == null){ 
            $response = $this->HairStyleModel->store($hairstyle);
        }else{ 
            $response = $this->HairStyleModel->update($hairstyle,$id); 
        } 
        return $this->returnData($response['msg'], $response['error']); 
    } 
    public function index_delete($id = null){ 
        if($id == null){ 
            return $this->returnData('Parameter Id Tidak Ditemukan', true); 
        } 
        $response = $this->HairStyleModel->destroy($id); 
        return $this->returnData($response['msg'], $response['error']); 
    } 
    public function returnData($msg,$error){ 
        $response['error']=$error; 
        $response['message']=$msg; 
        return $this->response($response); 
    } 
} 
Class HairStyleData{ 
    public $name; 
    public $hair_pict; 
}