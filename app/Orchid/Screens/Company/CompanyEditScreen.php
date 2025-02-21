<?php

namespace App\Orchid\Screens\Company;

use App\Models\Company;
use Illuminate\Http\Request;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CompanyEditScreen extends Screen
{
    public ?Company $company = null;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Company $company): iterable
    {
        $this->company = $company; // definisce la variabile $company
        return [
            'singleCompany' => $company
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Edit ' . $this->company->name;
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
                Input::make('singleCompany.name')
                    ->title('Name')
                    ->value('')
                    ->placeholder('Enter your name')
                    ->help('Enter your full name.'),

                Input::make('singleCompany.vat_number')
                    // ->type('number')
                    ->title('Vat number')
                    ->value('')
                    ->placeholder('Insert vat number'),

                    Upload::make('logo')
                        ->title('Uploads logo')
                        ->acceptedFiles('.jpg,.png') // Accetta solo immagini
                        ->maxFiles(1)
                        ->storage('public') // Salva nello storage pubblico
                        ->targetId(), // Necessario per gestire gli allegati di Orchid

                Button::make('Submit')
                    ->method('saveSingleCompany')
                    ->type(Color::BASIC),
            ]),
        ];
    }

     /**
     * Salva i dati del form.
     *
     * @param Request $request
     */

    public function saveSingleCompany(Request $request, Company $company)
    {
        $validated = $request->validate([
            'singleCompany.name' => 'nullable|min:3|max:30',
            'singleCompany.vat_number' => 'nullable',
            'logo' => 'nullable|array',
        ]);
        // $validated = $request->all();
        // Salva i dati
        $logoIdEdit = $validated['logo'][0] ?? null;

        $logoPathEdit = null;
        if ($logoIdEdit) {
            $company->logo = '';
            $attachment = Attachment::find($logoIdEdit);
            if ($attachment) {
                # code...
                $logoPathEdit = $attachment->url();
                // $validated['logo'] = $logoPathEdit;
            }
        };
        //  dd($request->all());

        // Aggiorna i dati
        $company->fill([
            'name' => $validated['singleCompany']['name'] ?? $company->name,
            'vat_number' => $validated['singleCompany']['vat_number'] ?? $company->vat_number,
            'logo' => $logoPathEdit ?? $company->logo,
        ]);

        $company->save();
        // Redirect
        Toast::info('Company saved successfully!');
        return redirect()->route('platform.index');
        //

        // Informa del successo
    }

}
