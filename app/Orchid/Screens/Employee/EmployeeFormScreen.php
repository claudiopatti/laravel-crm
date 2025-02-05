<?php

namespace App\Orchid\Screens\Employee;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Orchid\Attachment\Models\Attachment;
use Orchid\Support\Color;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EmployeeFormScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'EmployeeFormScreen';
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
                    Input::make('name')
                        ->type('text')
                        ->title('Name')
                        ->value('')
                        ->placeholder('Employee name...')
                        ->help('Enter employee\'s first name.')
                        ->vertical(),

                    Input::make('surname')
                        ->type('text')
                        ->title('Surname')
                        ->value('')
                        ->placeholder('enter surname...')
                        ->help('Enter employee\'s last name.')
                        ->vertical(),
                ]),
                Group::make([
                    Select::make('company_you_belong_to')
                        ->title('Select a company')
                        ->help('Select the company where the employee will work.')
                        ->class('form-select bg-light')
                        ->fromModel(Company::class, 'name')
                        ->empty('Select a company')
                        ->vertical(),

                    Input::make('phone')
                        ->type('number')
                        ->title('Phone Number')
                        ->value('')
                        ->placeholder('enter employee\'s phone number...')
                        ->help('Enter phone number.')
                        ->vertical(),
                ]),

                Group::make([
                    Input::make('email')
                        ->type('email')
                        ->title('Email')
                        ->value('')
                        ->placeholder('enter employee\'s email...')
                        ->help('Enter employee\'s email.')
                        ->vertical(),

                    Button::make('Submit')
                        ->class('btn btn-outline-dark')
                        ->method('saveEmployee')
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
    public function saveEmployee(Request $request)
    {
        // Valida i dati
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'company_you_belong_to' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
        ]);

        $company = Company::find($validated['company_you_belong_to']);
        $companyName = $company ? $company->name : 'N/A';

        // Salva i dati nel database
        Employee::create([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'company_you_belong_to' => $companyName,
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'company_id' => $validated['company_you_belong_to'],
        ]);

        // Mostra un messaggio di successo
        Toast::info('Company created successfully!');
    }
}
