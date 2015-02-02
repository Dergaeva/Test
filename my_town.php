<?php
require 'vendor/autoload.php';
  
class Town {
  private $name;  
  private $year;
  private $streetInTown;
  private $coords = array ('x' => 0, 'y' => 0);
 
  private $streets = array();
 
  public function __construct ($ini) {
    $this->name = $ini['name'];  
    $this->year = $ini['year'];
    $this->coords = $ini['coords'];          
    $this->streetInTown = count ($ini['streets']); 
    
    for ($n=0; $n < $this->streetInTown; $n++) {
      $iniStreet = $ini['streets'][$n];       
      $this->streets[$n] = new Street ($iniStreet);
    }
  }
  
  public function getStreet ($number) { return $this->streets[$number]; }
   
  public function townInfo() {
    $info = array();   
    $info['name']    = array ('mes'=>'Название',      'val'=>$this->name);
    $info['year']    = array ('mes'=>'Год основания', 'val'=>$this->year);
    $info['coordX']  = array ('mes'=>'Координата X',  'val'=>$this->coords['x']);      
    $info['coordY']  = array ('mes'=>'Координата Y',  'val'=>$this->coords['y']);
    $info['streets'] = array ('mes'=>'Улицы',         'val'=>$this->streetInTown);
    return $info;    
  }
  
  public function calcCostLandTown() {
    for ($sum=0, $n=0; $n < $this->streetInTown; $n++)
      for ($i=0; $i < $this->getStreet($n)->getHouseOnStreet(); $i++) 
        $sum += $this->getStreet($n)->getHouse($i)->calcCostLandHouse();
    return $sum;
  }
  
  public function calcNumberPeopleTown() {
    for ($sum=0, $n=0; $n < $this->streetInTown; $n++)    
      for ($m=0; $m < $this->getStreet($n)->getHouseOnStreet(); $m++)
        for ($i=0; $i < $this->getStreet($n)->getHouse($m)->getSections(); $i++)
          for ($j=0; $j < $this->getStreet($n)->getHouse($m)->getFloors(); $j++)
            for ($k=0; $k < $this->getStreet($n)->getHouse($m)->getApartInCluster(); $k++)
              $sum += $this->getStreet($n)->getHouse($m)->getApart($i,$j,$k)->getPeople();
    return $sum;
  }  
}

echo '</br>Г О Р О Д</br>'; 
  $iniTown = array ('name'=>'Рим', 'year'=>'753 р. до н. е.', 
    'coords'=> array ('x'=>322.223, 'y'=>223.322), 'streets'=>Cont::$streetType);    
  $town = new Town ($iniTown);
  $townInfo = $town->townInfo();  
  foreach ($townInfo as $key => $value) {
    if ($key == 'streets') echo $value['mes'].': '.$streetInTown = $value['val'].'</br>';
    else echo $value['mes'].': '.$value['val'].'</br>';
  }
  
  $sum=0;
  for ($i=0; $i < $streetInTown; $i++) {
    $stInfo = $town->getStreet($i)->streetInfo(); 
    foreach ($stInfo as $key => $value) {
      if ($key == 'houses') echo $value['mes'].': '. $stInfo['houses']['val'].' &nbsp; ';
      else echo $value['mes'].': '.$value['val'].' &nbsp; ';  
    }
	echo '</br>';
  }	
  echo '> Поступления от земельного налога: '.round ($town->calcCostLandTown(), 2).'</br>';
  echo '> Население нашего города: '.$town->calcNumberPeopleTown().'</br>'; 

 

 