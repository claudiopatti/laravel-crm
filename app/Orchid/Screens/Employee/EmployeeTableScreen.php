<?php

namespace App\Orchid\Screens\Employee;

use App\Models\Employee;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EmployeeTableScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'employees' => Employee::all()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'EmployeeTableScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add an Employee')
            ->class('btn btn-primary')
            ->route('platform.employee.form')
            ->novalidate()
            ->icon('bs.plus'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('employees',  [
                TD::make('id', 'ID'),

                TD::make('name', 'Name'),

                TD::make('surname', 'Surname'),

                TD::make('company_you_belong_to', 'Company'),

                TD::make('phone', 'Phone'),

                TD::make('email', 'Email'),

                // TD::make('created_at', 'Created at'),

                TD::make('', 'Actions')->render(function (Employee $employee) {
                    return Group::make([
                        Button::make('Delete')
                            ->icon('bs.trash')
                            ->class('btn btn-danger')
                            ->parameters(['id' => $employee->id])
                            ->method('deleteEmployee'),

                            Link::make('Edit')
                            ->icon('bs.pencil')
                            ->class('btn btn-warning')
                            ->route('platform.employee.edit', [$employee->id]),
                    ]);
                }),

                // TD::make('actions', 'Actions')
                // ->render(function (Employee $employee) {
                //     return Button::make('Delete')
                //         ->type(Color::DANGER)
                //         ->icon('bs.trash')
                //         ->method('deleteEmployee')
                //         ->parameters(['id' => $employee->id]);
                // }),


            ]),
        ];
    }
/**
     * Salva i dati del form.
     *
     * @param Request $request
     */
    public function deleteEmployee(Request $request)
    {
        // Employee::deleted([]);
        // Toast::info('Employee deleted successfully!');

        // Recupera l'ID del prodotto
        $employeeId = $request->input('id');

        // Trova e cancella il prodotto
        $employee = Employee::find($employeeId);
        if ($employee) {
            $employee->delete();
            Toast::info('Employee deleted successfully!');
        } else {
            Toast::error('Employee not found!');
        }
    }
}
