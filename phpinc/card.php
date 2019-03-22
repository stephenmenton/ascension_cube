<?php

class CardName {
  protected $name;
  protected $cost;
  protected $quantity;
  protected $imgRoot = "/~aquaone/ascension/images";

  public function __construct( $name = NULL, $manaCost = NULL, $oracleText = NULL ) {
    $this->setName( $name );
    $this->setCost( $cost );
    }

  public function __destruct(){
    }

  public function getName(){
    return $this->name;
    }

  public function setName( $name ){
    $this->name = $name;
    }

  public function getCost(){
    return $this->cost;
    }
  }

class Card {
  protected $cardName;
  protected $set;
  protected $condition;
  protected $signed;
  protected $altered;
  protected $notes;
  protected $imgRoot = "/~aquaone/ascension/images";
  protected $imgPath;

  public function __construct( $cardName = NULL, $set = NULL, $condition = NULL ) {
    $this->setCardName( $cardName );
    $this->setSet( $set );
    $this->setCondition( $condition );
    }

  public function __destruct(){
    }

  public function getCardName(){
    return $this->cardName;
    }

  public function setCardName( $cardName ){
    $this->cardName = $cardName;
    }

  public function getSet(){
    return $this->set;
    }

  public function setSet( $set ){
    $this->set = $set;
    }

  public function getCondition(){
    return $this->condition;
    }

  public function setCondition( $condition ){
    $this->condition = $condition;
    }

  public function getFoil(){
    return $this->foil;
    }

  public function setFoil( $foil ){
    $this->foil = ( $foil === true )
      ? true
      : false;
    }

  public function getSigned(){
    return $this->signed;
    }

  public function setSigned( $signed ){
    $this->signed = ( $signed === true )
      ? true
      : false;
    }

  public function getAltered(){
    return $this->altered;
    }

  public function setAltered( $altered ){
    $this->altered = ( $altered === true )
      ? true
      : false;
    }

  public function getImgPath(){
    return isset( $this->imgPath )
      ? ( preg_match( "@://@", $this->imgPath ) ? $this->imgPath : "{$this->imgRoot}/{$this->imgPath}" )
      : false;
    }

  public function setImgPath( $imgPath ){
    $this->imgPath = $imgPath;
    }

  public function getNotes(){
    return $this->notes;
    }

  public function setNotes( $notes ){
    $this->notes = $notes;
    }

  }

?>
