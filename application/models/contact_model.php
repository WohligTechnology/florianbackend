<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class contact_model extends CI_Model
{
public function create($name,$email,$phone,$message)
{
$data=array("name" => $name,"email" => $email,"phone" => $phone,"message" => $message);
$query=$this->db->insert( "florian_contact", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("florian_contact")->row();
return $query;
}
function getsinglecontact($id){
$this->db->where("id",$id);
$query=$this->db->get("florian_contact")->row();
return $query;
}
public function edit($id,$name,$email,$phone,$message)
{
if($image=="")
{
$image=$this->contact_model->getimagebyid($id);
$image=$image->image;
}
$data=array("name" => $name,"email" => $email,"phone" => $phone,"message" => $message);
$this->db->where( "id", $id );
$query=$this->db->update( "florian_contact", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `florian_contact` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `florian_contact` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `florian_contact` ORDER BY `id`
                    ASC")->result();
$return=array(
"" => "Select Option"
);
foreach($query as $row)
{
$return[$row->id]=$row->name;
}
return $return;
}


public function contactSubmit($name, $phone, $email, $message)
{
    if(!empty($email))
    {
        $this->db->query("INSERT INTO `florian_contact`(`name`,`phone`,`email`,`message`) VALUE('$name', '$phone','$email','$message')");
       $message = "<html><body><div id=':1fn' class='a3s adM' style='overflow: hidden;'>
      <p style='color:#000;font-family:Roboto;font-size:14px'>Name : $name <br/>
    Phone : $phone <br/>
    Email : $email <br/>
    Message : $message
      </p>
    </div></body></html>";
    $this->email_model->emailer($message,'Contact Form Submission',$email,$username);
    $object = new stdClass();
    $object->value = true;
    }
else
{
$object = new stdClass();
$object->value = false;
}
    return $object;
}
}
?>
