<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Deal;
use App\Models\DealImage;
use Livewire\WithFileUploads;

class CreateDeal extends Component
{
    use WithFileUploads;

    public $title, $description, $referral_url, $price, $discounted_price, $airline;
    public $departure_city, $departure_country, $arrival_city, $arrival_country;
    public $departure_date, $return_date;
    public $tags = [];
    public $images = [];

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

    // SLIMME DATABASE VOOR AANKOMST (Cascading: Land -> Steden)
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

    // DEZE FUNCTIE DRAAIT AUTOMATISCH ALS JE EEN VELDJE AANPAST
    public function updated($propertyName)
    {
        // Als je een vertrek luchthaven kiest, vul automatisch het land in!
        if ($propertyName === 'departure_city') {
            if (array_key_exists($this->departure_city, $this->vertrekLocaties)) {
                $this->departure_country = $this->vertrekLocaties[$this->departure_city];
            }
        }

        // Als je een aankomstland verandert, wis de oude stad (want die klopt niet meer)
        if ($propertyName === 'arrival_country') {
            $this->arrival_city = null;
        }
    }

    public function saveDeal()
    {
        $this->validate();

        $deal = Deal::create([
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
            'is_active' => true,
            'user_id' => auth()->id()
        ]);

        if (!empty($this->images)) {
            foreach ($this->images as $index => $photo) {
                $path = $photo->store('deals', 'public');

                DealImage::create([
                    'deal_id' => $deal->id,
                    'path' => $path,
                    'is_primary' => $index === 0 ? true : false,
                ]);
            }
        }

        session()->flash('message', 'Deal succesvol aangemaakt! ✈️');

        return redirect()->route('admin.deals');
    }

    public function render()
    {
        return view('livewire.admin.create-deal')->layout('layouts.app');
    }
}
