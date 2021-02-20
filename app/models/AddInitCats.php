<?php
class AddInitCats{
  public function AddInitCategories($userIdNew){
    return DatabaseHF::addInitCats($userIdNew);
  }
}
