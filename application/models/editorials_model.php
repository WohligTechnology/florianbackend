<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class editorials_model extends CI_Model
{
public function create($image,$order)
{
$data=array("image" => $image,"order" => $order);
$query=$this->db->insert( "florian_editorials", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("florian_editorials")->row();
return $query;
}
function getsingleeditorials($id){
$this->db->where("id",$id);
$query=$this->db->get("florian_editorials")->row();
return $query;
}
public function edit($id,$image,$order)
{
if($image=="")
{
$image=$this->editorials_model->getimagebyid($id);
$image=$image->image;
}
$data=array("image" => $image,"order" => $order);
$this->db->where( "id", $id );
$query=$this->db->update( "florian_editorials", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `florian_editorials` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `florian_editorials` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `florian_editorials` ORDER BY `id` 
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
