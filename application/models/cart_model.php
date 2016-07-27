<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class cart_model extends CI_Model
{
public function create($user,$quantity,$product,$timestamp)
{
$data=array("user" => $user,"quantity" => $quantity,"product" => $product,"timestamp" => $timestamp);
$query=$this->db->insert( "fynx_cart", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("fynx_cart")->row();
return $query;
}
function getsinglecart($id){
$this->db->where("id",$id);
$query=$this->db->get("fynx_cart")->row();
return $query;
}
public function edit($id,$user,$quantity,$product,$timestamp)
{
$data=array("user" => $user,"quantity" => $quantity,"product" => $product,"timestamp" => $timestamp);
$this->db->where( "id", $id );
$query=$this->db->update( "fynx_cart", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `fynx_cart` WHERE `id`='$id'");
return $query;
}
}
?>
