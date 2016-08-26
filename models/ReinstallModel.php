<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReinstallModel extends CI_Model {

	/*public function getOrder()
	{
		$order = $this->db->query(" SELECT * FROM orders ORDER BY order_id ");
		return $order;
	}*/
	public function getReinstall()
	{
		$pgsql = $this->db->query("SELECT order_details.odet_id,orders.order_type_number, 
									orders.order_number, orders.order_date, 
									customer.cust_code, employee.emp_name,orders.order_location, 
									gps.gps_imei_number,  gsm.gsm_number, vehicles.veh_number_police, vehicles.veh_install_type_business, 
									odet_work_date, odet_status
									FROM order_details
									JOIN orders
									ON order_details.order_id=orders.order_id
									JOIN gps
									ON order_details.gps_id=gps.gps_id
									JOIN gsm
									ON order_details.gsm_id=gsm.gsm_id
									JOIN vehicles
									ON order_details.veh_id=vehicles.veh_id
									JOIN customer
									ON orders.cust_id=customer.cust_id
									JOIN employee
									ON orders.emp_id=employee.emp_id
									WHERE odet_status = 'Installed' ORDER BY odet_id DESC
								");
		return $pgsql;
	}

	public function get()
	{
		$pgsql = $this->db->query("SELECT * FROM orders ORDER BY order_id DESC LIMIT 1 ");
		return $pgsql;
	}

	public function getUninstall()
	{
		$pgsql = $this->db->query("SELECT order_details.odet_id,orders.order_type_number, 
									orders.order_number, orders.order_date, 
									customer.cust_code, employees.emp_name,orders.order_location, 
									gps.gps_imei_number,  gsm.gsm_number, vehicles.veh_number_police, vehicles.veh_install_type_business, 
									odet_work_date, odet_status
									FROM order_details
									JOIN orders
									ON order_details.order_id=orders.order_id
									JOIN gps
									ON order_details.gps_id=gps.gps_id
									JOIN gsm
									ON order_details.gsm_id=gsm.gsm_id
									JOIN vehicles
									ON order_details.veh_id=vehicles.veh_id
									JOIN customer
									ON orders.cust_id=customer.cust_id
									JOIN employees
									ON orders.emp_id=employees.emp_id
									WHERE odet_status = 'Uninstalled' ORDER BY odet_id DESC
								");
		return $pgsql;
	}
}

/* End of file OrderModel.php */
/* Location: ./application/models/OrderModel.php */