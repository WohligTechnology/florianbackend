<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller
{
	public function __construct( )
	{
		parent::__construct();

		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
    public function getOrderingDone()
    {
        $orderby=$this->input->get("orderby");
        $ids=$this->input->get("ids");
        $ids=explode(",",$ids);
        $tablename=$this->input->get("tablename");
        $where=$this->input->get("where");
        if($where == "" || $where=="undefined")
        {
            $where=1;
        }
        $access = array(
            '1',
        );
        $this->checkAccess($access);
        $i=1;
        foreach($ids as $id)
        {
            //echo "UPDATE `$tablename` SET `$orderby` = '$i' WHERE `id` = `$id` AND $where";
            $this->db->query("UPDATE `$tablename` SET `$orderby` = '$i' WHERE `id` = '$id' AND $where");
            $i++;
            //echo "/n";
        }
        $data["message"]=true;
        $this->load->view("json",$data);

    }
	public function index()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
        $data['gender']=$this->user_model->getgenderdropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)
		{
			$data['alerterror'] = validation_errors();
            $data['gender']=$this->user_model->getgenderdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=$this->input->post('accesslevel');
            $status=$this->input->post('status');
            $socialid=$this->input->post('socialid');
            $logintype=$this->input->post('logintype');
            $json=$this->input->post('json');
            $firstname=$this->input->post('firstname');
            $lastname=$this->input->post('lastname');
            $phone=$this->input->post('phone');
            $billingaddress=$this->input->post('billingaddress');
            $billingcity=$this->input->post('billingcity');
            $billingstate=$this->input->post('billingstate');
            $billingcountry=$this->input->post('billingcountry');
            $billingpincode=$this->input->post('billingpincode');
            $billingcontact=$this->input->post('billingcontact');

            $shippingaddress=$this->input->post('shippingaddress');
            $shippingcity=$this->input->post('shippingcity');
            $shippingstate=$this->input->post('shippingstate');
            $shippingcountry=$this->input->post('shippingcountry');
            $shippingpincode=$this->input->post('shippingpincode');
            $shippingcontact=$this->input->post('shippingcontact');
            $shippingname=$this->input->post('shippingname');
            $currency=$this->input->post('currency');
            $credit=$this->input->post('credit');
            $companyname=$this->input->post('companyname');
            $registrationno=$this->input->post('registrationno');
            $vatnumber=$this->input->post('vatnumber');
            $country=$this->input->post('country');
            $fax=$this->input->post('fax');
            $gender=$this->input->post('gender');

            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];

                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }

			}

			if($this->user_model->create($name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json,$firstname,$lastname,$phone,$billingaddress,$billingcity,$billingstate,$billingcountry,$billingpincode,$billingcontact,$shippingaddress,$shippingcity,$shippingstate,$shippingcountry,$shippingpincode,$shippingcontact,$shippingname,$currency,$credit,$companyname,$registrationno,$vatnumber,$country,$fax,$gender)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			$data['redirect']="site/viewusers";
			$this->load->view("redirect",$data);
		}
	}
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        $data['base_url'] = site_url("site/viewusersjson");

		$data['title']='View Users';
		$this->load->view('template',$data);
	}
    function viewusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);


        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";


        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";

        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";

        $elements[3]=new stdClass();
        $elements[3]->field="`user`.`socialid`";
        $elements[3]->sort="1";
        $elements[3]->header="SocialId";
        $elements[3]->alias="socialid";

        $elements[4]=new stdClass();
        $elements[4]->field="`user`.`logintype`";
        $elements[4]->sort="1";
        $elements[4]->header="Logintype";
        $elements[4]->alias="logintype";

        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`json`";
        $elements[5]->sort="1";
        $elements[5]->header="Json";
        $elements[5]->alias="json";

        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Accesslevel";
        $elements[6]->alias="accesslevelname";

        $elements[7]=new stdClass();
        $elements[7]->field="`statuses`.`name`";
        $elements[7]->sort="1";
        $elements[7]->header="Status";
        $elements[7]->alias="status";


        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }

        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }

        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `logintype` ON `logintype`.`id`=`user`.`logintype` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` LEFT OUTER JOIN `statuses` ON `statuses`.`id`=`user`.`status`");

		$this->load->view("json",$data);
	}


	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
        $data["before1"]=$this->input->get('id');
        $data["before2"]=$this->input->get('id');
        $data["before3"]=$this->input->get('id');
        $data["before4"]=$this->input->get('id');
        $data["before5"]=$this->input->get('id');
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data['gender']=$this->user_model->getgenderdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('templatewith2',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);

		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data['gender']=$this->user_model->getgenderdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
//			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{

            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=$this->input->get_post('accesslevel');
            $status=$this->input->get_post('status');
            $socialid=$this->input->get_post('socialid');
            $logintype=$this->input->get_post('logintype');
            $json=$this->input->get_post('json');
//            $category=$this->input->get_post('category');
            $firstname=$this->input->post('firstname');
            $lastname=$this->input->post('lastname');
            $phone=$this->input->post('phone');
            $billingaddress=$this->input->post('billingaddress');
            $billingcity=$this->input->post('billingcity');
            $billingstate=$this->input->post('billingstate');
            $billingcountry=$this->input->post('billingcountry');
            $billingpincode=$this->input->post('billingpincode');
            $billingcontact=$this->input->post('billingcontact');

            $shippingaddress=$this->input->post('shippingaddress');
            $shippingcity=$this->input->post('shippingcity');
            $shippingstate=$this->input->post('shippingstate');
            $shippingcountry=$this->input->post('shippingcountry');
            $shippingpincode=$this->input->post('shippingpincode');
            $shippingcontact=$this->input->post('shippingcontact');
            $shippingname=$this->input->post('shippingname');
            $currency=$this->input->post('currency');
            $credit=$this->input->post('credit');
            $companyname=$this->input->post('companyname');
            $registrationno=$this->input->post('registrationno');
            $vatnumber=$this->input->post('vatnumber');
            $country=$this->input->post('country');
            $fax=$this->input->post('fax');
            $gender=$this->input->post('gender');
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];

                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }

			}

            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }

			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json,$firstname,$lastname,$phone,$billingaddress,$billingcity,$billingstate,$billingcountry,$billingpincode,$billingcontact,$shippingaddress,$shippingcity,$shippingstate,$shippingcountry,$shippingpincode,$shippingcontact,$shippingname,$currency,$credit,$companyname,$registrationno,$vatnumber,$country,$fax,$gender)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";

			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);

		}
	}

	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    public function viewcart()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewcart";
    $data["before1"]=$this->input->get('id');
        $data["before2"]=$this->input->get('id');
        $data["before3"]=$this->input->get('id');
        $data["before4"]=$this->input->get('id');
        $data["before5"]=$this->input->get('id');
$data['page2']='block/userblock';
$data["base_url"]=site_url("site/viewcartjson?id=").$this->input->get('id');
$data["title"]="View cart";
$this->load->view("templatewith2",$data);
}
function viewcartjson()
{
    $id=$this->input->get('id');
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fynx_cart`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`fynx_cart`.`user`";
$elements[1]->sort="1";
$elements[1]->header="User";
$elements[1]->alias="user";
$elements[2]=new stdClass();
$elements[2]->field="`fynx_cart`.`quantity`";
$elements[2]->sort="1";
$elements[2]->header="Quantity";
$elements[2]->alias="quantity";
$elements[3]=new stdClass();
$elements[3]->field="`fynx_cart`.`product`";
$elements[3]->sort="1";
$elements[3]->header="Product";
$elements[3]->alias="product";
$elements[4]=new stdClass();
$elements[4]->field="`fynx_cart`.`timestamp`";
$elements[4]->sort="1";
$elements[4]->header="Timestamp";
$elements[4]->alias="timestamp";

