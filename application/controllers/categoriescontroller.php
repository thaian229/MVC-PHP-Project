<?php

class CategoriesController extends VanillaController {
	
	function beforeAction () {

	}

	function view($categoryId = null) {
		$this->model->where('parent_id',$categoryId);
		$this->model->showHasOne();
		$this->model->showHasMany();
		$subcategories = $this->model->search();
		
		$this->model->id = $categoryId;
		$this->model->showHasOne();
		$this->model->showHasMany();
		$category = $this->model->search();
	
		$this->set('subcategories',$subcategories);
		$this->set('category',$category);

	}
	
	
	function index() {
		$this->model->orderBy('name','ASC');
		$this->model->showHasOne();
		$this->model->showHasMany();
		$this->model->where('parent_id','0');
		$categories = $this->model->search();
		$this->set('categories',$categories);
	
	}

	function afterAction() {

	}


}