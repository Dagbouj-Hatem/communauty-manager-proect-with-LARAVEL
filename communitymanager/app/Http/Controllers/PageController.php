<?php

namespace App\Http\Controllers;

use App\DataTables\PageDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Repositories\PageRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Redirect;

class PageController extends AppBaseController
{ 
     
    // API FB 
    private $api;

    /** @var  PageRepository */
    private $pageRepository;

    public function __construct(PageRepository $pageRepo)
    {
        $this->pageRepository = $pageRepo;

        //// App FB config
        $config = config('services.facebook');
        // create a facebook API
         $this->api =  new Facebook([
                'app_id' => $config['client_id'],
                'app_secret' => $config['client_secret'],
                'default_graph_version' => 'v2.6',
                'default_access_token' => $config['token'],
            ]);
    }

    /**
     * Display a listing of the Page.
     *
     * @param PageDataTable $pageDataTable
     * @return Response
     */
    public function index(PageDataTable $pageDataTable)
    {
        return $pageDataTable->render('pages.index');
    }

    /**
     * Show the form for creating a new Page.
     *
     * @return Response
     */
    public function create()
    {
        return view('pages.create');
    }

    /**
     * Store a newly created Page in storage.
     *
     * @param CreatePageRequest $request
     *
     * @return Response
     */
    public function store(CreatePageRequest $request)
    {
        
            // access token 
            $config = config('services.facebook');

             // FB Graph API section
             try {
                  // Returns a `FacebookFacebookResponse` object
                  $response = $this->api->post(
                    '/'.$config['user_id'].'/accounts', // ID USER
                    [
                        'name' => $request->name, 
                        'category_enum' => 'PERSONAL_BLOG',
                        'about' => $request->about,
                        'picture' => $request['picture'] ,
                        'cover_photo'=> json_encode([
                                'url' => $request['cover_photo']
                            ])
                    ]
                    , $config['token']
                  )->getGraphNode()->asArray();

                  if($response['id'])
                  {
                   // page created successfully
                    $input = array();

                    $input['url']=$this->getPageAccessURL($response['id']);
                    $input['name']= $request->name;
                    $input['about'] = $request->about;
                    $input['id_fb_page']= $response['id'];
                    $input['picture']= $request->picture;
                    $input['cover_photo']= $request['cover_photo']; 
                    $input['access_token']= $this->getPageAccessToken($response['id']); 

                    
                    // return  staements
                    $page = $this->pageRepository->create($input);

                        Flash::success('Page saved successfully.');

                        return redirect(route('pages.index'));
                  }



                } catch(FacebookResponseException $e) {

                return Redirect::back()->withErrors(['Graph returned an error: ' . $e->getMessage()]); 
                } catch(FacebookSDKException $e) { 
                  return Redirect::back()->withErrors(['Facebook SDK returned an error: ' . $e->getMessage()]); 
                }

        
    }

