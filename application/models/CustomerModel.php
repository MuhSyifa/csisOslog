<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerModel extends CI_Model {

	public function getData()
	{
		return $this->db->get('customer');
	}	

	public function getDetailData()
	{
		return $this->db->query("SELECT * FROM customer WHERE cust_type_id='1' order by cust_id DESC");
	}

    public function getCustPerson()
    {
        $sql=$this->db->query("SELECT customer_personal.cust_personal_id, customer_personal.cust_code, customer_personal.cust_name, 
                                customer_personal.cust_birth_date, customer_personal.cust_type_id, customer_personal.cust_gender, 
                                customer_personal.cust_religion_id, customer_personal.cust_personal_email,
                                customer_personal.cust_personal_phone, customer_personal.cust_personal_mobile_phone, customer_personal.cust_personal_address, 
                                customer_personal.cust_start_date_contract, customer_personal.cust_end_date_contract, customer_personal.cust_personal_insert, 
                                customer_personal.cust_personal_update, customer_personal.cust_personal_user, customer_personal.status,

                               (SELECT customer_religion.cust_religion_name FROM customer_religion WHERE customer_religion.cust_religion_id = customer_personal.cust_religion_id),
                               (SELECT customer_type.cust_type_name FROM customer_type WHERE customer_type.cust_type_id = customer_personal.cust_type_id)
                                FROM customer_personal WHERE customer_personal.cust_type_id=1 order by cust_code Asc");

        return $sql;
    }

    public function getCustComp()
    {
        $sql=$this->db->query("SELECT customer_company.cust_company_id, customer_company.cust_code, customer_company.status, customer_company.cust_company_name, customer_company.cust_type_id, customer_company.cust_business_type, customer_company.cust_pic_contact, customer_company.cust_company_phone, 
                                customer_company.cust_company_email, customer_company.cust_company_address, customer_company.status, customer_company.cust_start_date_contract, customer_company.cust_end_date_contract, customer_company.cust_company_insert, 
                                customer_company.cust_company_update, customer_company.cust_company_user,

                                (SELECT customer_type.cust_type_name FROM customer_type WHERE customer_type.cust_type_id = customer_company.cust_type_id),

                                (SELECT customer_business_type.cust_business_type_name FROM customer_business_type WHERE customer_business_type.cust_business_type_id = customer_company.cust_business_type),

                                (SELECT customers_pic_contact.cust_name FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_position FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_department FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_mobile_phone FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_email FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_religion_id FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_birth_date FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_address FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_insert FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_update FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact),
                                (SELECT customers_pic_contact.cust_user FROM customers_pic_contact WHERE customers_pic_contact.cust_pic_contact_id = customer_company.cust_pic_contact)

                                FROM customer_company WHERE cust_type_id='2' order by cust_company_name DESC");
        return $sql;
    }

    public function insert_personal_data($data)
    {
        $this->db->insert('customer_personal', $data);
    }

    public function delete_personal($id)
    {
        $this->db->where('cust_personal_id', $id);
        $this->db->delete('customer_personal');
    }

    public function delete_company($id,$pic)
    {
        $this->db->where('cust_pic_contact_id', $pic);
        $this->db->delete('customers_pic_contact');

        $this->db->where('cust_personal_id', $id);
        $this->db->delete('customer_personal');
    }

    public function getCustData()
    {
        return $this->db->get_where('customer', array('cust_type_id' => '1'));
    }

    public function getCustList()
    {
        $sql=$this->db->query("SELECT cust_id, cust_code, cust_type_id, cust_company_detail_id, cust_personal_detail_id, cust_start_date_contract, cust_end_date_contract, cust_maintenance_contract, cust_insert, cust_update, cust_user, 
                               (SELECT customer_type.cust_type_name AS is_cust_type FROM public.customer_type WHERE customer_type.cust_type_id = customer.cust_type_id),

                               (SELECT customer_personal_detail.cust_full_name FROM public.customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                               (SELECT customer_personal_detail.cust_short_name FROM public.customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                               (SELECT customer_personal_detail.cust_gender FROM public.customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                               (SELECT customer_personal_detail.cust_religion_id FROM public.customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                               (SELECT customer_personal_detail.cust_personal_email FROM public.customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                               (SELECT customer_personal_detail.cust_personal_phone FROM public.customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                               (SELECT customer_personal_detail.cust_personal_mobile_phone FROM public.customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                               (SELECT customer_personal_detail.cust_personal_address FROM public.customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                               (SELECT customer_personal_detail.cust_personal_insert FROM public.customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                               (SELECT customer_personal_detail.cust_personal_update FROM public.customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id),
                               (SELECT customer_personal_detail.cust_personal_user FROM public.customer_personal_detail WHERE customer_personal_detail.cust_personal_detail_id = customer.cust_personal_detail_id)
                                FROM customer WHERE cust_type_id='1' order by cust_id DESC");
        return $sql;
    }

    public function getCustCompany()
    {
        $sql=$this->db->query("SELECT cust_id, cust_code, cust_type_id, cust_company_detail_id, cust_personal_detail_id, cust_start_date_contract, cust_end_date_contract, cust_maintenance_contract, cust_insert, cust_update, cust_user, 
                               (SELECT customer_type.cust_type_name AS is_cust_type FROM public.customer_type WHERE customer_type.cust_type_id = customer.cust_type_id),

                               (SELECT customer_company_detail.cust_code FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_name FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_business_type AS is_business FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_address FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_address2 FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_address3 FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_codepos FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_city FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_phone FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_email FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_insert FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_update FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id),
                               (SELECT customer_company_detail.cust_company_user FROM public.customer_company_detail WHERE customer_company_detail.cust_company_detail_id = customer.cust_company_detail_id)
                                FROM customer WHERE cust_type_id='2' order by cust_id DESC");
        return $sql;
    }

	public function insert_data($data_cust_company)
	{
		$this->db->insert('customer_company', $data_cust_company);
	}

    public function insert_pic_contact($data_pic_contact)
    {
        $this->db->insert('customers_pic_contact', $data_pic_contact);
    }

    public function insert_data_cust($data_cust)
    {
        $this->db->insert('customer', $data_cust);
    }

    public function insert_personal_detail($data_cust_personal)
    {
        $this->db->insert('customer_personal_detail', $data_cust_personal);
    }

    public function update_data($data, $id)
	{
		$this->db->update('customer', $data, $id);
	}

	public function delete_data($id)
	{
		$this->db->where('cust_id', $id);
		$this->db->delete('customer');
	}

	/*  Start Import Excel */
	public function import_excel($dataexcel)
    {
        for($i=1;$i<count($dataexcel);$i++){
            $h = $_SESSION['uname'];
            $i = date('Y-m-d H:i:s');
            $data = array(
                'cust_code'=>$dataexcel[$i]['cust_code'],
                'cust_type_id'=>$dataexcel[$i]['cust_type_id'],
                'cust_start_date_contract'=>$dataexcel[$i]['cust_start_date_contract'],
                'cust_end_date_contract'=>$dataexcel[$i]['cust_end_date_contract'],
                'cust_maintenance_contract'=>$dataexcel[$i]['cust_maintenance_contract'],
                'cust_insert' => $i,
                'cust_update' => $i,
                'cust_user' => $h
            );
            $this->db->insert('customer', $data);

            $data_cust_personal = array(
                        'cust_full_name'=>$dataexcel[$i]['cust_full_name'],
                        'cust_short_name'=>$dataexcel[$i]['cust_short_name'],
                        'cust_gender'=>$dataexcel[$i]['cust_gender'],
                        'cust_religion_id'=>$dataexcel[$i]['cust_religion_id'],
                        'cust_personal_email'=>$dataexcel[$i]['cust_personal_email'],
                        'cust_personal_phone'=>$dataexcel[$i]['cust_personal_phone'],
                        'cust_personal_mobile_phone'=>$dataexcel[$i]['cust_personal_mobile_phone'],
                        'cust_personal_address'=>$dataexcel[$i]['cust_personal_address'],
                        'cust_personal_insert' => $i,
                        'cust_personal_update' => $i,
                        'cust_personal_user' => $h
                    );

            $this->db->insert('customer', $data_cust_personal);
        }
    }

    public function import_company_excel($dataexcel)
    {
        for($i=1;$i<count($dataexcel);$i++){
            $h = $_SESSION['uname'];
            $i = date('Y-m-d H:i:s');
            $data = array(
                'cust_code'=>$dataexcel[$i]['cust_code'],
                'cust_type_id'=>$dataexcel[$i]['cust_type_id'],
                'cust_start_date_contract'=>$dataexcel[$i]['cust_start_date_contract'],
                'cust_end_date_contract'=>$dataexcel[$i]['cust_end_date_contract'],
                'cust_maintenance_contract'=>$dataexcel[$i]['cust_maintenance_contract'],
                'cust_insert' => $i,
                'cust_update' => $i,
                'cust_user' => $h
            );
            $this->db->insert('customer', $data);

            $data_cust_personal = array(
                        'cust_company_name'=>$dataexcel[$i]['cust_company_name'],
                        'cust_business_type'=>$dataexcel[$i]['cust_business_type'],
                        'cust_company_address'=>$dataexcel[$i]['cust_company_address'],
                        'cust_company_address2'=>$dataexcel[$i]['cust_company_address2'],
                        'cust_company_address3'=>$dataexcel[$i]['cust_company_address3'],
                        'cust_company_codepos'=>$dataexcel[$i]['cust_company_codepos'],
                        'cust_company_city'=>$dataexcel[$i]['cust_company_city'],
                        'cust_company_phone'=>$dataexcel[$i]['cust_company_phone'],
                        'cust_company_email'=>$dataexcel[$i]['cust_company_email'],
                        'cust_personal_insert' => $i,
                        'cust_personal_update' => $i,
                        'cust_personal_user' => $h
                    );
            
            $this->db->insert('customer', $data_cust_personal);
        }
    }

    public function search_excel($dataexcel){
        for($i=1;$i<count($dataexcel);$i++){
            $search = array(
                'cust_id');
        }
        $data = array();
        $this->db->limit(1);
        $Q = $this->db->get('customer');
        if($Q->num_rows() > 0){
        $data = $Q->row_array();
        }
        $Q->free_result();
        return $data;
    }
    /*  End Import Excel */
}

/* End of file CustomerModel.php */
/* Location: ./application/models/CustomerModel.php */