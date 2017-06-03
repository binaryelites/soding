<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Task_model
 * @author Arif Majid <arif_avi@hotmail.com>
 */
Class Task_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function initTask()
    {
        $task = new stdClass();
        $task->task_id = null;
        $task->name = "";
        $task->description = "";
        return $task;
    }
    
    function getTaskList()
    {
        $this->db->select("t.*")
                 ->from("tasks t");
        
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result : false;
    }
    
    function getTaskInfo($taskId)
    {
        $this->db->select("t.*")
                 ->from("tasks t")
                 ->where("task_id", (int)$taskId);
        
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result : false;
    }
    
    function saveTask($task) 
    {
        try {
            $this->db->trans_begin();
            
            if(isset($task['task_id']) && (int)$task['task_id'] > 0){
                $this->db->where("task_id", $task['task_id'])
                         ->update("tasks", $task);
            }
            else {
                unset($task['task_id']);
                $this->db->insert("tasks", $task);
                $task['task_id'] = $this->db->insert_id();         
            }
            
            if($this->db->trans_status() === FALSE){                
                throw new Exception("could not save task ".__CLASS__."::".__FUNCTION__."::".__LINE__);
            }

            $this->db->trans_commit();
            return array(
                "success" => true,
                "task" => $task
            );
        }
        catch(Exception $e){
            $this->db->trans_rollback();
            return array(
                "success" => false,
                "msg" => $e->getMessage()
            );
        }
    }
    
    function deleteTask($taskId)
    {
        try {
            $this->db->trans_begin();
            
            $this->db->where("task_id", $taskId)
                     ->delete("tasks");
            
            if($this->db->trans_status() === FALSE){                
                throw new Exception("could not delete task ".__CLASS__."::".__FUNCTION__."::".__LINE__);
            }

            $this->db->trans_commit();
            return array(
                "success" => true
            );
        }
        catch(Exception $e){
            $this->db->trans_rollback();
            return array(
                "success" => false,
                "msg" => $e->getMessage()
            );
        }
        
    }
}

?>