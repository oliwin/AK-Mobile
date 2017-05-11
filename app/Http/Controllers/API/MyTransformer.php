<? namespace App\Http\Controllers\API;

abstract class MyTransformer {

  public $object;
  public $fields;
  public $relations;

  public function transform(){
    foreach($this->object as $k => $value){
        $this->setRelation($value, $this->relation_allowed);
        $this->getFields($value, $this->fields_allowed);
    }
  }

  public function init($object){
    $this->object = $object;
  }

  public function getFields($object, $allowed){
    // TODO
  }

  public abstract function output();

  public function setRelation($object, $allowed){
      foreach($allowed as $k => $v){
        dd($object->{$v}->get());
      }
  }
}
