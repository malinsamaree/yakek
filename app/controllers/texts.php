<?php
class Texts extends Controller{

  public function index(){
    $this->view('texts/imprint');
  }

  public function imprint(){
    $this->view('texts/imprint');
  }

  public function tac(){
    $this->view('texts/tac');
  }

  public function pp(){
    $this->view('texts/pp');
  }

}
