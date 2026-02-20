<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Deal;
use App\Models\DealImage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditDeal extends Component
{
    use WithFileUploads;

    public $deal; // Het huidige Deal model
    public $deal_id;

    // Formulier velden
    public $title, $description, $referral_url, $price, $discounted_price, $airline;
    public $departure_city, $departure_country, $arrival_city, $arrival_country;
    public $departure_date, $return_date;
    public $tags = [];

    // Foto variabelen
    public $existing_images = [];
    public $new_images = [];

    // SLIMME DATABASE VOOR VERTREK
    public $vertrekLocaties = [
        'Amsterdam (Schiphol)' => 'Nederland',
        'Eindhoven' => 'Nederland',
        'Rotterdam / Den Haag' => 'Nederland',
        'Brussel (Zaventem)' => 'België',
        'Brussel (Charleroi)' => 'België',
        'Düsseldorf (Intl)' => 'Duitsland',
        'Düsseldorf (Weeze)' => 'Duitsland',
    ];

    // SLIMME DATABASE VOOR AANKOMST
    public $beschikbareLanden = [
        'Spanje' => ['Barcelona', 'Madrid', 'Valencia', 'Ibiza', 'Mallorca', 'Malaga', 'Tenerife', 'Gran Canaria'],
        'Italië' => ['Rome', 'Milaan', 'Venetië', 'Napels', 'Sicilië', 'Florence'],
        'Griekenland' => ['Athene', 'Kreta', 'Santorini', 'Rhodos', 'Kos', 'Zakynthos'],
        'Turkije' => ['Istanbul', 'Antalya', 'Bodrum', 'Alanya'],
        'Frankrijk' => ['Parijs', 'Nice', 'Lyon', 'Marseille'],
        'Portugal' => ['Lissabon', 'Porto', 'Faro (Algarve)', 'Madeira'],
        'Verenigd Koninkrijk' => ['Londen', 'Edinburgh', 'Manchester'],
        'Indonesië' => ['Bali', 'Jakarta'],
        'Verenigde Staten' => ['New York', 'Los Angeles', 'Miami', 'Las Vegas'],
        'Thailand' => ['Bangkok', 'Phuket', 'Chiang Mai']
    ];

protected $rules = [
        'title' => 'required|min:3',
        'price' => 'required|numeric',
        'discounted_price' => 'nullable|numeric',
        'referral_url' => 'required|url',

        // HIER ZIJN DE NIEUWE REGELS:
        'images' => 'max:10',             // Maximaal 10 foto's in totaal selecteren
        'images.*' => 'image|max:71680',  // Maximaal 70MB (71680 KB) per stuk!
    ];
    public function mount(Deal $deal)
    {
        $this->deal = $deal;
        $this->deal_id = $deal->id;

        // Vul alle velden met de bestaande data
        $this->title = $deal->title;
        $this->description = $deal->description;
        $this->price = $deal->price;
        $this->discounted_price = $deal->discounted_price;
        $this->referral_url = $deal->referral_url;
        $this->airline = $deal->airline;

        $this->departure_city = $deal->departure_city;
        $this->departure_country = $deal->departure_country;
        $this->arrival_city = $deal->arrival_city;
        $this->arrival_country = $deal->arrival_country;

        $this->departure_date = $deal->departure_date ? \Carbon\Carbon::parse($deal->departure_date)->format('Y-m-d') : null;
        $this->return_date = $deal->return_date ? \Carbon\Carbon::parse($deal->return_date)->format('Y-m-d') : null;

        // Let op: tags is een JSON veld, we zorgen dat het als array in het formulier komt
        $this->tags = $deal->tags ?? [];

        // Haal bestaande foto's op
        $this->existing_images = $deal->images;
    }

    // AUTOMATISCHE INVULLING BIJ WIJZIGING
    public function updated($propertyName)
    {
        if ($propertyName === 'departure_city') {
            if (array_key_exists($this->departure_city, $this->vertrekLocaties)) {
                $this->departure_country = $this->vertrekLocaties[$this->departure_city];
            }
        }

        if ($propertyName === 'arrival_country') {
            $this->arrival_city = null;
        }
    }

    public function removeExistingImage($imageId)
    {
        $image = DealImage::findOrFail($imageId);
        Storage::disk('public')->delete($image->path);
        $image->delete();

        // Ververs de lijst met bestaande foto's
        $this->existing_images = DealImage::where('deal_id', $this->deal_id)->get();
    }

    public function updateDeal()
    {
        $this->validate();

        // 1. Update de deal
        $this->deal->update([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'discounted_price' => $this->discounted_price ?: null,
            'referral_url' => $this->referral_url,
            'airline' => $this->airline,

            'departure_city' => $this->departure_city,
            'departure_country' => $this->departure_country,
            'arrival_city' => $this->arrival_city,
            'arrival_country' => $this->arrival_country,

            'departure_date' => $this->departure_date ?: null,
            'return_date' => $this->return_date ?: null,
            'tags' => $this->tags,
        ]);

        // 2. Sla nieuwe foto's op (als die er zijn)
        if (!empty($this->new_images)) {
            $heeftAlHoofdfoto = $this->existing_images->where('is_primary', true)->count() > 0;

            foreach ($this->new_images as $index => $photo) {
                $path = $photo->store('deals', 'public');

                $isHoofdfoto = false;
                if (!$heeftAlHoofdfoto && $index === 0) {
                    $isHoofdfoto = true;
                    $heeftAlHoofdfoto = true;
                }

                DealImage::create([
                    'deal_id' => $this->deal->id,
                    'path' => $path,
                    'is_primary' => $isHoofdfoto,
                ]);
            }
        }

        session()->flash('message', 'Deal succesvol bijgewerkt! ✏️');
        return redirect()->route('admin.deals');
    }

    public function render()
    {
        return view('livewire.admin.edit-deal')->layout('layouts.app');
    }
}
