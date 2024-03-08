<?php

namespace frontend\modules\hr\models;



abstract class Report
{
   

    public $model;

    public $default_name = '';

    public $category = 'reports.payroll';
    
    public $views = [];

    public $tables = [];

    public $row_values = [];

    public $footer_totals = [];
   
    public $loaded = false;

  

    public function __construct(Model $model = null, $load_data = true)
    {
       

        if (!$model) {
            return;
        }

        $this->model = $model;

        if (!$load_data) {
            return;
        }

        $this->load();
    }

    abstract public function setData();

    public function load()
    {
        
        $this->setViews();
        $this->setTables();
       
        $this->setRows();
        $this->loadData();
       

        $this->loaded = true;
    }

    public function loadData()
    {
       

        $this->setData();

      
    }

    public function getDefaultName()
    {
        if (!empty($this->default_name)) {
            return $this->default_name;
        }

        return Str::title(str_replace('_', ' ', Str::snake((new \ReflectionClass($this))->getShortName())));
    }

    public function getCategory()
    {
        return $this->category;
    }

  

    public function show()
    {
        return view($this->views['show'])->with('class', $this);
    }


    public function setViews()
    {
        $this->views = [
           
            'content' => 'partials.reports.content',
            'content.header' => 'partials.reports.content.header',
            'content.footer' => 'partials.reports.content.footer',
            'show' => 'partials.reports.show',
            'header' => 'partials.reports.header',
            'table' => 'partials.reports.table',
            'table.footer' => 'partials.reports.table.footer',
            'table.header' => 'partials.reports.table.header',
            'table.rows' => 'partials.reports.table.rows',
        ];
    }

    public function setTables()
    {
        $this->tables = [
            'default' => 'default',
        ];
    }



    
}
