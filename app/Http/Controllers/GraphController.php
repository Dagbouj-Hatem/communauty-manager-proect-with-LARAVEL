<?php

namespace App\Http\Controllers;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class GraphController extends Controller
{
	// link  : https://quantizd.com/facebook-php-sdk-with-laravel/

	// API graph explorateur
	// https://developers.facebook.com/tools/explorer/?method=GET&path=me%3Ffields%3Did%2Cname%2Clast_name%2Cage_range%2Cgender&version=v3.2


	// FB docs pages 
	// https://developers.facebook.com/docs/pages/


	// FB doc test  users
	//https://developers.facebook.com/docs/graph-api/reference/v3.2/app/accounts/test-users

	private $token= 'EAAFKE7ZAfINcBAA4rPlLZAl4z6eF4y5EMIzAPCV5ZCCaI3QDmKZA3Difd6cicX9CwT1eNkL97zKFQAETwRvTKSEYRRt78NWHA75tCyRxYigdCMWxaxeU4nEqQvbPTbGwaFGfp1yauMIozzag5WYhhVbXm4kK9F2VhKIbaN28YOtDkPD9iHQa5REeg9em4EGZB8nEgtgD3e37Cfx0VQqwYi5MY143KqQDtIE3QabZAbtz0k11EHheRu';
    private $api;
    public function __construct()
    {
/*        $this->middleware(function ($request, $next) use ($fb) {
            $fb->setDefaultAccessToken($token);
            $this->api = $fb;
            return $next($request);
        });*/
    /*    $this->api =  new \Facebook\Facebook([
			  'app_id' => '{app-id}',
			  'app_secret' => '{app-secret}',
			  'default_graph_version' => 'v2.10',
			  //'default_access_token' => '{access-token}', // optional
			]);*/
        $config = config('services.facebook');
        $this->api =  new Facebook([
                'app_id' => $config['client_id'],
                'app_secret' => $config['client_secret'],
                'default_graph_version' => 'v2.6',
                'default_access_token' => $this->token,
            ]);
    }
 
    public function retrieveUserProfile(){
        try {
 
            $params = "first_name,last_name,age_range,gender";
 
            $user = $this->api->get('/me?fields='.$params)->getGraphUser();
 
            dd($user);
 
        } catch (FacebookSDKException $e) {
 			dd($e);
        }
 
    }


    public function createPage()
    {
    	try {
			  // Returns a `FacebookFacebookResponse` object
			  $response = $this->api->post(
			    '/100758444369227/accounts',
			    array (
			      'name' => 'Maggies Blog',
			      'category_enum' => 'PERSONAL_BLOG',
			      'about' => 'Just trying the API',
			      'picture' => 'https://www.codeur.com/system/user_profiles/avatars/000/284/487/large/avatar.jpg?1540992669',
			      'cover_photo' => '{"url":"https://www.kogstatic.com/gen_cache/eb/43/eb43e02859974658a34dc1ded9290012_790x381.jpg"}'
			    ),
			    $this->token
			  )->getGraphNode()->asArray();

			  if($response['id'])
			  {
	           // post created
	        	return $response['id'];
	          }

			} catch(FacebookResponseException $e) { 
			  return Redirect::back()->withErrors(['msg','Graph returned an error: ' . $e->getMessage()]);
			} catch(FacebookSDKException $e) {
			  echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  exit;
			}
			$graphNode = $response->getGraphNode()->asArray();
				dd($graphNode);

    }
    // Posting to Profiles
    // exception 
    //Requires either "publish_to_groups" permission and app being installed in the group, or "manage_pages" and "publish_pages" as an admin wit

    public function publishToProfile(Request $request)
    {
	   try {
	        $response = $this->api->post('/me/feed', [
	            'message' => 'hello w !',
	        ])->getGraphNode()->asArray();
	        if($response['id']){
	           // post created
	        	return $response['id'];
	        }
	    }
	    catch(FacebookResponseException $e) {
			  echo 'Graph returned an error: ' . $e->getMessage();
			  exit;
			}  catch (FacebookSDKException $e) {
	        dd($e); // handle exception
	    }

	    /* PHP SDK v5.0.0 */
/* make the API call */
		/*try {
		  // Returns a `Facebook\FacebookResponse` object
		  $response = $this->api->post(
		    '/242892926633064/accounts/test-users',
		    array (
		      'installed' => 'true',
		    ),
		    '{access-token}'
		  );
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}
		$graphNode = $response->getGraphNode();*/
		/* handle the result */
	}

	// Posting to Pages 

	public function getPageAccessToken($page_id)
	{
		
		    try {
		         // Get the \Facebook\GraphNodes\GraphUser object for the current user.
		         // If you provided a 'default_access_token', the '{access-token}' is optional.
		         $response = $this->api->get('/me/accounts', $this->token);
		    } catch(FacebookResponseException $e) {
		        // When Graph returns an error
		        echo 'Graph returned an error: ' . $e->getMessage();
		        exit;
		    } catch(FacebookSDKException $e) {
		        // When validation fails or other local issues
		        echo 'Facebook SDK returned an error: ' . $e->getMessage();
		        exit;
		    }
		 
		    try {
		        $pages = $response->getGraphEdge()->asArray();
		        foreach ($pages as $key) {
		            if ($key['id'] == $page_id) {
		                return $key['access_token'];
		            }
		        }
		    } catch (FacebookSDKException $e) {
		        dd($e); // handle exception
		    }
	}

	public function publishToPage(Request $request){
 
		    $page_id = '343232206404542';
		 
		    try {
		        $post = $this->api->post('/' . $page_id . '/feed', array('message' => 'request->message'), $this->getPageAccessToken($page_id));
		 
		        $post = $post->getGraphNode()->asArray();
		 
		        dd($post);
		 
		    } catch (FacebookSDKException $e) {
		        dd($e); // handle exception
		    }
		}

	// Creating Photo Posts

	/*public function publishToProfile(Request $request){
		    $absolute_image_path = '/var/www/larave/storage/app/images/lorde.png';
		    try {
		        $response = $this->api->post('/me/feed', [
		            'message' => $request->message,
		            'source'    =>  $this->api->fileToUpload('/path/to/file.jpg')
		        ])->getGraphNode()->asArray();
		 
		        if($response['id']){
		           // post created
		        }
		    } catch (FacebookSDKException $e) {
		        dd($e); // handle exception
		    }
		}

*/



}