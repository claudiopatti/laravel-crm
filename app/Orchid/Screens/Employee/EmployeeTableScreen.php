<?php

namespace App\Orchid\Screens\Employee;

use App\Models\Employee;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

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

            ]),
        ];
    }
}
