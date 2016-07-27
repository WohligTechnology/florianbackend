<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class designer_model extends CI_Model
{
public function create($name)
{
$data=array("name" => $name);
$query=$this->db->insert( "florian_designer", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("florian_designer")->row();
return $query;
}
function getsingledesigner($id){
$this->db->where("id",$id);
$query=$this->db->get("florian_designer")->row();
return $query;
}
public function edit($id,$name)
{
if($image=="")
{
$image=$this->designer_model->getimagebyid($id);
$image=$image->image;
}
$data=array("name" => $name);
$this->db->where( "id", $id );
$query=$this->db->update( "florian_designer", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `florian_designer` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `florian_designer` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `florian_designer` ORDER BY `id` 
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
}
?>
