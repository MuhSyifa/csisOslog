<?php

class VendorModel extends CI_model
{
	
	public function index()
	{

	}
	public function save($data)
	{
		return $this->db->insert('vendor', $data);
		//return $this->db->insert_id();
	}
	public function get_by_id($id)
	{
		//$this->db->where('vendor_id', $id);
        //$this->db->update('vendor', $object);
        $table = 'vendor';
		
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}
	public function tampil()
	{
		return $this->db->get('vendor');
	}
	public function delete($param)
	{
		return $this->db->delete('vendor',array('vendor_id'=>$param));
	}
	public function insert()
	{
		$a = $this->input->post('vendor_name');
		$b = $this->input->post('vendor_type');
		$h = $_SESSION['uname'];
        $i = date('Y-m-d H:i:s');

		$object = array(
			'vendor_name' => $a,
			'vendor_type' => $b,
			'vendor_insert' => $i,
			'vendor_update' => $i,
			'vendor_user' => $h
				 );
		return $this->db->insert('vendor', $object);
	}
	/*public function insert_data($data)
	{
		return $this->db->insert('vendor', $data);
	}*/
	public function insert_data($data)
    {
        $this->db->insert('vendor', $data);
    }

    public function vendorDashboard()
    {
        $data = $this->db->query("SELECT vendor_name, vendor_type, count(vendor_name) as stock from vendor 
        							group by vendor_name,vendor_type");
        return $data;
    }

    public function gsmDashboard()
    {
        $data = $this->db->query("SELECT vendor_name, vendor_type, count(vendor_name) as stock from vendor where vendor_type='GSM'
        							group by vendor_name,vendor_type");
        return $data;
    }

    public function gpsDashboard()
    {
        $data = $this->db->query("SELECT vendor_name, vendor_type, count(vendor_name) as stock from vendor where vendor_type='GPS'
        							group by vendor_name,vendor_type");
        return $data;
    }

    public function get()
    {
        $this->db->select('*');
        //$this->db->like('vendor_insert','2016');
        //$this->db->order_by('vendor_insert','asc');
        return $this->db->get('vendor');
    }
}
?>