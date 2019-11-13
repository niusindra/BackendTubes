<?php 
use Restserver \Libraries\REST_Controller ; 
Class Barber extends REST_Controller{

    public function __construct(){ 
        header('Access-Control-Allow-Origin: *'); 
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE"); 
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding"); 
        parent::__construct(); $this->load->model('BarberModel'); $this->load->library('form_validation'); 
    } 
    public function index_get(){ 
        return $this->returnData($this->db->get('barbers')->result(), false); 
    } 
    public function index_post($id = null){ 
        $validation = $this->form_validation; 
        $rule = $this->BarberModel->rules(); 
        if($id == null){ 
            array_push($rule,
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
            ); 
        } else{ 
            array_push($rule, [ 
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
            ); 
        } 
        $validation->set_rules($rule); 
        if (!$validation->run()) { 
            return $this->returnData($this->form_validation->error_array(), true); 
        } 
        $barber = new BarberData(); 
        $barber->nama = $this->post('nama'); 
        $barber->phone = $this->post('phone'); 
        $barber->email = $this->post('email'); 
        if($id == null){ 
            $response = $this->BarberModel->store($barber);
        }else{ 
            $response = $this->BarberModel->update($barber,$id); 
        } 
        return $this->returnData($response['msg'], $response['error']); 
    } 
    public function index_delete($id = null){ 
        if($id == null){ 
            return $this->returnData('Parameter Id Tidak Ditemukan', true); 
        } 
        $response = $this->BarberModel->destroy($id); 
        return $this->returnData($response['msg'], $response['error']); 
    } 
    public function returnData($msg,$error){ 
        $response['error']=$error; 
        $response['message']=$msg; 
        return $this->response($response); 
    } 
} 
Class BarberData{ 
    public $name; 
    public $phone; 
    public $email; 
}