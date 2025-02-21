<?php

namespace App\Orchid\Screens\Employee;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EmployeeEditScreen extends Screen
{
    public ?Employee $employee = null;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Employee $employee): iterable
    {
        $this->employee = $employee; // definisce la variabile $employee
        return [
            'singleEmployee' => $employee,
            'companyEmployee' => Company::find($employee->company_id),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Edit ' . $this->employee->name;
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Group::make([
                    Input::make('singleEmployee.name')
                        ->type('text')
                        ->title('Name')
                        ->value('')
                        ->placeholder('Employee name...')
                        ->help('Enter employee\'s first name.')
                        ->vertical(),

                    Input::make('singleEmployee.surname')
                        ->type('text')
                        ->title('Surname')
                        ->value('')
                        ->placeholder('enter surname...')
                        ->help('Enter employee\'s last name.')
                        ->vertical(),
                ]),
                Group::make([
                    Select::make('companyEmployee')
                        ->title('Select a company')
                        ->help('Select the company where the employee will work.')
                        ->class('form-select bg-light')
                        // ->value('companyEmployee')
                        ->fromModel(Company::class, 'name')
                        ->empty('Select a company')
                        ->vertical(),

                    Input::make('singleEmployee.phone')
                        ->type('text')
                        ->title('Phone Number')
                        ->value('')
                        ->placeholder('enter employee\'s phone number...')
                        ->help('Enter phone number.')
                        ->vertical(),
                ]),

                Group::make([
                    Input::make('singleEmployee.email')
                        ->type('email')
                        ->title('Email')
                        ->value('')
                        ->placeholder('enter employee\'s email...')
                        ->help('Enter employee\'s email.')
                        ->vertical(),

                    Button::make('Submit')
                        ->class('btn btn-outline-dark')
                        ->method('saveSingleEmployee')
                        ->type(Color::PRIMARY)
                        ->vertical(),
                ])

            ]),
        ];
    }

     /**
     * Salva i dati del form.
     *
     * @param Request $request
     */

     public function saveSingleEmployee(Request $request, Employee $employee)
     {
         $validated = $request->validate([
            'singleEmployee.name' => 'required|string|max:255',
            'singleEmployee.surname' => 'required|string|max:255',
            'companyEmployee' => 'required|string',
            'singleEmployee.phone' => 'required|string',
            'singleEmployee.email' => 'required|email',
         ]);
         // $validated = $request->all();
         // Salva i dati
         //  dd($request->all());

        $company = Company::find($validated['companyEmployee']);
        $companyName = $company ? $company->name : 'N/A';
 
         // Aggiorna i dati
         $employee->fill([
            'name' => $validated['singleEmployee']['name'] ?? $employee->name,
            'surname' => $validated['singleEmployee']['surname'] ?? $employee->surname,
            'company_you_belong_to' => $companyName,
            'phone' => $validated['singleEmployee']['phone'] ?? $employee->phone,
            'email' => $validated['singleEmployee']['email'] ?? $employee->email,
            'company_id' => $validated['companyEmployee'],
         ]);
 
         $employee->save();
         // Redirect
         Toast::info('Employee saved successfully!');
         return redirect()->route('platform.employee.table');
         //
 
         // Informa del successo
     }
 
}
