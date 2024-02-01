<?php
namespace SuperBadCN\CustomConfig\Http\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use SuperBadCN\CustomConfig\Models\CustomConfig;
use SuperBadCN\CustomConfig\CustomConfigsServiceProvider as Provider;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class CustomConfigController extends AdminController
{
    /**
     * Get title.
     *
     * @return string
     */
    protected function title()
    {
        return Provider::trans('custom-config.main-title');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CustomConfig(), function (Grid $grid) {
            $grid->paginate(30);
            $grid->column('title', Provider::trans('custom-config.title'));
            $grid->column('key', Provider::trans('custom-config.key'));
            $grid->column('type', Provider::trans('custom-config.type'))->using(CustomConfig::type())->badge();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->like('title', Provider::trans('custom-config.title'))->width(3);
                $filter->like('key', Provider::trans('custom-config.key'))->width(3);
                $filter->between('created_at')->datetime()->width(3);
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(CustomConfig::with('items'), function (Form $form) {
            $form->text('title', Provider::trans('custom-config.title'));
            $form->text('key', Provider::trans('custom-config.key'))->help(Provider::trans('custom-config.key-tip'))->required();
            $form->radio('type')
                ->options(CustomConfig::type())
                ->default(1)
                ->when(1, function (Form $form) {
                    $form->textarea('value1', Provider::trans('custom-config.value'));
                })->when(2, function (Form $form) {
                    $form->editor('value2', Provider::trans('custom-config.value'))->imageDirectory('images/' . date("Y/m"))->height('600');
                })->when(3, function (Form $form) {
                    $form->image('value3', Provider::trans('custom-config.value'))->move('images/' . date("Y/m"))->autoUpload()->uniqueName();
                })->when(4, function (Form $form) {
                    $form->multipleImage('value4', Provider::trans('custom-config.value'))->move('images/' . date("Y/m"))->autoUpload()->uniqueName()->limit(1000);
                })->when(5, function (Form $form) {
                    $form->file('value5', Provider::trans('custom-config.value'))->move('images/' . date("Y/m"))->autoUpload()->uniqueName();
                })->when(6, function (Form $form) {
                    $form->multipleFile('value6', Provider::trans('custom-config.value'))->move('images/' . date("Y/m"))->autoUpload()->uniqueName()->limit(1000);
                })->when(7, function (Form $form) {
                    $form->date('value7', Provider::trans('custom-config.value'));
                })->when(8, function (Form $form) {
                    $form->datetime('value8', Provider::trans('custom-config.value'));
                })->when(9, function (Form $form) {
                    $form->switch('value9');
                })->when(10, function (Form $form) {
                    $form->hasMany('items', Provider::trans('custom-config.value'), function (Form\NestedForm $form) {
                        $form->textarea('value', Provider::trans('custom-config.value'));
                    });
                })->when(11, function (Form $form) {
                    $form->hasMany('items', Provider::trans('custom-config.value'), function (Form\NestedForm $form) {
                        $form->textarea('value', Provider::trans('custom-config.value'));
                    });
                });
            $form->saved(function (Form $form) {
                // TODO:移除其他type的value值
                $type = $form->model()->type;
            });

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
