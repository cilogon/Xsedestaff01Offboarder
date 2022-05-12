<?

class XsedestaffOffboardPetition extends AppModel {
  // Define class name for cake
  public $name = "XsedestaffOffboardPetition";

  // Add behaviors
  public $actsAs = array(
    'Containable'
  );

  // Association rules from this model to other models
  public $belongsTo = array(
    "Co",
    "OffboarderCoPerson" => array(
      'className' => 'CoPerson',
      'foreignKey' => 'offboarder_co_person_id'
    ),
    "PetitionerCoPerson" => array(
      'className' => 'CoPerson',
      'foreignKey' => 'petitioner_co_person_id'
    )
  );

  public $hasMany = array();

  // Validation rules for table elements
  public $validate = array(
    'co_id' => array(
      'rule' => 'numeric',
      'required' => false,
      'allowEmpty' => true
    ),
    'offboarder_co_person_id' => array(
      'content' => array(
        'rule' => 'numeric',
        'required' => false,
        'allowEmpty' => true,
        'unfreeze' => 'CO'
      )
    ),
    'petitioner_co_person_id' => array(
      'content' => array(
        'rule' => 'numeric',
        'required' => false,
        'allowEmpty' => true,
        'unfreeze' => 'CO'
     )
    )
  );

}
?>
