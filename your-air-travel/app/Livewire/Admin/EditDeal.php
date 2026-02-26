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

    // Voor de archiveer knop
    public $is_active;

    // Formulier velden (return_date is hier verwijderd)
    public $title, $description, $referral_url, $price, $discounted_price, $airline;
    public $departure_city, $departure_country, $arrival_city, $arrival_country, $arrival_continent;
    public $departure_date;

    // De reisduur
    public $duration_days;

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
        // --- EUROPA ---
        'Spanje' => ['Barcelona', 'Madrid', 'Valencia', 'Ibiza', 'Mallorca', 'Malaga', 'Canarische Eilanden', 'Sevilla', 'Alicante', 'Girona'],
        'Italië' => ['Rome', 'Milaan', 'Venetië', 'Napels', 'Sicilië', 'Sardinië', 'Florence', 'Pisa', 'Bologna', 'Verona'],
        'Griekenland' => ['Athene', 'Kreta', 'Santorini', 'Rhodos', 'Kos', 'Corfu', 'Zakynthos', 'Mykonos', 'Thessaloniki'],
        'Portugal' => ['Lissabon', 'Porto', 'Faro (Algarve)', 'Madeira', 'Azoren'],
        'Turkije' => ['Istanbul', 'Antalya', 'Bodrum', 'Alanya', 'Dalaman', 'Izmir', 'Cappadocië'],
        'Frankrijk' => ['Parijs', 'Nice', 'Lyon', 'Marseille', 'Bordeaux', 'Toulouse', 'Corsica'],
        'Kroatië' => ['Split', 'Dubrovnik', 'Zagreb', 'Zadar', 'Pula'],
        'Verenigd Koninkrijk' => ['Londen', 'Edinburgh', 'Manchester', 'Birmingham', 'Glasgow', 'Belfast'],
        'Duitsland' => ['Berlijn', 'München', 'Hamburg', 'Frankfurt', 'Keulen', 'Düsseldorf'],
        'Oostenrijk' => ['Wenen', 'Salzburg', 'Innsbruck', 'Graz'],
        'Zwitserland' => ['Zürich', 'Genève', 'Bazel', 'Bern'],
        'IJsland' => ['Reykjavik', 'Akureyri'],
        'Nederland' => ['Amsterdam', 'Rotterdam', 'Maastricht', 'Texel', 'Eindhoven'],

        // --- NOORD- & MIDDEN-AMERIKA ---
        'Verenigde Staten' => ['New York', 'Los Angeles', 'Miami', 'Las Vegas', 'San Francisco', 'Orlando', 'Chicago', 'Hawaii'],
        'Canada' => ['Toronto', 'Vancouver', 'Montreal', 'Calgary', 'Ottawa'],
        'Mexico' => ['Cancún', 'Mexico-Stad', 'Playa del Carmen', 'Tulum', 'Guadalajara', 'Puerto Vallarta'],
        'Costa Rica' => ['San José', 'Liberia', 'Tamarindo', 'Puerto Viejo'],
        'Panama' => ['Panama-Stad', 'Bocas del Toro'],

        // --- ZUID-AMERIKA ---
        'Brazilië' => ['Rio de Janeiro', 'São Paulo', 'Salvador', 'Fortaleza', 'Belo Horizonte', 'Manaus', 'Florianópolis'],
        'Colombia' => ['Bogotá', 'Medellín', 'Cartagena', 'Cali', 'Santa Marta', 'San Andrés'],
        'Suriname' => ['Paramaribo', 'Nieuw Nickerie', 'Albina'],
        'Chili' => ['Santiago', 'Valparaíso', 'San Pedro de Atacama', 'Punta Arenas'],
        'Argentinië' => ['Buenos Aires', 'Córdoba', 'Mendoza', 'Bariloche', 'Ushuaia'],
        'Peru' => ['Lima', 'Cusco', 'Arequipa', 'Iquitos'],

        // --- CARAÏBEN ---
        'ABC-Eilanden' => ['Aruba', 'Bonaire', 'Curaçao'],
        'Dominicaanse Republiek' => ['Punta Cana', 'Santo Domingo', 'Puerto Plata'],
        'Cuba' => ['Havana', 'Varadero', 'Trinidad', 'Santiago de Cuba'],
        'Jamaica' => ['Montego Bay', 'Kingston', 'Negril'],
        'Bahama\'s' => ['Nassau', 'Freeport'],

        // --- AFRIKA ---
        'Egypte' => ['Hurghada', 'Sharm el-Sheikh', 'Caïro', 'Luxor', 'Marsa Alam'],
        'Marokko' => ['Marrakech', 'Agadir', 'Casablanca', 'Fez', 'Tanger'],
        'Zuid-Afrika' => ['Kaapstad', 'Johannesburg', 'Krugerpark', 'Durban', 'Pretoria'],
        'Kaapverdië' => ['Sal', 'Boa Vista', 'São Vicente', 'Santiago'],
        'Kenia' => ['Nairobi', 'Mombasa', 'Kisumu'],
        'Tanzania' => ['Zanzibar', 'Dar es Salaam', 'Arusha'],
        'Senegal' => ['Dakar', 'Cap Skirring'],
        'Mauritius' => ['Port Louis', 'Grand Baie', 'Flic en Flac'],
        'Seychellen' => ['Mahé', 'Praslin', 'La Digue'],

        // --- MIDDEN-OOSTEN ---
        'Ver. Arabische Emiraten' => ['Dubai', 'Abu Dhabi', 'Sharjah'],
        'Irak' => ['Koerdistan (Erbil)', 'Sulaymaniyah', 'Duhok', 'Bagdad'],
        'Qatar' => ['Doha'],
        'Oman' => ['Muscat', 'Salalah'],
        'Jordanië' => ['Amman', 'Aqaba'],

        // --- AZIË ---
        'Indonesië' => ['Bali', 'Jakarta', 'Lombok', 'Yogyakarta', 'Sumatra'],
        'Thailand' => ['Bangkok', 'Phuket', 'Koh Samui', 'Chiang Mai', 'Krabi', 'Pattaya'],
        'Vietnam' => ['Hanoi', 'Ho Chi Minhstad', 'Da Nang', 'Hoi An', 'Phu Quoc'],
        'Japan' => ['Tokio', 'Kyoto', 'Osaka', 'Sapporo', 'Hiroshima'],
        'China' => ['Beijing', 'Shanghai', 'Guangzhou', 'Shenzhen', 'Chengdu'],
        'India' => ['New Delhi', 'Mumbai', 'Goa', 'Jaipur', 'Bangalore'],
        'Malediven' => ['Malé', 'Maafushi', 'Ari Atol'],
        'Filipijnen' => ['Manilla', 'Cebu', 'Boracay', 'Palawan', 'Bohol'],
        'Maleisië' => ['Kuala Lumpur', 'Penang', 'Langkawi', 'Kota Kinabalu'],
        'Zuid-Korea' => ['Seoul', 'Busan', 'Jeju'],
        'Singapore' => ['Singapore'],
        'Sri Lanka' => ['Colombo', 'Kandy', 'Galle'],

        // --- OCEANIË ---
        'Australië' => ['Sydney', 'Melbourne', 'Brisbane', 'Perth', 'Gold Coast', 'Cairns', 'Adelaide'],
        'Nieuw-Zeeland' => ['Auckland', 'Wellington', 'Christchurch', 'Queenstown'],
        'Fiji' => ['Nadi', 'Suva']
    ];

    protected function getContinentMapping($country)
    {
        $map = [
            'Spanje' => 'Europa', 'Italië' => 'Europa', 'Griekenland' => 'Europa', 'Portugal' => 'Europa',
            'Turkije' => 'Europa', 'Frankrijk' => 'Europa', 'Kroatië' => 'Europa', 'Verenigd Koninkrijk' => 'Europa',
            'Duitsland' => 'Europa', 'Oostenrijk' => 'Europa', 'Zwitserland' => 'Europa', 'IJsland' => 'Europa', 'Nederland' => 'Europa',
            'Verenigde Staten' => 'Noord-Amerika', 'Canada' => 'Noord-Amerika', 'Mexico' => 'Noord-Amerika', 'Costa Rica' => 'Noord-Amerika', 'Panama' => 'Noord-Amerika',
            'Brazilië' => 'Zuid-Amerika', 'Colombia' => 'Zuid-Amerika', 'Suriname' => 'Zuid-Amerika', 'Chili' => 'Zuid-Amerika', 'Argentinië' => 'Zuid-Amerika', 'Peru' => 'Zuid-Amerika',
            'ABC-Eilanden' => 'Caraïben', 'Aruba' => 'Caraïben', 'Bonaire' => 'Caraïben', 'Curaçao' => 'Caraïben', 'Dominicaanse Republiek' => 'Caraïben', 'Cuba' => 'Caraïben', 'Jamaica' => 'Caraïben', 'Bahama\'s' => 'Caraïben',
            'Egypte' => 'Afrika', 'Marokko' => 'Afrika', 'Zuid-Afrika' => 'Afrika', 'Kaapverdië' => 'Afrika', 'Kenia' => 'Afrika', 'Tanzania' => 'Afrika', 'Senegal' => 'Afrika', 'Mauritius' => 'Afrika', 'Seychellen' => 'Afrika',
            'Ver. Arabische Emiraten' => 'Midden-Oosten', 'Irak' => 'Midden-Oosten', 'Qatar' => 'Midden-Oosten', 'Oman' => 'Midden-Oosten', 'Jordanië' => 'Midden-Oosten',
            'Indonesië' => 'Azië', 'Thailand' => 'Azië', 'Vietnam' => 'Azië', 'Japan' => 'Azië', 'China' => 'Azië', 'India' => 'Azië', 'Malediven' => 'Azië', 'Filipijnen' => 'Azië', 'Maleisië' => 'Azië', 'Zuid-Korea' => 'Azië', 'Singapore' => 'Azië', 'Sri Lanka' => 'Azië',
            'Australië' => 'Oceanië', 'Nieuw-Zeeland' => 'Oceanië', 'Fiji' => 'Oceanië'
        ];
        return $map[$country] ?? 'Overig';
    }

    protected $rules = [
        'title' => 'required|min:5',
        'arrival_city' => 'required', // Zorg dat deze op 'required' staat!
        'arrival_country' => 'required',
        'arrival_continent' => 'required', // <-- TOEVOEGING
        'price' => 'required|numeric',
        'discounted_price' => 'nullable|numeric',
        'referral_url' => 'required|url',
        'duration_days' => 'nullable|integer|min:1',

        'new_images' => 'max:10',
        'new_images.*' => 'image|max:71680',
    ];

    public function mount(Deal $deal)
    {
        $this->deal = $deal;
        $this->deal_id = $deal->id;

        // Zorg dat de view weet of we archiveren of activeren
        $this->is_active = $deal->is_active;

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
        $this->arrival_continent = $deal->arrival_continent; // <-- TOEVOEGING

        $this->departure_date = $deal->departure_date ? \Carbon\Carbon::parse($deal->departure_date)->format('Y-m-d') : null;

        // Laad de bestaande reisduur in
        $this->duration_days = $deal->duration_days;

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
            } else {
                $this->departure_country = null;
            }
        }

        if ($propertyName === 'arrival_country') {
            $this->arrival_continent = $this->getContinentMapping($this->arrival_country); // <-- TOEVOEGING
            $this->arrival_city = null;
        }
    }

    // Functie voor de Archiveer knop
    public function toggleArchive()
    {
        $deal = Deal::find($this->deal_id);

        if($deal) {
            $deal->is_active = !$deal->is_active;
            $deal->save();
            $this->is_active = $deal->is_active;

            session()->flash('message', 'De status van de deal is succesvol aangepast! 🔄');
        }
    }

    public function removeExistingImage($imageId)
    {
        $image = DealImage::findOrFail($imageId);
        Storage::disk('public')->delete($image->path);
        $image->delete();

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
            'arrival_continent' => $this->arrival_continent, // <-- TOEVOEGING

            'departure_date' => $this->departure_date ?: null,
            'duration_days' => $this->duration_days ?: null,

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
