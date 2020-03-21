<?php

require 'model/Contact.php';
require 'model/PaymentMethod.php';

class Order
{


	public static $insert_array = [
		'contact_id',
		'total_price_inc',
		'total_price_ex',
		'payment_id',
		'ordered_date',
	];

	public function __construct()
	{
		$this->dataHandler = new DataHandler($_ENV['DB_HOST'], "mysql", $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT']);

	}

	public function get($id)
	{
		$query = "SELECT * FROM orders ";
		$query .= "JOIN  product_order ON orders.id = product_order.order_id ";
		$query .= "WHERE orders.id = :id ";

		$stmt = $this->dataHandler->preparedQuery($query);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll();

		return $data;
	}

	public function create($data)
	{
		/**
		 * Creates New contact
		 */
		$contactModel = new Contact();
		try {
			$id_contact = $contactModel->create($data);
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), (int)$e->getCode());
		}

		$data['contact_id']      = $id_contact;
		$data['price']           = $this->calculateTotalPrice($data["product_id"]);
		$data['total_price_inc'] = $data['price'];
		$data['total_price_ex']  = ($data['price'] * 0.79);

		$data['ordered_date'] = \Carbon\Carbon::now()->toDateTimeString();

		$id_order = $this->insertOrder($data);

		$this->insertRelationProduct($data['product_id'], $id_order);

		$mailable = new Mailable();
		$mail     = $mailable->sendConfirmationMail($data['email'], $data, $id_order);

		return [
			'message'    => "Successfully registerd order.",
			'order_id'   => (int)$id_order,
			'contact_id' => (int)$id_contact,
		];
	}

	public function getLastOrders($limit = NULL)
	{
		$query = "SELECT * FROM orders ORDER BY id DESC ";

		if ($limit) {
			$query .= "LIMIT {$limit}";
		}

		$stmt = $this->dataHandler->readsData($query);

		$stmt->execute();

		$stmt->setFetchMode(PDO::FETCH_ASSOC);

		$data = $stmt->fetchAll();

		foreach ($data as $key => $item) {
			$paymentMethod = new PaymentMethod((int)$item['payment_id']);
			$contact       = new Contact();
			$contact       = $contact->get($item['contact_id']);

			$data[$key]['id']              = (int)$item['id'];
			$data[$key]['contact_id']      = (int)$item['total_price_inc'];
			$data[$key]['total_price_inc'] = (float)$item['total_price_inc'];
			$data[$key]['total_price_inc'] = (float)$item['total_price_inc'];
			$data[$key]['total_price_ex']  = (float)$item['total_price_ex'];
			$data[$key]['payment_name']    = $paymentMethod->name;
			$data[$key]['contact_name']    = $contact['firstname'] . " " . $contact['lastname'];

			unset($data[$key]['payment_id']);

		}

		return $data;
	}

	private function insertOrder($data)
	{
		$query = Tools::insertQuery(self::$insert_array, "orders");

		$stmt = $this->dataHandler->preparedQuery($query);

		foreach (self::$insert_array as $value) {
			$text = ":" . $value;

			switch ($value) {
				default:
					$stmt->bindValue($text, isset($data[$value]) ? $data[$value] : NULL);
					break;
			}
		}

		$stmt->execute();

		return $this->dataHandler->lastInsertId();
	}

	public function calculateTotalPrice($products)
	{
		$products   = explode(',', $products);
		$totalPrice = 0;

		foreach ($products as $product) {
			$model   = new Product();
			$product = $model->get((int)$product);

			$totalPrice += $product['price'];
		}

		return $totalPrice;
	}

	public function insertRelationProduct($id_product, $id_category)
	{
		try {

			$query = "INSERT INTO product_order (product_id, order_id) VALUES (:id_product, :order_id)";

			$stmt = $this->dataHandler->preparedQuery($query);
			$stmt->bindParam(':id_product', $id_product, PDO::PARAM_INT);
			$stmt->bindParam(':order_id', $id_category, PDO::PARAM_INT);

			$stmt->execute();

		} catch (Exception $e) {

		}

	}
}
