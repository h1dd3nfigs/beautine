<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RFlib\MyYouTubeAPILibrary ;
use App\RFlib\YTConfig ;

class BloggersController extends Controller {



	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request, YTConfig $ytconfig) // dependency injection, automatic resolution 
	{
		$this->request = $request ;
		$this->myYoutube = new MyYouTubeAPILibrary($ytconfig) ;

	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		//return view('welcome');
		
	}


	public function show()
	{
		
	}

	
	public function store() 
	{

		
		if($this->request->input('blogger_username2') != null )
		{
			$uploads_list_id = $this->request->input('uploads_list_id');
			$filtered_uploaded_vids = $this->myYoutube->getChannelUploads($uploads_list_id);

			return view('bloggers.show')->with('filtered_uploaded_vids',$filtered_uploaded_vids);
		}
	
		$blogger_username = $this->request->input('blogger_username');
		$channel_summary = $this->myYoutube->getBloggerChannel($blogger_username);


		return view('welcome')->with([
									'channel_summary'=>$channel_summary,
									
									]);
	}
	

}
