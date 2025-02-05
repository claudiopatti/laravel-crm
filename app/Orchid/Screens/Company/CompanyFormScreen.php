<?php

namespace App\Orchid\Screens\Company;

// use App\Orchid\Layouts\Examples\ExampleElements;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Fields\Radio;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;

use Orchid\Attachment\Models\Attachment;

// model
use App\Models\Company;
use Orchid\Screen\Fields\Upload;

class CompanyFormScreen extends Screen
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
        return 'CompanyFormScreen';
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
            // ExampleElements::class,
            Layout::rows([
                Input::make('name')
                    ->title('Name')
                    ->value('John Doe')
                    ->placeholder('Enter your name')
                    ->help('Enter your full name.'),

                Input::make('vat_number')
                    ->type('number')
                    ->title('Vat number')
                    ->value('')
                    ->placeholder('Insert vat number'),

                // Input::make('logo')
                //     ->type('file')
                //     ->title('Upload logo')
                //     ->acceptedFiles('.pdf,.jpg,.png') // Specifica i tipi di file consentiti
                //     ->maxFiles(1), // Numero massimo di file
                    // ->title('Logo')
                    // ->value('')
                    // ->placeholder('Insert logo'),

                    Upload::make('logo')
                        ->title('Upload logo')
                        ->acceptedFiles('.jpg,.png') // Accetta solo immagini
                        ->maxFiles(1)
                        ->storage('public') // Salva nello storage pubblico
                        ->targetId(), // Necessario per gestire gli allegati di Orchid

                // Group::make([
                //     Input::make('email')
                //         ->type('email')
                //         ->title('Email')
                //         ->value('bootstrap@example.com')
                //         ->placeholder('example@example.com')
                //         ->help('Enter your email address.')
                //         ->horizontal(),

                //     Input::make('website')
                //         ->type('url')
                //         ->title('Website')
                //         ->value('https://orchid.software')
                //         ->placeholder('https://example.com')
                //         ->help('Enter your website URL.')
                //         ->horizontal(),
                // ]),

                // Group::make([
                //     Input::make('phone')
                //         ->type('tel')
                //         ->title('Phone')
                //         ->value('1-(555)-555-5555')
                //         ->placeholder('Enter phone number')
                //         ->horizontal()
                //         ->popover('The device’s autocomplete mechanisms kick in and suggest
                //         phone numbers that can be autofilled with a single tap.')
                //         ->help('Enter your phone number.'),

                //     Input::make('password')
                //         ->type('password')
                //         ->title('Password')
                //         ->value('Password')
                //         ->placeholder('Enter password')
                //         ->horizontal(),
                // ]),

                // Group::make([
                //     Input::make('quantity')
                //         ->type('number')
                //         ->title('Quantity')
                //         ->value(42)
                //         ->placeholder('Enter quantity')
                //         ->horizontal(),

                //     Input::make('appointment_datetime')
                //         ->type('datetime-local')
                //         ->title('Appointment Date and Time')
                //         ->value('2011-08-19T13:45:00')
                //         ->placeholder('YYYY-MM-DDTHH:MM')
                //         ->horizontal(),
                // ]),

                // Group::make([
                //     Input::make('event_date')
                //         ->type('date')
                //         ->title('Event Date')
                //         ->value('2011-08-19')
                //         ->placeholder('YYYY-MM-DD')
                //         ->horizontal(),

                //     Input::make('event_month')
                //         ->type('month')
                //         ->title('Event Month')
                //         ->value('2011-08')
                //         ->placeholder('YYYY-MM')
                //         ->horizontal(),
                // ]),

                // Group::make([
                //     Input::make('week_number')
                //         ->type('week')
                //         ->title('Week Number')
                //         ->value('2011-W33')
                //         ->placeholder('YYYY-W##')
                //         ->horizontal(),

                //     Input::make('event_time')
                //         ->type('time')
                //         ->title('Event Time')
                //         ->value('13:45:00')
                //         ->placeholder('HH:MM:SS')
                //         ->horizontal(),
                // ]),

                // Group::make([
                //     Input::make('city')
                //         ->title('City')
                //         ->help('Select a city from the list.')
                //         ->datalist([
                //             'San Francisco',
                //             'New York',
                //             'Seattle',
                //             'Los Angeles',
                //             'Chicago',
                //         ])
                //         ->horizontal(),

                //     Input::make('color_picker')
                //         ->type('color')
                //         ->title('Color Picker')
                //         ->value('#563d7c')
                //         ->horizontal(),
                // ]),

                Button::make('Submit')
                    ->method('saveCompany')
                    ->type(Color::BASIC),
            ]),
        ];
    }

    /**
     * Salva i dati del form.
     *
     * @param Request $request
     */
    public function saveCompany(Request $request)
    {
        // Valida i dati
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'vat_number' => 'required|string|max:11',
            'logo' => 'required|array',
            // 'company.logo' => 'nullable|url',
        ]);

        // Recupera l'ID del file caricato
        $logoId = $validated['logo'][0] ?? null;

        // Trova il file nel database usando Orchid Attachment
        $logoPath = null;
        if ($logoId) {
            $attachment = Attachment::find($logoId);
            if ($attachment) {
                $logoPath = $attachment->url(); // Ottieni il link al file
            }
        }

        // $logoRelativePath = str_replace(asset('storage') . '/', '', $logoPath);

        // Salva i dati nel database
        Company::create([
            'name' => $validated['name'],
            'vat_number' => $validated['vat_number'],
            'logo' => $logoPath,
        ]);

        // Mostra un messaggio di successo
        Toast::info('Company created successfully!');
    }
}
