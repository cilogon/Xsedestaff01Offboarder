<?php

App::uses("StandardController", "Controller");

class XsedestaffOffboardPetitionsController extends StandardController {
  // Class name, used by Cake
  public $name="XsedestaffOffboardPetitions";

  // Establish pagination parameters for HTML views
  public $paginate = array(
    'limit' => 25,
    'order' => array()
  );

  function add() {
    // Process incoming POST data.
    if($this->request->is('post')) {
      $this->log("Incoming POST data is " . print_r($this->data, true));

      // Validate and save the offboard petition. TODO

      $offboarderCoPersonId = $this->data['XsedestaffOffboardPetition']['offboarder_co_person_id'];

      // Pull the CO Person record and associated models.
      $args= array();
      $args['conditions']['OffboarderCoPerson.id'] = $offboarderCoPersonId;
      $args['contain'] = 'Name';
      $offboarder = $this->XsedestaffOffboardPetition->OffboarderCoPerson->find('first', $args);

      $this->log("Offboarder is " . print_r($offboarder, true));


      // Process TODO
      

      // Set a meaningful flash message.
      $displayName = null;
      if(!empty($offboarder['Name'])) {
        foreach($offboarder['Name'] as $name) {
          if($name['primary_name']) {
            $displayName = $name['given'];
            if(!empty($name['family'])) {
              $family = $name['family'];
              $displayName = "$displayName $family";
            }
            break;
          }
        }
      }

      if($displayName) {
        $msg = _txt('pl.xsedestaff01_offboarder.add.flash.success', array($displayName));
      } else {
        $msg = _txt('pl.xsedestaff01_offboarder.add.flash.success.noname');
      }

      $args = array();
      $args['key'] = 'success';
      $this->Flash->set($msg, $args);

      // Redirect to the canvas for the offboarded CO Person.
      $url = array();
      $url['plugin'] = null;
      $url['controller'] = 'co_people';
      $url['action'] = 'canvas';
      $url[] = $offboarderCoPersonId;

      $this->redirect($url);
    }

    // GET so render the form.
    $petitionerCoPersonId = $this->request->named['copersonid'];
    $this->set('petitionerCoPersonId', $petitionerCoPersonId);

    $args = array();
    $args['conditions']['PetitionerCoPerson.id'] = $petitionerCoPersonId;
    $args['contain'] = 'Co';

    $petitionerCoPerson = $this->XsedestaffOffboardPetition->PetitionerCoPerson->find('first', $args);
    $this->log("PetitionerCoPerson is " . print_r($petitionerCoPerson, true));

    $cur_co =  array();
    $cur_co['Co'] = $petitionerCoPerson['Co'];
    $this->set('cur_co', $cur_co);

    $title_for_layout = _txt('pl.xsedestaff01_offboarder.add.title');
    $this->set('title_for_layout', $title_for_layout);
  }

  function isAuthorized() {
    $roles = $this->Role->calculateCMRoles();

    $this->log("FOO roles is " . print_r($roles, true));

    // Construct the permission set for this user, which will also be passed to the view.
    $p = array();
    
    // Delete an existing configuration?
    $p['add'] = ($roles['cmadmin'] || $roles['coadmin']);
    
    $this->set('permissions', $p);
    return $p[$this->action];
  }
}
