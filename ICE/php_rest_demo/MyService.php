<?php
  require "RestService.class.php";
  require "Product.class.php";

  class MyService extends RestService
  {
      // normally wed have a datastore/datastore files but instead we hard code values hebre
      private $products;

      public function __construct()
      {
          parent::__construct();

          //dummy datastore
          for ($i=0; $i<5; $i++) {
              $this->products[] = new Product("Product $i", $i);
          }
      }

      private function getProduct($id)
      {
          if (!empty($this->products[$id])) {
              return $this->products[$id];
          }
      }

      private function addProduct($data)
      {
          //add the new resource to dummy datastore
          $prod = new Product($data->name);
          $prod->setId(5);
          return $prod;
      }

      //Endpoints
      protected function products($args)
      {
          if ($this->method==="GET") {
              //path: /products
              //usually comes from a datastore
              return $this->response($this->products, 200);
          }
      }

      protected function product($args)
      {
          if ($this->method==="GET") {
              //path: /product/{id}
              $prod = $this->getProduct(intval($args[0] ?? -1)); //call db

              if ($prod) {
                  return $this->response($prod, 200);
              }
              return $this->response("The requested resource couldn't exist", 400);
          } elseif ($this->method==="POST") {
              //path: /product (but with post)
              $prod = $this->addProduct($this->request_data);

              if ($prod) {
                  return $this->response($prod, 201);
              }
              return $this->response("There was a problem creating the resource", 400);
          } elseif ($this->method==="PUT") {
              //path: /product (but with put)
              //here we would be updating an existing resource in the data store

              $prod = $this->request_data;

              if ($prod) {
                  return $this->response($prod, 200);
              }
              return $this->response("There was a problem updating the resource", 400);
          } elseif ($this->method==="DELETE") {
              //path: /product (but with delete)
              //here we would be updating an existing resource in the data store

              $prod = $this->getProduct(intval($args[0] ?? -1));
              //delete product here

              if ($prod) {
                  return $this->response(["success:" => "Resource {$prod->getId()} deleted"], 200);
              }
              return $this->response("There was a problem deleting the resource", 400);
          }
      }
  }

  try {
      $service = new MyService();
      echo $service->processAPI();
  } catch (Exception $e) {
      header("HTTP/1.1 400 Bad Request");
      echo $e->getMessage();
  }
