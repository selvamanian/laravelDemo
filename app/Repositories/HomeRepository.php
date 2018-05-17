<?php
/**
   * Home Repository Class
   *
   * @package    Laravel
   * @author     Selvamanian <selvamanian@optisolbusiness.com>
   */
namespace App\Repositories;

use App\Interfaces\HomeInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use App\Http\Traits\Utillity;
use App\Http\Model\User;
use DB;
use File;
use Validator;
use View;
use Auth;

/**
 * Decouples buisiness logic from object storage, manipulation and internal logic over Module entity.
 */
class HomeRepository implements HomeInterface
{
    use Utillity;
    /**
     * 
     * home page search form
     *
     * @param string $username 
     * @return view
     */
    public function home(){
    	$data = ['userList'=>'','followers'=>''];
    	$response = $this->getReponse(FALSE,1,$data);
    	
    	return View::make('Home.search')->with($response);	
    }
    /**
     * 
     * To search user 
     *
     * @param request
     * @return view
     */
    public function getSearch($post){
    	
    	if(isset($post['username']) && !empty($post)){
    		$userApi 	=  'users/'.$post['username'];
    		$userList 	= json_decode($this->getUsersFromGit($userApi));
    		
    		$data = ['userList'=>'','followers'=>''];	
    		if( isset($userList) && !isset($userList->message)){
    			$userList->nextpage = 1;
    			
    			if($userList->followers){
	    			$followersApi = $userApi.'/followers?page=1&per_page=10';
	    			$followerList = json_decode($this->getUsersFromGit($followersApi));
	    			$userList->nextpage = 2;
	    			$data['followers'] = $followerList;

	    		}
	    	
	    		$data['userList'] = $userList;	
	    		//$data['status'] = true;
	    		$response = $this->getReponse(TRUE,1,$data);
    		}else{
    			//$data['status'] = false;
    			$response = $this->getReponse(FALSE,4,$data);
    		}
    		
        	return View::make('Home.search')->with($response);	
    	}
    	else{
    		$data = $this->getReponse(FALSE,3,FALSE);
    		return View::make('Home.search')->with($data);	
    	}
    	
    }
    /**
     * 
     * To get more followers 
     *
     * @param request
     * @return json
     */
    public function getMore($post){
    	
    	if(isset($post['username']) && !empty($post)){
    		$userApi 	=  'users/'.$post['username'];
    		
			$followersApi = $userApi.'/followers?page='.$post['nextpage'].'&per_page=10';
			$followerList = json_decode($this->getUsersFromGit($followersApi));
    		
    		$data = ['followers'=>$followerList];
        	return json_encode($data);	
    	}
    }
}