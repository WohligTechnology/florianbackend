<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class Json extends CI_Controller
{function getalleditorials()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`florian_editorials`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`florian_editorials`.`image`";
$elements[1]->sort="1";
$elements[1]->header="image";
$elements[1]->alias="image";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`florian_editorials`.`order`";
$elements[2]->sort="1";
$elements[2]->header="order";
$elements[2]->alias="order";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `florian_editorials`");
$this->load->view("json",$data);
}
public function getsingleeditorials()
{
$id=$this->input->get_post("id");
$data["message"]=$this->editorials_model->getsingleeditorials($id);
$this->load->view("json",$data);
}
function getallcelebrities()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`florian_celebrities`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`florian_celebrities`.`image`";
$elements[1]->sort="1";
$elements[1]->header="image";
$elements[1]->alias="image";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`florian_celebrities`.`order`";
$elements[2]->sort="1";
$elements[2]->header="order";
$elements[2]->alias="order";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `florian_celebrities`");
$this->load->view("json",$data);
}
public function getsinglecelebrities()
{
$id=$this->input->get_post("id");
$data["message"]=$this->celebrities_model->getsinglecelebrities($id);
$this->load->view("json",$data);
}
function getalltvc()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`florian_tvc`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`florian_tvc`.`link`";
$elements[1]->sort="1";
$elements[1]->header="link";
$elements[1]->alias="link";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`florian_tvc`.`order`";
$elements[2]->sort="1";
$elements[2]->header="order";
$elements[2]->alias="order";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `florian_tvc`");
$this->load->view("json",$data);
}
public function getsingletvc()
{
$id=$this->input->get_post("id");
$data["message"]=$this->tvc_model->getsingletvc($id);
$this->load->view("json",$data);
}
function getalldesigner()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`florian_designer`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`florian_designer`.`name`";
$elements[1]->sort="1";
$elements[1]->header="name";
$elements[1]->alias="name";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `florian_designer`");
$this->load->view("json",$data);
}
public function getsingledesigner()
{
$id=$this->input->get_post("id");
$data["message"]=$this->designer_model->getsingledesigner($id);
$this->load->view("json",$data);
}
function getalldesign()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`florian_design`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`florian_design`.`image`";
$elements[1]->sort="1";
$elements[1]->header="image";
$elements[1]->alias="image";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`florian_design`.`order`";
$elements[2]->sort="1";
$elements[2]->header="order";
$elements[2]->alias="order";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `florian_design`");
$this->load->view("json",$data);
}
public function getsingledesign()
{
$id=$this->input->get_post("id");
$data["message"]=$this->design_model->getsingledesign($id);
$this->load->view("json",$data);
}
function getallcontact()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`florian_contact`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`florian_contact`.`name`";
$elements[1]->sort="1";
$elements[1]->header="name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`florian_contact`.`email`";
$elements[2]->sort="1";
$elements[2]->header="email";
$elements[2]->alias="email";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`florian_contact`.`phone`";
$elements[3]->sort="1";
$elements[3]->header="phone";
$elements[3]->alias="phone";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`florian_contact`.`message`";
$elements[4]->sort="1";
$elements[4]->header="message";
$elements[4]->alias="message";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `florian_contact`");
$this->load->view("json",$data);
}
public function getsinglecontact()
{
$id=$this->input->get_post("id");
$data["message"]=$this->contact_model->getsinglecontact($id);
$this->load->view("json",$data);
}
public function getDesigners()
{
$id=$this->input->get_post("id");
$data["message"]=$this->design_model->getDesigners($id);
$this->load->view("json",$data);
}
public function getEditorials()
{
$data["message"]=$this->editorials_model->getEditorials();
$this->load->view("json",$data);
}
public function getCelebrities()
{
$data["message"]=$this->celebrities_model->getCelebrities();
$this->load->view("json",$data);
}
public function getTvc()
{
$data["message"]=$this->tvc_model->getTvc();
$this->load->view("json",$data);
}

public function contactSubmit()
{
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'];
    $phone = $data['phone'];
    $email = $data['email'];
    $message = $data['message'];
    $data['message'] = $this->contact_model->contactSubmit($name, $phone, $email, $message);
    $this->load->view('json', $data);
}
} ?>
