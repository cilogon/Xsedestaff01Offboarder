<?php

  // Add breadcrumbs
  print $this->element("coCrumb");
  $this->Html->addCrumb(filter_var($title_for_layout, FILTER_SANITIZE_SPECIAL_CHARS));

  $params = array();
  $params['title'] = $title_for_layout;

  print $this->element("pageTitleAndButtons", $params);

  print $this->Form->create(
    'XsedestaffOffboardPetition',
    array(
      'inputDefaults' => array(
        'label' => false,
        'div' => false
      )
    )
  );

  $args = array();
  $args['default'] = $cur_co['Co']['id'];
  print $this->Form->hidden('co_id', $args);

  $args = array();
  $args['default'] = $petitionerCoPersonId;
  print $this->Form->hidden('petitioner_co_person_id', $args);

?>

<script type="text/javascript">
$(document).ready(
    function() {
      $("#offboarders").autocomplete({
        source: "<?php
          // We inject the Petition ID and token into the request in case we need
          // autocomplete for new enrollees (unregistered users)
          $offboarderUrl = array(
            'plugin' => null,
            'controller' => 'co_people',
            'action' => 'find',
            'co' => $cur_co['Co']['id'],
            'mode' => PeoplePickerModeEnum::Sponsor
          );
          
          print $this->Html->url($offboarderUrl);
        ?>",
        minLength: 3,
        select: function(event, ui) {
          $("#offboarders").val(ui.item.label);
          $("#XsedestaffOffboardPetitionOffboarderCoPersonId").val(ui.item.value);
          return false;
        }
      });
    }
);
</script>


<div>
  <div class="fields">

    <div class="modelbox">
      <div class="modelbox-data">
        <div class="form-group">
          <div class="cm-inline-editable-field">
            <div class="cm-ief-widget">
            <label for="offboarders"><?php print _txt('pl.xsedestaff01_offboarder.add.offboarder.label');?>
                <span class="required">*</span>
              </label>
                <div class="ui-widget">
                  <input id="offboarders" type="text" class="form-control">
                  <?php
                    $args = array();
                    $args['id'] = "XsedestaffOffboardPetitionOffboarderCoPersonId";
                    print $this->Form->hidden('offboarder_co_person_id', $args);
                    // Unlock the field for autocompletion.
                    $this->Form->unlockField('XsedestaffOffboardPetition.offboarder_co_person_id');
                  ?>
                </div>
                <div class="field-desc">
                  <span class="ui-icon ui-icon-info co-info"></span>
                  <em><?php print _txt('pl.xsedestaff01_offboarder.add.offboarder.help');?></em>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<div id="add_xsedestaff_offboard_petition" class="submit-box">
  <div class="required-info">
    <em><span class="required"><?php print _txt('fd.req'); ?></span></em><br />
  </div>
  <div class="submit-buttons">
    <?php print $this->Form->submit(_txt('op.submit')); ?>
  </div>
</div>

<?php
  print $this->Form->end();
?>
