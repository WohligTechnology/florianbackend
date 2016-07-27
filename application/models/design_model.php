<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class design_model extends CI_Model
{
public function create($image,$order)
{
$data=array("image" => $image,"order" => $order);
$query=$this->db->insert( "florian_design", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("florian_design")->row();
return $query;
}
function getsingledesign($id){
$this->db->where("id",$id);
$query=$this->db->get("florian_design")->row();
return $query;
}
public function edit($id,$image,$order)
{
if($image=="")
{
$image=$this->design_model->getimagebyid($id);
$image=$image->image;
}
$data=array("image" => $image,"order" => $order);
$this->db->where( "id", $id );
$query=$this->db->update( "florian_design", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `florian_design` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `florian_design` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `florian_design` ORDER BY `id` 
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
