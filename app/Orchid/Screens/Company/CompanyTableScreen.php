<?php

namespace App\Orchid\Screens\Company;

use Orchid\Screen\Screen;
use Orchid\Screen\Layout\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Color;
use Orchid\Screen\Fields\Picture;


// models
use App\Models\Company;
use App\Models\Employee;

class CompanyTableScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {

        return [
            'companies' => Company::get(),
            // 'employee' => Employee::all()

        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Company';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Company list';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add New Company')
                // ->method('showToast')
                ->novalidate()
                ->icon('bs.plus')
                ->type(Color::SUCCESS)
                ->route('platform.company.form'),

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
            Layout::table('companies', [
                TD::make('id', 'ID'),
                    // ->width('100')
                    // ->render(fn (Company $model) => // Please use view('path')
                    // "<img src='https://loremflickr.com/500/300?random={$model->get('id')}'
                    //           alt='sample'
                    //           class='mw-100 d-block img-fluid rounded-1 w-100'>
                    //         <span class='small text-muted mt-1 mb-0'># {$model->get('id')}</span>"),

                TD::make('name', 'Name'),
                    // ->width('450')
                    // ->render(fn (Repository $model) => Str::limit($model->get('name'), 200)),

                TD::make('vat_number', 'Vat number'),
                    // ->width('100')
                    // ->usingComponent(Currency::class, before: '$')
                    // ->align(TD::ALIGN_RIGHT),

                    // TD::make('logo', 'Logo')
                    // ->render(fn (Company $company) => 
                    //     "<img src='" . asset($company->logo) . "'
                    //           alt='Company Logo'
                    //           class='mw-100 d-block img-fluid rounded-1 w-100' style='max-width: 100px;'>"),
                
                TD::make('logo', 'Logo')
                    ->width('250')
                    ->render(fn (Company $model) => // Please use view('path')
                    "<img src='" . asset($model->logo) . "'
                              alt='sample'
                              class='mw-100 d-block img-fluid rounded-1 w-100'>"),
                            // <span class='small text-muted mt-1 mb-0'># {$model->get('id')}</span>")

                TD::make('employees', 'Employees')
                    ->render(function (Company $model) {
                        // Recupera e concatena i nomi degli impiegati
                        return $model->employees->map(function ($employee) {
                            return $employee->name . ' ' . $employee->surname; // Concatenate name and surname
                        })->implode(', ');
                    }),

                TD::make('created_at', 'Created')
                    ->width('100')
                    ->usingComponent(DateTimeSplit::class)
                    ->align(TD::ALIGN_RIGHT),
            ]),
        ];
    }
}
