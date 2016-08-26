<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeeModel extends CI_Model {

    public function all()
    {
        $result = $this->db->get('employees');
        return $result;
    }

    public function view()
    {
        $sql = $this->db->query("SELECT employee.emp_id, employee.emp_code, employee.emp_name, 
                                        employee.emp_birthdate, employee.dep_id, employee.pos_id, employees_department.dep_name, employees_position.pos_name, 
                                        employee.emp_note,  
                                        employee.emp_insert, employee.emp_update, employee.emp_user
                                        FROM employee 
                                        JOIN employees_department ON employee.dep_id=employees_department.dep_id 
                                        JOIN employees_position ON employee.pos_id=employees_position.pos_id ");
        return $sql;
    }

    /*public function insert_data($data)
    {
        $this->db->insert('employees', $data);
    }*/

    public function insert_data($data)
    {
        $this->db->insert('employee', $data);
    }

    public function find($id)
    {
        $row = $this->db->where('emp_id',$id)->limit(1)->get('employees');
        return $row;
    }

    public function create($data)
    {
        try{
            $this->db->insert('employees', $data);
            return true;
        }catch(Exception $e){
            return $e;
        }
    }

    public function update($id, $data)
    {
        try{
            $this->db->where('emp_id',$id)->limit(1)->update('employees', $data);
            return true;
        }catch(Exception $e){
            return $e;
        }
    }

    public function delete($id)
    {
        try {
            $this->db->where('emp_id',$id)->delete('employee');
            return true;
        }

        //catch exception
        catch(Exception $e) {
          echo $e->getMessage();
        }
    }

}