$elements[5]=new stdClass();
$elements[5]->field="`fynx_cart`.`size`";
$elements[5]->sort="1";
$elements[5]->header="Size";
$elements[5]->alias="size";

$elements[6]=new stdClass();
$elements[6]->field="`fynx_cart`.`color`";
$elements[6]->sort="1";
$elements[6]->header="Color";
$elements[6]->alias="color";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fynx_cart`","WHERE `fynx_cart`.`user`='$id'");
$this->load->view("json",$data);
}
    public function viewwishlist()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewwishlist";
    $data["before1"]=$this->input->get('id');
        $data["before2"]=$this->input->get('id');
        $data["before3"]=$this->input->get('id');
        $data["before4"]=$this->input->get('id');
        $data["before5"]=$this->input->get('id');
$data['page2']='block/userblock';
$data["base_url"]=site_url("site/viewwishlistjson?id=".$this->input->get('id'));
$data["title"]="View wishlist";
$this->load->view("templatewith2",$data);
}
function viewwishlistjson()
{
    $user=$this->input->get('id');
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fynx_wishlist`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`fynx_wishlist`.`user`";
$elements[1]->sort="1";
$elements[1]->header="User";
$elements[1]->alias="user";
$elements[2]=new stdClass();
$elements[2]->field="`fynx_wishlist`.`product`";
$elements[2]->sort="1";
$elements[2]->header="Product";
$elements[2]->alias="product";
$elements[3]=new stdClass();
$elements[3]->field="`fynx_wishlist`.`timestamp`";
$elements[3]->sort="1";
$elements[3]->header="Timestamp";
$elements[3]->alias="timestamp";

