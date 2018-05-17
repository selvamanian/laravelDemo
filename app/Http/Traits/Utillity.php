<?php 
/**
   * Api Trait Class
   *
   * @package    Laravel
   * @author     Selvamanian <selvamanian@optisolbusiness.com>
   */

namespace app\Http\Traits;

use Illuminate\Support\Facades\Input;
use Request;
use Config;
use File;
use Log;
use URL;

use app\Http\Model\User;

trait Utillity {
	/**
     * 
     * To get http request data for the current request
     *
     * @param array $data  
     * @return array
    */
    public function getData($data) 
    {
        $post = Input::json()->all();
        if (!isset($post) || empty($post))
            $post = Input::all();
        return $post;
    }

    /**
     * 
     * To get response for the api 
     *
     * @param boolean $status  
     * @param integer $code  
     * @param array $result  
     * @return array
     */
    public function getReponse($status, $code, $result = array('*'),$manual=null) 
    {

        $response['status']  = $status;
        $response['code']    = $code;
        $response['message'] = Config::get('errorcode')[$code];
        if($manual)
        $response['body']  = $result;    
        else
        $response['result']  = $result;
        return $response;
    }
    /**
     * 
     * To get users from github
     *
     * @param string $request 
     * @return array
     */
    public function getUsersFromGit($request){

        $ch = curl_init();
 
        // Now set some options (most are optional)
        // Set URL to download
        
        curl_setopt($ch, CURLOPT_URL, ENV('GITHUB_URL').$request);
        // Set a referer
        //curl_setopt($ch, CURLOPT_REFERER, "http://www.example.org/yay.htm");
     
        // User agent
        //curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
     
        // Include header in result? (0 = yes, 1 = no)

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/vnd.github.v3+json',
            'Authorization: token '.ENV('GITHUB_TOKEN'),
            'User-Agent: GitHub-'.ENV('GITHUB_USERNAME')
          ]);

     
        // Should cURL return or print out the data? (true = return, false = print)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
     
        // Download the given URL, and return output
        $output = curl_exec($ch);
     
        // Close the cURL resource, and free system resources
        curl_close($ch);

        return $output;
 
    }
}