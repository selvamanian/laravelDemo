<?php
/**
   * Home Controller Class
   *
   * @package    Laravel
   * @author     Selvamanian <selvamanian@optisolbusiness.com>
   */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use App\Repositories\HomeRepository;
use App\Http\Traits\Utillity;
use Validator;

class HomeController extends Controller
{
    use Utillity;
    /**
     * @var ResponseRepository
     */
    private $responseRepository;

    /**
     * Controller construcor.
     *
     * @param ResponseRepository $responseRepository
     */
    public function __construct(HomeRepository $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }
    /**
     * 
     * home page search form
     *
     * @param string $username 
     * @return view
     */
    public function home()
	{
	    // show the form
	    return $this->homeRepository->home();
	}
	/**
     * 
     * To search user 
     *
     * @param request
     * @return view
     */
	public function getSearch()
	{
		$post   = $this->getData($_REQUEST);
		$rules = array(
            'username'        => 'required'
        );
        $validator = Validator::make($post, $rules);
        if ($validator->fails()) {
            return Redirect::route('category.create')->withErrors($validator->messages())->withInput();
        } else {
	    	return $this->homeRepository->getSearch($post);
		}
	}
	/**
     * 
     * To get more followers 
     *
     * @param request
     * @return json
     */
	public function getMore()
	{
		$post   = $this->getData($_REQUEST);
		return $this->homeRepository->getMore($post);
	
	}
	
}