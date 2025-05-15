<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}




	
	public function midtrans()
	{
		$this->load->view('midtrans');
	}
	public function midtrans_checkout(){
		$transaction_details = array(
			'order_id' => rand(),
			'gross_amount' => 150000, // no decimal allowed for creditcard
		);

		$item_details = array(
			[
				'id' => 'a1',
				'price' => 50000,
				'quantity' => 2,
				'name' => "Apple"
			],
			[
				'id' => 'a2',
				'price' => 25000,
				'quantity' => 2,
				'name' => "Orange"
			],
		);

		$customer_details = array(
			'first_name'    => "Andri",
			'last_name'     => "Litani",
			'email'         => "didikarpuz@gmail.com",
			'phone'         => "081122334455",
			'shipping_address' => [
				'address'       => "Manggis 90",
				'city'          => "Jakarta",
				'postal_code'   => "16601",
			]
		);
		
		$params = array(
			'transaction_details' => $transaction_details,
			'customer_details' => $customer_details,
			'item_details' => $item_details,
		);

		$this->midtrans->generate_link_checkout($params);
	}
	public function after_payment(){
		
	}
	public function check_payment(){
		
	}
}