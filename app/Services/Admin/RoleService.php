<?php

namespace App\Services\Admin;

use App\Services\Service;
use App\Models\Role;
use App\ViewModels\Admin\TagViewModel;

class RoleService extends Service
{
    public $viewModel;

    public function __construct(TagViewModel $viewModel)
    {
        $this->viewModel = $viewModel;
    }

    /**
     *  Gets all the model that are shown in the module index page. 
     *  @param string $moduleName
     */
    public function GetIndexModel($module)
    {
        // dd($module);
        $tags = Role::all();

        if($tags == null)
        {  
            //TODO: Return a message telling the user the module name was incorrect.
            //TODO: Log the module enter
            return false;
        }

        $this->viewModel->model = $tags;

        if($this->viewModel->model == null)
        {
            //TODO: Return a message that no model where found?
            $this->viewModel->model = Collect([]);
        }

       return $this->SetViewModelProperties($module);
    }

    /**
     * Sets the view model based on the model to be updated.
     * @param int $modelId
     * @param string $moduleName
     */
    public function GetEditModel($id, $module)
    {
        $tag = Role::find($id);

        if($tag == null)
        {
            $this->viewModel->success = false;
            $this->viewModel->error = "The model was not found in the records.";
        }

        $this->viewModel->model = $tag;

        return $this->SetViewModelProperties($module);
    }

    public function GetCreateModel($module)
    {
        $tag = Role::create(['name' => '*** Enter Name ***']);

        return $this->SetViewModelProperties($module);
    }
    
    /**
     *  Create new model if does not exist in the database or update the model the model if exists in the database. 
     *  @param int $modelId
     *  @param string $moduleName
     */
    public function SaveModel($request, $module)
    {
        try
        {
            if($request['id'] == null)
            {
                $tagToSave = new Role();
            }
            else
            {
                $tagToSave = Role::find($request['id']);
            }

            $tagToSave->name = $request['name'];
            $tagToSave->active = $request['active'] == "on" ? true : false ;
            $tagToSave->save();
        }
        catch(\Exception $ex)
        {
            $this->ProccessException($ex);
        }
        finally
        {
            return $this->SetViewModelProperties($module);
        }
    }
    
    /**
     *  Deletes the model from the databse. 
     *  @param int $modelId
     *  @param string $moduleName
     */
    public function DeleteModel($id, $module)
    {
        try
        {
            $entry = Role::find($id);
            $entry->delete();
        }
        catch(\Exception $ex)
        {
            $this->ProccessException($ex);
        }
        finally
        {
            $this->SetViewModelProperties($module);
            return $this->viewModel;
        }
    }

    // **********************************************
    // ************ PRIVATE METHODS *****************
    // **********************************************
    
    /**
     *  Sets the exception message to the is succces and error message properties of the view model. 
     */
    private function ProccessException($ex)
    {
        $this->viewModel->success = false;
        $this->viewModel->error = $ex;
    }
    
    /**
     * Sets the view model properties that will be shown in the UI.
     */
    private function SetViewModelProperties($module)
    {
        $this->viewModel->viewTitle = "$module Management";
        $this->viewModel->viewModule = strtolower($module);
        return $this->viewModel;
    }
}
