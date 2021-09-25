<?php 

class Model_category extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	/* get active brand infromation */
	public function getActiveCategroy()
	{
		$sql = "SELECT * FROM categories WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the brand data */
	public function getCategoryData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM categories WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM categories";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/* get the total product of category */
	public function getProdcutLeftCountByCatId($id)
	{
		
		$sql = "SELECT * FROM products where category_id LIKE '%".$id."%'";
		$query = $this->db->query($sql);
		$rows =  $query->result_array();
		// var_dump($rows);

		$result = [
			'qty' => 0,
			'total_price' => 0,
		];

		foreach ($rows as $row) {
			$result['qty'] = $result['qty'] + $row['qty'];
			$result['total_price'] = $result['total_price'] + ($row['qty']  * $row['price']);
		}
		

		return $result;

	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('categories', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('categories', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('categories');
			return ($delete == true) ? true : false;
		}
	}

}