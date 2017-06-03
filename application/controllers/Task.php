<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {

    function index()
    {
        $this->load->model("task_model");            
        $data['result'] = $this->task_model->getTaskList();
        
        
        $data['body_template'] = "list.php";
        $this->load->view('site_template.php', $data);
    }
    
    function form($task_id = NULL)
    {
        $this->load->model("task_model");
        
        $data['taskInfo'] = $this->task_model->initTask();
        if((int)$task_id > 0){            
            $result = $this->task_model->getTaskInfo($task_id);            
            if($result){
                $data['taskInfo'] = $result->row();
            }
        }
                
        $data['body_template'] = "form.php";
        $this->load->view('site_template.php', $data);
    }
    
    function save($task_id = null)
    {
        $task = $this->input->post(NULL,true);
        
        $this->load->library("form_validation");
        
        $this->form_validation->set_data($task);
        $this->form_validation->set_rules("name", "Name", "trim|xss_clean|required");
        $this->form_validation->set_rules("description", "Description", "trim|xss_clean|required");
        
        if($this->form_validation->run() == FALSE){
            $json = array(
                "success" => false,
                "msg" => validation_errors("", "")
            );
            
            echo json_encode($json);
            die();
        }
        
        $task['task_id'] = (int)$task_id;
        
        $this->load->model("task_model");
        $result = $this->task_model->saveTask($task);
        
        echo json_encode($result);
        die();
    }
    
    function delete($task_id = null)
    {
        if((int)$task_id <= 0){
            $json = array(
                "success" => true,
                "msg" => "no task id defined"
            );
            
            echo json_encode($json);
            die();
        }
        
        $this->load->model("task_model");
        $result = $this->task_model->deleteTask($task_id);
        
        echo json_encode($result);
        die();
    }
}
