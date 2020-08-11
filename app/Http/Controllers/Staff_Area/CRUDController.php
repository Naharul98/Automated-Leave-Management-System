<?php

namespace App\Http\Controllers\Staff_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*
|-----------------------------------------------------------------------------------
| CRUD Controller
|------------------------------------------------------------------------------------
|
| This abstract class models the controllers for Create, update, delete read operations
| on the database.
|
*/
abstract class CRUDController extends Controller
{    
    //data to be passed inside view
    protected $data = [];
    //path of the view for create operations
    protected $createView;
    //path of the view for update operations
    protected $updateView;
    //path of the view for delete operations
    protected $deleteView;    
    //path of the view for redirections after CRUD operations
    protected $redirectView;
    //operation successful message
    protected $operation_successful;
    //a message describing the operation
    protected $operation_message;
    //primary key of the model
    protected $primaryKey;
    
    /**
     * Handles a request (either GET or POST) for performing Create operations
     *
     * @param Request $request
     * @return view
     */
    public function create(Request $request)
    {
        $this->handleCreateGetRequest();
        
        if($request->isMethod('post'))
        {
            $this->validateForm($request);
            $this->handleCreatePostRequest($request);
            return $this->handleRedirect();
        }
        
        return view($this->createView,$this->data);
    }

    /**
     * Takes an id of the primary key
     * and handles requests (either GET or POST) for performing Update operations
     *
     * @param Request $request
     * @return view
     */
    public function update(Request $request, $id)
    {
        $this->handleUpdateGetRequest($id);
        if($request->isMethod('post'))
        {
            $this->validateForm($request);
            $this->handleUpdatePostRequest($request,$id);
            return $this->handleRedirect();
        }
        return view($this->updateView,$this->data);
    }
    
    /**
     * Takes an id of the primary key
     * and handles requests (either GET or POST) for performing Delete operation
     * @param Request $request Int $id
     * @return view
     */
    public function delete(Request $request,$id)
    {
        $this->handleDeleteGetRequest($id);
        if($request->isMethod('post'))
        {
            $this->handleDeletePostRequest($id);
            return $this->handleRedirect();
        }
        return view($this->deleteView,$this->data);
    }

    /**
     * Handles redirections depending on operation success or failure
     *
     * @return redirect
     */
    protected function handleRedirect()
    {
        if($this->operation_successful)
        {
            return redirect($this->redirectView)->with('success',$this->operation_message);
        }
        else
        {
            return redirect($this->redirectView)->with('error',$this->operation_message);
        }
    }

    /**
     * An method for handling GET request operations for Create
     *
     */
    protected function handleCreateGetRequest(){}

    /**
     * A general implementation for handling POST request operations for Create
     * @param Request $request
     */
    protected function handleCreatePostRequest(Request $request)
    {
        $this->createEntry($request);
        $this->redirect_successful('created');
    }

    /**
     * A general implementation for handling GET requests for Update
     * Takes primary key of the model and adds data to pass into the views for the GET request
     * @param int $id
     */
    protected function handleUpdateGetRequest($id)
    {
        $this->data['entry']=$this->getModel()->find($id);        
    }

    /**
     * A general implementation for handling POST request operations for Update
     * @param Request $request int $id
     * @return redirect
     */ 
    protected function handleUpdatePostRequest(Request $request, $id)
    {
        $this->updateEntry($request, $id);
        $this->redirect_successful('updated');
    }

    /**
     * A general implementation for handling GET requests for Delete
     * Takes primary key of the model and adds data to pass into the views for the GET request
     * @param int $id
     */
    protected function handleDeleteGetRequest($id)
    {
        $this->data['entry']=$this->getModel()->find($id);
    }

    /**
     * A general implementation for handling POST request operations for Delete
     * @param int $id
     * @return redirect
     */ 
    protected function handleDeletePostRequest($id)
    {
        $this->getModel()->where($this->primaryKey,$id)->delete();
        $this->redirect_successful('deleted');
    }

    /**
     * A general implementation for updating operation message for operation success
     * @param string $operation_name
     */ 
    protected function redirect_successful($operation_name)
    {
        $this->operation_successful=true;
        $this->operation_message=$this->getModel()->getName().' has been successfully '.$operation_name;
    }
    /**
     * A general implementation for updating operation message for operation failure
     * @param string $operation_name
     */ 
    protected function redirect_unsuccessful($operation_name)
    {
        $this->operation_successful=false;
        $this->operation_message=$this->getModel()->getName().' has not been '.$operation_name.' successfully';
    } 

    /**
     * An abstract method for getting the model on which the CRUD operation is to be done
     */ 
    protected abstract function getModel();

    /**
     * An abstract method for validating data passed into forms
     * @param Request $request
     */ 
    protected abstract function validateForm($request);

    /**
     * An abstract method for executing CREATE operations for a model/table in database
     * @param Request $request
     */ 
    protected abstract function createEntry($request);
    /**
     * An abstract method for executing Update operations for a model/table in database
     * takes the primary key of the model data on which the operation is to be done
     * @param Request $request int $id
     */ 
    protected abstract function updateEntry($request, $id);

    
}