$elements[4]=new stdClass();
$elements[4]->field="`fynx_product`.`name`";
$elements[4]->sort="1";
$elements[4]->header="Product Name";
$elements[4]->alias="productname";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fynx_wishlist` LEFT OUTER JOIN `fynx_product` ON `fynx_product`.`id`=`fynx_wishlist`.`product`","WHERE `fynx_wishlist`.`user`='$user'");
$this->load->view("json",$data);
}



    public function vieweditorials()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="vieweditorials";
$data["base_url"]=site_url("site/vieweditorialsjson");
$data["title"]="View editorials";
$this->load->view("template",$data);
}
function vieweditorialsjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`florian_editorials`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`florian_editorials`.`image`";
$elements[1]->sort="1";
$elements[1]->header="image";
$elements[1]->alias="image";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `florian_editorials`");
$this->load->view("json",$data);
}

public function createeditorials()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createeditorials";
$data["title"]="Create editorials";
$this->load->view("template",$data);
}
public function createeditorialssubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("image","image","trim");
$this->form_validation->set_rules("order","order","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createeditorials";
$data["title"]="Create editorials";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$image=$this->menu_model->createImage();
$order=$this->input->get_post("order");
if($this->editorials_model->create($image,$order)==0)
$data["alerterror"]="New editorials could not be created.";
else
$data["alertsuccess"]="editorials created Successfully.";
$data["redirect"]="site/vieweditorials";
$this->load->view("redirect",$data);
}
}
public function editeditorials()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editeditorials";
$data["title"]="Edit editorials";
$data["before"]=$this->editorials_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editeditorialssubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("image","image","trim");
$this->form_validation->set_rules("order","order","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editeditorials";
$data["title"]="Edit editorials";
$data["before"]=$this->editorials_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$image=$this->menu_model->createImage();
$order=$this->input->get_post("order");
if($this->editorials_model->edit($id,$image,$order)==0)
$data["alerterror"]="New editorials could not be Updated.";
else
$data["alertsuccess"]="editorials Updated Successfully.";
$data["redirect"]="site/vieweditorials";
$this->load->view("redirect",$data);
}
}
public function deleteeditorials()
{
$access=array("1");
$this->checkaccess($access);
$this->editorials_model->delete($this->input->get("id"));
$data["redirect"]="site/vieweditorials";
$this->load->view("redirect",$data);
}
public function viewcelebrities()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewcelebrities";
$data["base_url"]=site_url("site/viewcelebritiesjson");
$data["title"]="View celebrities";
$this->load->view("template",$data);
}
function viewcelebritiesjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`florian_celebrities`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`florian_celebrities`.`image`";
$elements[1]->sort="1";
$elements[1]->header="image";
$elements[1]->alias="image";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `florian_celebrities`");
$this->load->view("json",$data);
}

public function createcelebrities()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createcelebrities";
$data["title"]="Create celebrities";
$this->load->view("template",$data);
}
public function createcelebritiessubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("image","image","trim");
$this->form_validation->set_rules("order","order","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createcelebrities";
$data["title"]="Create celebrities";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$image=$this->menu_model->createImage();
$order=$this->input->get_post("order");
if($this->celebrities_model->create($image,$order)==0)
$data["alerterror"]="New celebrities could not be created.";
else
$data["alertsuccess"]="celebrities created Successfully.";
$data["redirect"]="site/viewcelebrities";
$this->load->view("redirect",$data);
}
}
public function editcelebrities()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editcelebrities";
$data["title"]="Edit celebrities";
$data["before"]=$this->celebrities_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editcelebritiessubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("image","image","trim");
$this->form_validation->set_rules("order","order","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editcelebrities";
$data["title"]="Edit celebrities";
$data["before"]=$this->celebrities_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$image=$this->menu_model->createImage();
$order=$this->input->get_post("order");
if($this->celebrities_model->edit($id,$image,$order)==0)
$data["alerterror"]="New celebrities could not be Updated.";
else
$data["alertsuccess"]="celebrities Updated Successfully.";
$data["redirect"]="site/viewcelebrities";
$this->load->view("redirect",$data);
}
}
public function deletecelebrities()
{
$access=array("1");
$this->checkaccess($access);
$this->celebrities_model->delete($this->input->get("id"));
$data["redirect"]="site/viewcelebrities";
$this->load->view("redirect",$data);
}
public function viewtvc()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewtvc";
$data["base_url"]=site_url("site/viewtvcjson");
$data["title"]="View tvc";
$this->load->view("template",$data);
}
function viewtvcjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`florian_tvc`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`florian_tvc`.`link`";
$elements[1]->sort="1";
$elements[1]->header="link";
$elements[1]->alias="link";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `florian_tvc`");
$this->load->view("json",$data);
}

public function createtvc()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createtvc";
$data["title"]="Create tvc";
$this->load->view("template",$data);
}
public function createtvcsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("link","link","trim");
$this->form_validation->set_rules("order","order","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createtvc";
$data["title"]="Create tvc";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$link=$this->input->get_post("link");
$order=$this->input->get_post("order");
if($this->tvc_model->create($link,$order)==0)
$data["alerterror"]="New tvc could not be created.";
else
$data["alertsuccess"]="tvc created Successfully.";
$data["redirect"]="site/viewtvc";
$this->load->view("redirect",$data);
}
}
public function edittvc()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="edittvc";
$data["title"]="Edit tvc";
$data["before"]=$this->tvc_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function edittvcsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("link","link","trim");
$this->form_validation->set_rules("order","order","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="edittvc";
$data["title"]="Edit tvc";
$data["before"]=$this->tvc_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$link=$this->input->get_post("link");
$order=$this->input->get_post("order");
if($this->tvc_model->edit($id,$link,$order)==0)
$data["alerterror"]="New tvc could not be Updated.";
else
$data["alertsuccess"]="tvc Updated Successfully.";
$data["redirect"]="site/viewtvc";
$this->load->view("redirect",$data);
}
}
public function deletetvc()
{
$access=array("1");
$this->checkaccess($access);
$this->tvc_model->delete($this->input->get("id"));
$data["redirect"]="site/viewtvc";
$this->load->view("redirect",$data);
}
public function viewdesigner()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewdesigner";
$data["base_url"]=site_url("site/viewdesignerjson");
$data["title"]="View designer";
$this->load->view("template",$data);
}
function viewdesignerjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`florian_designer`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `florian_designer`");
$this->load->view("json",$data);
}

public function createdesigner()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createdesigner";
$data["title"]="Create designer";
$this->load->view("template",$data);
}
public function createdesignersubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","name","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createdesigner";
$data["title"]="Create designer";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
if($this->designer_model->create($name)==0)
$data["alerterror"]="New designer could not be created.";
else
$data["alertsuccess"]="designer created Successfully.";
$data["redirect"]="site/viewdesigner";
$this->load->view("redirect",$data);
}
}
public function editdesigner()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editdesigner";
$data["title"]="Edit designer";
$data["before"]=$this->designer_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editdesignersubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("name","name","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editdesigner";
$data["title"]="Edit designer";
$data["before"]=$this->designer_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
if($this->designer_model->edit($id,$name)==0)
$data["alerterror"]="New designer could not be Updated.";
else
$data["alertsuccess"]="designer Updated Successfully.";
$data["redirect"]="site/viewdesigner";
$this->load->view("redirect",$data);
}
}
public function deletedesigner()
{
$access=array("1");
$this->checkaccess($access);
$this->designer_model->delete($this->input->get("id"));
$data["redirect"]="site/viewdesigner";
$this->load->view("redirect",$data);
}
public function viewdesign()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewdesign";
$data["base_url"]=site_url("site/viewdesignjson");
$data["title"]="View design";
$this->load->view("template",$data);
}
function viewdesignjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`florian_design`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`florian_design`.`image`";
$elements[1]->sort="1";
$elements[1]->header="image";
$elements[1]->alias="image";
$elements[2]=new stdClass();
$elements[2]->field="`florian_design`.`order`";
$elements[2]->sort="1";
$elements[2]->header="order";
$elements[2]->alias="order";
$elements[3]=new stdClass();
$elements[3]->field="`florian_designer`.`name`";
$elements[3]->sort="1";
$elements[3]->header="designername";
$elements[3]->alias="designername";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `florian_design` LEFT OUTER JOIN `florian_designer` ON `florian_design`.`designer`=`florian_designer`.`id`");
$this->load->view("json",$data);
}

public function createdesign()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createdesign";
$data['designer'] =$this->designer_model->getdesignerropdown();
$data["title"]="Create design";
$this->load->view("template",$data);
}
public function createdesignsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("image","image","trim");
$this->form_validation->set_rules("order","order","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createdesign";
$data["title"]="Create design";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$image=$this->menu_model->createImage();
$order=$this->input->get_post("order");
$designer=$this->input->get_post("designer");
if($this->design_model->create($image,$order,$designer)==0)
$data["alerterror"]="New design could not be created.";
else
$data["alertsuccess"]="design created Successfully.";
$data["redirect"]="site/viewdesign";
$this->load->view("redirect",$data);
}
}
public function editdesign()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editdesign";
$data["title"]="Edit design";
$data['designer'] =$this->designer_model->getdropdown();
$data["before"]=$this->design_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editdesignsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("image","image","trim");
$this->form_validation->set_rules("order","order","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editdesign";
$data["title"]="Edit design";
$data["before"]=$this->design_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$image=$this->menu_model->createImage();
$order=$this->input->get_post("order");
$designer=$this->input->get_post("designer");
if($this->design_model->edit($id,$image,$order,$designer)==0)
$data["alerterror"]="New design could not be Updated.";
else
$data["alertsuccess"]="design Updated Successfully.";
$data["redirect"]="site/viewdesign";
$this->load->view("redirect",$data);
}
}
public function deletedesign()
{
$access=array("1");
$this->checkaccess($access);
$this->design_model->delete($this->input->get("id"));
$data["redirect"]="site/viewdesign";
$this->load->view("redirect",$data);
}
public function viewcontact()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewcontact";
$data["base_url"]=site_url("site/viewcontactjson");
$data["title"]="View contact";
$this->load->view("template",$data);
}
function viewcontactjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`florian_contact`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`florian_contact`.`name`";
$elements[1]->sort="1";
$elements[1]->header="name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`florian_contact`.`email`";
$elements[2]->sort="1";
$elements[2]->header="email";
$elements[2]->alias="email";
$elements[3]=new stdClass();
$elements[3]->field="`florian_contact`.`phone`";
$elements[3]->sort="1";
$elements[3]->header="phone";
$elements[3]->alias="phone";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `florian_contact`");
$this->load->view("json",$data);
}

public function createcontact()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createcontact";
$data["title"]="Create contact";
$this->load->view("template",$data);
}
public function createcontactsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","name","trim");
$this->form_validation->set_rules("email","email","trim");
$this->form_validation->set_rules("phone","phone","trim");
$this->form_validation->set_rules("message","message","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createcontact";
$data["title"]="Create contact";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$email=$this->input->get_post("email");
$phone=$this->input->get_post("phone");
$message=$this->input->get_post("message");
if($this->contact_model->create($name,$email,$phone,$message)==0)
$data["alerterror"]="New contact could not be created.";
else
$data["alertsuccess"]="contact created Successfully.";
$data["redirect"]="site/viewcontact";
$this->load->view("redirect",$data);
}
}
public function editcontact()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editcontact";
$data["title"]="Edit contact";
$data["before"]=$this->contact_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editcontactsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("name","name","trim");
$this->form_validation->set_rules("email","email","trim");
$this->form_validation->set_rules("phone","phone","trim");
$this->form_validation->set_rules("message","message","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editcontact";
$data["title"]="Edit contact";
$data["before"]=$this->contact_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$email=$this->input->get_post("email");
$phone=$this->input->get_post("phone");
$message=$this->input->get_post("message");
if($this->contact_model->edit($id,$name,$email,$phone,$message)==0)
$data["alerterror"]="New contact could not be Updated.";
else
$data["alertsuccess"]="contact Updated Successfully.";
$data["redirect"]="site/viewcontact";
$this->load->view("redirect",$data);
}
}
public function deletecontact()
{
$access=array("1");
$this->checkaccess($access);
$this->contact_model->delete($this->input->get("id"));
$data["redirect"]="site/viewcontact";
$this->load->view("redirect",$data);
}

}
?>
