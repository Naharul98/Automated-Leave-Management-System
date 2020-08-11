<?php

namespace App\Http\Controllers\Staff_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Staff_Area\CRUDContoller;
use App\User as User;
use App\AdminSession;
use App\Session;
use App\Department;
use App\Rules\AdminSessionSelection;

/*
|-----------------------------------------------------------------------------------
| Change Admin Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible for managing updating and deleting of Admin records
|
*/
class ChangeAdminController extends CRUDController
{
  //path of the view for create operations
  protected $createView;
  //path of the view for update operations
  protected $updateView='staff_area/admins/update';
  //path of the view for delete operations
  protected $deleteView='staff_area/admins/delete';    
  //path of the view for redirections after CRUD operations
  protected $redirectView='/staff_area/admin';
  //primary key attribute name
  protected $primaryKey = 'id';

  /**
   * Create a new controller instance and adds its respective middleware
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(['auth', 'admin']);
  }

  /**
   * returns view for browsing a list of existing admins
   *
   * @param Request $request
   * @return view
   */
  public function adminBrowse(Request $request)
  {
    return view('staff_area/admins/admin_browse')
    ->with('tableData',$this->getFilteredAdminList($request))
    ->with('filterFormData',$this->getDataFilterFormPrePopulate($request))->with('roles', User::select('role')->distinct()->get());
  }

  /**
   * get data filter form prepopulation data for page reloads
   * in the form of an associative array
   *
   * @param Request $request
   * @return array
   */
  private function getDataFilterFormPrePopulate($request)
  {
    $formFilterSelections = array("admin_name"=>"","admin_privilege"=>"");
    if($request->isMethod('post'))
    { 
      $formFilterSelections['admin_name'] = $request->input('admin_name');
      $formFilterSelections['admin_privilege'] = $request->input('admin_privilege');
    }

    return $formFilterSelections;
  }

  /**
   * Get filtered admin list according to search query
   *
   * @param Request $filterRequest
   * @return collection of User Objects
   */
  private function getFilteredAdminList($filterRequest)
  {
    $admins = $this->getUserList();

    if($filterRequest->input('admin_name') != "")
    {
      $admins->where('name', 'like', '%' . $filterRequest->input('admin_name') . '%');

    }
    if($filterRequest->input('admin_privilege') != "")
    {
      $admins->where('role',$filterRequest->input('admin_privilege'));
    }

    return $admins->get();
  }

  /**
   * Get collection of user objects who are admins
   *
   * @return collection of User Objects
   */
  private function getUserList()
  {
    return $this->getModel()->getUserList();
  }

  /**
   * Create an instance of the User model and returns it
   *
   * @return User
   */
  protected function getModel()
  {
    return new User;
  }

  /**
   * Create an instance of the AdminSessions model and returns it
   *
   * @return AdminSession
   */
  protected function getAdminSessionModel()
  {
    return new AdminSession;
  }

  /**
   * validates form data upon submission
   * @param Request $request
   */
  protected function validateForm($request)
  {
    $request->validate(['role' => ['required', new AdminSessionSelection($request)],]);
  }

  /**
   * Override
   * Executes CREATE operations for a model/table in database
   * @param Request $request
   */ 
  protected function createEntry($request){}

  /**
   * Override
   * Executes Update operations for a user in database
   * takes the primary key of the user data on which the operation is to be done
   * @param Request $request int $id
   * @return void
   */ 
  protected function updateEntry($request, $id)
  {

    if($request->input('role') == "manager")
      {
        $this->getModel()->find($id)->update(['name' => $request->input('name'),'email' => $request->input('email'),'days_working' => null,'user_department' => null,'holiday_entitlement' => null,'role' => $request->input('role')]); 
      }
    else
    {
      $entitlement = 0;
          if($request->input('days_per_week') >=5)
          {
            $entitlement = 28;
          }
          else
          {
            $entitlement =  (int) round($request->input('days_per_week') * 5.6, 0);
          }
        $this->getModel()->find($id)->update(['name' => $request->input('name'),'email' => $request->input('email'),'user_department' => $request->input('department_choice'),'days_working' => $request->input('days_per_week'),'holiday_entitlement' => $entitlement,'role' => $request->input('role')]); 

    }
  }


  /**
   * Override
   * Takes primary key of the model and adds data to pass into the views for the GET request
   * @return void
   * @param int $id
   */
  protected function handleUpdateGetRequest($id)
  {
    $this->data['entry']=$this->getModel()->find($id);        
    $this->data['departments']=Department::all();  

  }



}
