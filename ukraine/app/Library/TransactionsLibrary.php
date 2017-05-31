<?php

namespace App\Library;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Transaction;

use App\ResultTestFiles;

use App\ResultTest;

class TransactionsLibrary
{

  private $transactions = [];
  private $t;

  public function _returnTransactionId()
  {

    return end($this->transactions);
  }

  private function _addTransactionId($id){
    if($id !== FALSE && !empty($id)){
          array_push($this->transactions, $id);
    }
  }

  public function addTransaction($item){

            $client_id = $item->first()->client_id;
            $data = [
              "region_id" => 1, #$item->user->region,
              "doctor_id" => 3, #$item->user->id,
              "client_id" => $client_id,
              "region_center_id" => 1
            ];

            $transaction = Transaction::create($data);
            $last_id = Transaction::query("SELECT MAX(transaction_id) FROM transactions")->get();

            $this->_addTransactionId($last_id->first()->transaction_id);
            $this->updateTransactionFile($client_id);


  }

  public function updateTransactionFile($client_id){
  	$idTr = $this->_returnTransactionId();
  	
    ResultTest::where("client_id", $client_id)->update(["transaction_id" => $idTr]);
    return ResultTestFiles::where("client_id", $client_id)->update(["transaction_id" => $idTr]);

  }

  public function repeatTransaction($client_id)
  {

    if($this->_existsTransaction($client_id)){
      $this->changeTransactionStatus($this->t->client_id, 3);

      // Increment total sends
      $total_sends = $this->t->total_sends + 1;
      Transaction::where("transaction_id", $this->t->id)->update([
        "total_sends" => $total_sends
      ]);
    }
  }

  public function _existsTransaction($client_id){
    $trans = Transaction::where("client_id", $client_id)->get();

    if($trans->count() > 0) {
      $this->t = $trans = $trans->first();
      return true;
    }

    return false;

  }

  public function changeTransactionStatus($id, $status){
    return Transaction::where("transaction_id", $id)->update([
      "status" => $status
    ]);
  }

}
