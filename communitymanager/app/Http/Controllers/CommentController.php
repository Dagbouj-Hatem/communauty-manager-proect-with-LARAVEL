<?php

namespace App\Http\Controllers;

use App\DataTables\CommentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Repositories\CommentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Post; 
use App\Page;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Redirect;
class CommentController extends AppBaseController
{

    // API FB 
    private $api;

    /** @var  CommentRepository */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepo)
    {
        $this->commentRepository = $commentRepo;
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
     * Display a listing of the Comment.
     *
     * @param CommentDataTable $commentDataTable
     * @return Response
     */
    public function index(CommentDataTable $commentDataTable)
    {
        return $commentDataTable->render('comments.index');
    }

    /**
     * Show the form for creating a new Comment.
     *
     * @return Response
     */
    public function create($id)
    {
        return view('comments.create',compact('id'));
    }

    /**
     * Store a newly created Comment in storage.
     *
     * @param CreateCommentRequest $request
     *
     * @return Response
     */
    public function store(CreateCommentRequest $request)
    {
       $post_id=Post::where('id',$request->id)->get()->First()->post_id;
       $page_id= Post::where('id',$request->id)->get()->First()->page->id_fb_page;
       
        try {
 
                    $comment = $this->api->post('/' . $post_id . '/comments', 
                    array('message' => $request->content ,),
                     $this->getPageAccessToken($page_id))->getGraphNode()->asArray();

                     if($comment['id'])
                     {
                            // comment created
                            $request['comment_id']=$comment['id'];
                      } 

                    // saved in local data base 
                      $comment = $this->commentRepository->create($request->all());

                     $comment->post()->associate(Post::where('id',$request->id)->get()->First())->save();
                       
                      
                    // return  statements
                        Flash::success('Comment saved successfully.');

                        return redirect(route('comments.index'));
                
         
                } catch(FacebookResponseException $e) {

                return Redirect::back()->withErrors(['Graph returned an error: ' . $e->getMessage()]); 
                } catch(FacebookSDKException $e) { 
                  return Redirect::back()->withErrors(['Facebook SDK returned an error: ' . $e->getMessage()]); 
                }
     
    }

    /**
     * Display the specified Comment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $comment = $this->commentRepository->findWithoutFail($id);

        if (empty($comment)) {
            Flash::error('Comment not found');

            return redirect(route('comments.index'));
        }

        return view('comments.show')->with('comment', $comment);
    }

    /**
     * Show the form for editing the specified Comment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $comment = $this->commentRepository->findWithoutFail($id);

        if (empty($comment)) {
            Flash::error('Comment not found');

            return redirect(route('comments.index'));
        }

        return view('comments.edit')->with('comment', $comment);
    }

    /**
     * Update the specified Comment in storage.
     *
     * @param  int              $id
     * @param UpdateCommentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCommentRequest $request)
    {
        $comment = $this->commentRepository->findWithoutFail($id);

        if (empty($comment)) {
            Flash::error('Comment not found');

            return redirect(route('comments.index'));
        }


        // update section 
        try{

        // update in facebook 
          $post = $this->api->post('/' . $comment->comment_id . '/', 
                    array('message' => $request->content ,),
                     $this->getPageAccessToken($comment->post->page->id_fb_page))
          ->getGraphNode()->asArray();
        // update in local  db  
        $comment = $this->commentRepository->update($request->all(), $id);

        Flash::success('Comment updated successfully.');

        return redirect(route('comments.index'));

        } catch(FacebookResponseException $e) {

        return Redirect::back()->withErrors(['Graph returned an error: ' . $e->getMessage()]); 
        } catch(FacebookSDKException $e) { 
          return Redirect::back()->withErrors(['Facebook SDK returned an error: ' . $e->getMessage()]); 
        }

    }

    /**
     * Remove the specified Comment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $comment = $this->commentRepository->findWithoutFail($id);

        if (empty($comment)) {
            Flash::error('Comment not found');

            return redirect(route('comments.index'));
        }


        try{

            // delete from  fb 

             $this->api->delete('/' . $comment->comment_id . '/', 
                    array(),
                     $this->getPageAccessToken($comment->post->page->id_fb_page)); 
                    
            // delete from  local  db 

            $this->commentRepository->delete($id);

            Flash::success('Comment deleted successfully.');

            return redirect(route('comments.index'));

        } catch(FacebookResponseException $e) {

        return Redirect::back()->withErrors(['Graph returned an error: ' . $e->getMessage()]); 
        } catch(FacebookSDKException $e) { 
          return Redirect::back()->withErrors(['Facebook SDK returned an error: ' . $e->getMessage()]); 
        }
    }

    // get access token  
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
