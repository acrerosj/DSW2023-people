<?php
namespace Andres\People\Controllers;

use Andres\People\Models\Person;

class PersonController {

  private $messages = [];

  public function list() {
    $persons = Person::all();
    require('../src/views/templates/head.php');
    require('../src/views/person/list.php');
    require('../src/views/templates/foot.php');
  }

  public function show($id) {
    $person = Person::find($id);
    if ($person) {
      require('../src/views/templates/head.php');
      require('../src/views/person/show.php');
      require('../src/views/templates/foot.php');
    } else {
      $this->messages[] = [
        'type' => 'error',
        'text' => "No se encuentra la persona con el id = $id"
      ];
      $this->list();
    }
  }

  public function delete($id) {
    $person = Person::find($id);
    if ($person) {
      $this->messages[] = [
        'type' => 'success',
        'text' => "Se ha borrado la persona con el id = $id"
      ];
      $person->delete();
    } else {
      $this->messages[] = [
        'type' => 'error',
        'text' => "No se encuentra la persona con el id = $id"
      ];
    }
    $this->list();
  }

  public function create() {
    require('../src/views/templates/head.php');
    require('../src/views/person/create.php');
    require('../src/views/templates/foot.php');
  }

  public function post($data) {
    $person = new Person();
    $person->name = $data['name'];
    $person->save();
    $this->list();
    //header('Location', 'http://localhost/DSW2023-people/public/index.php');
  }

  public function edit($id) {
    $person = Person::find($id);
    if ($person) {
      require('../src/views/templates/head.php');
      require('../src/views/person/edit.php');    
      require('../src/views/templates/foot.php');
    } else {
      $this->messages[] = [
        'type' => 'error',
        'text' => "No se encuentra la persona con el id = $id"
      ];
      $this->list();      
    }
  }

  public function update($id, $data) {
    $person = Person::find($id);
    if($person) {
      if (!empty($data['name'])) {
        $person->name = $data['name'];
        $person->save();
        $this->messages[] = [
          'type' => 'success',
          'text' => "Se creó correctamente con el id = " .$person->id
        ];   
        $this->list();
      } else {
        $this->messages[] = [
          'type' => 'error',
          'text' => "El nombre no puede ser vacío"
        ]; 
        $this->edit($id);
      }
    } else {
      $this->messages[] = [
        'type' => 'error',
        'text' => "No se encuentra la persona con el id = $id"
      ];
      $this->list();        
    }
  }
}