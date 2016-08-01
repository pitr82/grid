<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Ublaboo\DataGrid\DataGrid;


class HomepagePresenter extends BasePresenter
{

    public function startup()
    {
	parent::startup();
	$this->redrawControl('css');
	$this->redrawControl('js');
    }

    public function renderDefault()
	{
	}
	
	public function createComponentDataGrid($name)
	{
	    $grid = new DataGrid($this, $name);
	    $grid->setDataSource([['id' => 1, 'name' => 'John'], ['id' => 2, 'name' => 'Joe']]);
	    $grid->addColumnText('id', 'Id');
	    $grid->addColumnText('name', 'Name');
	    $grid->addInlineEdit()
		->onControlAdd[] = function($container) {
		$container->addText('id', '');
		$container->addmultiSelect('name', '',['foo', 'bar'])
			->setAttribute('class', 'selectpicker');
	    };

	    $grid->getInlineEdit()->onSetDefaults[] = function($container, $item) {
		$container->setDefaults([
		'id' => $item['id']]);
	    };
	    
	    $grid->setItemsDetail();
	    $grid->setTemplateFile(__DIR__ . '/itemsDetail.latte');
	    $grid->setItemsDetailForm(function(Nette\Forms\Container $container) {
		    $container->addText('id');
		    $container->addMultiSelect('name', '', ['foo', 'bar']);
		    $container->addSubmit('save', 'Save')
			    ->onClick[] = function($button) {};
	    });
	    return $grid;
	}

}
