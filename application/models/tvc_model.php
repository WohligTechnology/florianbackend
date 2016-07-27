<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class tvc_model extends CI_Model
{
public function create($link,$order)
{
$data=array("link" => $link,"order" => $order);
$query=$this->db->insert( "florian_tvc", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("florian_tvc")->row();
return $query;
}
function getsingletvc($id){
$this->db->where("id",$id);
$query=$this->db->get("florian_tvc")->row();
return $query;
}
public function edit($id,$link,$order)
{
// if($image=="")
// {
// $image=$this->tvc_model->getimagebyid($id);
// $image=$image->image;
// }
$data=array("link" => $link,"order" => $order);
$this->db->where( "id", $id );
$query=$this->db->update( "florian_tvc", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `florian_tvc` WHERE `id`='$id'");
return $query;
}
// public function getimagebyid($id)
// {
// $query=$this->db->query("SELECT `image` FROM `florian_tvc` WHERE `id`='$id'")->row();
// return $query;
// }
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `florian_tvc` ORDER BY `id`
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

public function getTvc()
{
  $query = $this->db->query("SELECT `id`, `link`, `order` FROM `florian_tvc` WHERE 1 ORDER BY `order`")->result();
 return $query;
}
}
?>
