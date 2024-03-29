<?php

require 'controller/MailableController.php';
require 'controller/PageController.php';
require 'controller/ProductController.php';
require 'controller/OrderController.php';
require 'controller/UserController.php';
require 'model/DataHandler.php';
require 'model/Tools.php';

class RequestController
{

	public function __construct()
	{
		$this->product  = new ProductController();
		$this->page     = new PageController();
		$this->mailable = new MailableController();
		$this->order    = new OrderController();
		$this->user     = new UserController();
    $this->base_uri = "api/v1";
		session_start();

	}

	public function handleRequest($url)
	{

		switch ($url) {
			case $this->base_uri . "/login":
				echo $this->user->checkOnLogin($_POST);
				break;

			case $this->base_uri . "/session":
				echo $this->user->checkSession();
				break;

			case $this->base_uri . "/order":
				echo $this->order->create($_POST);
        		break;

			case $this->base_uri . "/order/status":
				echo $this->order->getStatus($_GET);
				break;

			case $this->base_uri . "/orders/last":
				echo $this->order->getLastOrders();
				break;

			case $this->base_uri . "/orders/stats":
				echo $this->order->getStatsbyMonth();
				break;

			case $this->base_uri . "/payments":
				echo $this->order->getPaymentMethods();
				break;

			case $this->base_uri . '/pages':
				echo $this->page->index();
				break;

			case $this->base_uri . "/page":

				if ($_SERVER['REQUEST_METHOD'] == "PATCH") {

					$_PATCH = Notihnio\RequestParser\RequestParser::parse();

					echo $this->page->update($_PATCH->params);
				}

				if ($_SERVER['REQUEST_METHOD'] == "GET") {

					isset($_REQUEST['name']) ? $name = $_REQUEST['name'] : $name = "";
					isset($_REQUEST['id']) ? $id = $_REQUEST['id'] : $id = "";

					echo $this->page->get($id, $name);
				}
				break;

			case $this->base_uri . "/mail":
				echo $this->mailable->sendEmail();
				break;

			case $this->base_uri . "/products":
				echo $this->product->index();
				break;

			case $this->base_uri . '/product':

				if ($_SERVER['REQUEST_METHOD'] == "POST") {
					echo $this->product->create();
				}

				if ($_SERVER['REQUEST_METHOD'] == "GET") {
					echo $this->product->show($_REQUEST['id']);
				}

				if ($_SERVER['REQUEST_METHOD'] == "PATCH") {

					$_PATCH = Notihnio\RequestParser\RequestParser::parse();

					echo $this->product->update($_PATCH->params);
				}

				if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
					echo $this->product->delete($_GET['id']);
				}

				break;

			case "":
				require "./view/build/index.html";
				break;

			default:
				$decoded  = urldecode($url);
				$assetURL = "./view/build/{$url}";
				$yesURL   = "./view/build/{$decoded}";
				$htmlURL  = "./view/build/{$url}.html";


				$expode_url = explode('/', $url);

				if ($expode_url[0] === "cms" ){
					if (! User::checkLoggedIn()) {
						header("Location: /login");
						exit;
					}
				}

				if (file_exists($htmlURL)) {
					$contentType = mime_content_type($htmlURL);
					header("Content-Type: {$contentType}");

					require $htmlURL;
					exit;
				}
				if (file_exists($assetURL)) {
					$contentType = mime_content_type($assetURL);
					header("Content-Type: {$contentType}");

					require $assetURL;
					exit;
				}
				if (file_exists($yesURL)) {
					$contentType = mime_content_type($yesURL);
					header("Content-Type: {$contentType}");

					require $yesURL;
					exit;
				}

				require './view/build/index.html';
		}
	}

}
