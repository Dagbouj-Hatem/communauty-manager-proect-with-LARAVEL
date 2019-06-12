<?php

namespace App\Http\Controllers;

use App\DataTables\PostDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\PostRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Page;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Redirect;
class PostController extends AppBaseController
{
    // API FB 
    private $api;

    /** @var  PostRepository */
    private $postRepository;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepository = $postRepo;

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
     * Display a listing of the Post.
     *
     * @param PostDataTable $postDataTable
     * @return Response
     */
    public function index(PostDataTable $postDataTable)
    {
        return $postDataTable->render('posts.index');
    }

    /**
     * Show the form for creating a new Post.
     *
     * @return Response
     */
    public function create($id)
    {
        return view('posts.create',compact('id'));
    }

    /**
     * Store a newly created Post in storage.
     *
     * @param CreatePostRequest $request
     *
     * @return Response
     */
    public function store(CreatePostRequest $request)
    {

        $page_id = Page::where('id',$request->id)->get()->First()->id_fb_page;

         
            try {

                if($request->image_url)
                {
                    $post = $this->api->post('/' . $page_id . '/photos', 
                    array('message' => $request->content , 'url' => $request->image_url,),
                     $this->getPageAccessToken($page_id))->getGraphNode()->asArray();

                    if($post['id']){
                            // post created
                            $request['post_id']=$post['post_id'];
                    }

                }else{

                    $post = $this->api->post('/' . $page_id . '/feed', 
                    array('message' => $request->content ,),
                     $this->getPageAccessToken($page_id))->getGraphNode()->asArray();

                     if($post['id']){
                            // post created
                            $request['post_id']=$post['id'];
                    }
                }
               
                    $request['page_id']=$request->id;

                    // saved
                        $post = $this->postRepository->create($request->all());
                        //Page::where('id',$request->id)->get()->First()->posts()->associate($post)->save();
                        $post->page()->associate(Page::where('id',$request->id)->get()->First())->save();
                        Flash::success('Post saved successfully.');

                      return redirect(route('posts.index'));

                
         
                } catch(FacebookResponseException $e) {

                return Redirect::back()->withErrors(['Graph returned an error: ' . $e->getMessage()]); 
                } catch(FacebookSDKException $e) { 
                  return Redirect::back()->withErrors(['Facebook SDK returned an error: ' . $e->getMessage()]); 
                }
     
       
    }

    /**
     * Display the specified Post.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('posts.index'));
        }

        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified Post.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('posts.index'));
        }

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified Post in storage.
     *
     * @param  int              $id
     * @param UpdatePostRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePostRequest $request)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('posts.index'));
        }

        $page_id = $post->page->id_fb_page;
         
            try {

                    $post = $this->api->post('/' . $post->post_id . '/', 
                    array('message' => $request->content ,),
                     $this->getPageAccessToken($page_id))->getGraphNode()->asArray();
                
                // update in local  DB 
                    
                        $post = $this->postRepository->update($request->all(), $id);

                        Flash::success('Post updated successfully.');

                        return redirect(route('posts.index'));
                
         
                } catch(FacebookResponseException $e) {

                return Redirect::back()->withErrors(['Graph returned an error: ' . $e->getMessage()]); 
                } catch(FacebookSDKException $e) { 
                  return Redirect::back()->withErrors(['Facebook SDK returned an error: ' . $e->getMessage()]); 
                }

    }

    /**
     * Remove the specified Post from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('Post not found');

            return redirect(route('posts.index'));
        }

        // call  fb api 

        $page_id = $post->page->id_fb_page;
        
            
            try {

                    // delete from  fb  
                    $post1 = $this->api->delete('/' . $post->post_id . '/', 
                    array(),
                     $this->getPageAccessToken($page_id)); 
                    
                    // delete from  db local 

                    $this->postRepository->delete($id);

                    Flash::success('Post deleted successfully.');

                     return redirect(route('posts.index'));
                
         
                } catch(FacebookResponseException $e) {  

                return Redirect::back()->withErrors(['Graph returned an error: ' . $e->getMessage()]); 
                } catch(FacebookSDKException $e) {   
                  return Redirect::back()->withErrors(['Facebook SDK returned an error: ' . $e->getMessage()]); 
                }
  
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
}
