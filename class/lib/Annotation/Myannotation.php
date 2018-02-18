<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Myannotation
 *
 * @author aurelien.ATEMKENG
 */

class Table extends Annotation {}

class ClassInfos extends Annotation
{
  public $author;
  public $version;
  public $entitycollection;
  public $nb;
  public $imbricate;
}

class AttrInfos extends Annotation
{
  public $persist;
  public $type;
  public $length;
}

class Persistence extends Annotation
{
  public $persist;
}