<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class slider_model extends CI_Model
{
public function create($order,$image,$mobile_image,$url,$status)
{
$data=array("order" => $order,"image" => $image,"mobile_image" => $mobile_image,"url" => $url,"status" => $status);
$query=$this->db->insert( "slider", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("slider")->row();
return $query;
}
function getsingleslider($id){
$this->db->where("id",$id);
$query=$this->db->get("slider")->row();
return $query;
}
public function getimagebyid($id)
{
  $query=$this->db->query("SELECT `image` FROM `slider` WHERE `id`='$id'")->row();
  return $query;
}
public function edit($id,$order,$image,$mobile_image,$url,$status)
{
$data=array("order" => $order,"image" => $image,"mobile_image" => $mobile_image,"url" => $url,"status" => $status);
$this->db->where( "id", $id );
$query=$this->db->update( "slider", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `slider` WHERE `id`='$id'");
return $query;
}
}
?>