<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class design_model extends CI_Model
{
public function create($image,$order,$designer)
{
        foreach($designer as $value)
        {
        $query=$this->db->query("insert into florian_design(`image`,`order`,`designer`) values('$image','$order','$value')");
        }
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
public function edit($id,$image,$order,$designer)
{
if($image=="")
{
$image=$this->design_model->getimagebyid($id);
$image=$image->image;
}
$data=array("image" => $image,"order" => $order,"designer" => $designer);
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

public function getDesigners($id)
{
  if(!empty($id))
  {
      $query = $this->db->query("SELECT `id`, `image`, `order`, `designer` FROM `florian_design`  WHERE `designer`='$id' ORDER BY `order`")->result();
  }
  else
  {
  $query = $this->db->query("SELECT `id`, `name` FROM `florian_designer` WHERE 1")->result();
  }
 return $query;
}
}
?>