    /**
     * Display the specified Page.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('Page not found');

            return redirect(route('pages.index'));
        }

        return view('pages.show')->with('page', $page);
    }

    /**
     * Show the form for editing the specified Page.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('Page not found');

            return redirect(route('pages.index'));
        }

        return view('pages.edit')->with('page', $page);
    }

    /**
     * Update the specified Page in storage.
     *
     * @param  int              $id
     * @param UpdatePageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePageRequest $request)
    {
        $page = $this->pageRepository->findWithoutFail($id);
        
        if (empty($page)) {
            Flash::error('Page not found');

            return redirect(route('pages.index'));
        }

        //update fb api 
         // access token 
            $config = config('services.facebook');

             // FB Graph API section
             try {
                
                  // Returns a `FacebookFacebookResponse` object
                  $response = $this->api->post('/'.$page->id_fb_page.'/', 
                    [   
                        'about' => $request->about,
                    ]
                    , $this->getPageAccessToken($page->id_fb_page)
                  ); 

                  
                   // page created successfully
                    $input = array();

                    $input['url']=$page->url;
                    $input['name']= $page->name;
                    $input['about'] = $request->about; // updated 
                    $input['id_fb_page']= $page->id_fb_page;
                    $input['picture']= $page->picture;
                    $input['cover_photo']= $page->cover_photo; 
                    $input['access_token']= $this->getPageAccessToken($page->id_fb_page);//updated 
                    
                    // return  staements
                        $page = $this->pageRepository->update($input, $id);

                            Flash::success('Page updated successfully.');

                                 return redirect(route('pages.index'));


                } catch(FacebookResponseException $e) {
                       
                return Redirect::back()->withErrors(['Graph returned an error: ' . $e->getMessage()]); 
                } catch(FacebookSDKException $e) { 
                       
                  return Redirect::back()->withErrors(['Facebook SDK returned an error: ' . $e->getMessage()]); 
                }
        
    }

    /**
     * Remove the specified Page from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('Page not found');

            return redirect(route('pages.index'));
        }


        // delete fb  page with  api 
        $this->deletePage($page->id_fb_page);

        $this->pageRepository->delete($id);

        Flash::success('Page deleted successfully.');

        return redirect(route('pages.index'));
    }




    // get page access token 
    public function getPageAccessToken($page_id) 
    {
        
            // access token 
            $config = config('services.facebook');

            try {
                 // Get the \Facebook\GraphNodes\GraphUser object for the current user.
                 // If you provided a 'default_access_token', the '{access-token}' is optional.
                 $response = $this->api->get('/me/accounts', $config['token']);

                 // return  statement 
                  $pages = $response->getGraphEdge()->asArray();
                  
                    foreach ($pages as $key) {
                        if ($key['id'] == $page_id) {
                            return $key['access_token'];
                        }
                    }

            } 
            // catch  section 
            catch(FacebookResponseException $e) {

            return Redirect::back()->withErrors(['Graph returned an error: ' . $e->getMessage()]); 
            } catch(FacebookSDKException $e) { 
              return Redirect::back()->withErrors(['Facebook SDK returned an error: ' . $e->getMessage()]); 
            } 
    }

    // get page access URL 
    public function getPageAccessURL($page_id) 
    {
        
            // access token 
            $config = config('services.facebook');

            try {
                 // Get the \Facebook\GraphNodes\GraphUser object for the current user.
                 // If you provided a 'default_access_token', the '{access-token}' is optional.
                 $response = $this->api->get('/'.$page_id.'?fields=link',$config['token'])->getDecodedBody();

                 // return  statement 
                return $response['link'];
                    
            } 
            // catch  section 
            catch(FacebookResponseException $e) {
                    return Redirect::back()->withErrors(['Graph returned an error: ' . $e->getMessage()]); 
            } catch(FacebookSDKException $e) { 
                return Redirect::back()->withErrors(['Facebook SDK returned an error: ' . $e->getMessage()]); 
            } 
    }


    // delete fb page
    public function deletePage($page_id ) 
    {
        
            // access token 
            $config = config('services.facebook');

            try {
                 // Get the \Facebook\GraphNodes\GraphUser object for the current user.
                 // If you provided a 'default_access_token', the '{access-token}' is optional.
                 /*  $response = $this->api->delete(
                            '/'.$page_id.'/',
                            [
                                'location_page_id'=> $page_id ,
                                //'access_token'=> $config['token']//$this->getPageAccessToken($page_id),
                            ]
                            //'{access-token}'
                            ,$config['token']//
                            //,$this->getPageAccessToken($page_id) 
                          );
             /*    $response = $this->api->delete('/'.$page_id.'/?access_token='.$config['token'],[],$config['token']);*/
                 /*dd($response);
                 // return  statement 
                  $pages = $response->getGraphEdge()->asArray();
                  
                    foreach ($pages as $key) {
                        if ($key['id'] == $page_id) {
                            return $key['access_token'];
                        }
                    }*/
                /*$response = $this->api->delete('/'.$page_id.'/roles',
                    array ('location_page_id'=> $page_id,
                            'store_number'=>$page_id,
                            'admin_id'=>'300960933894277'
                            ),
                    $this->getPageAccessToken($page_id) 
                  )->getGraphNode();*/
                $response= $this->api->delete('/' . $page_id . '/', 
                    array(),
                     $this->getPageAccessToken($page_id)); 
                dd($response);

            } 
            // catch  section 
            catch(FacebookResponseException $e) {
                dd($e);
            return Redirect::back()->withErrors(['Graph returned an error: ' . $e->getMessage()]); 
            } catch(FacebookSDKException $e) { 
                dd($e);
              return Redirect::back()->withErrors(['Facebook SDK returned an error: ' . $e->getMessage()]); 
            } 
    }
}
