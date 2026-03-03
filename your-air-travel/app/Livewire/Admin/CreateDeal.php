<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Deal;
use App\Models\DealImage;
use Illuminate\Support\Facades\File; // <-- Toegevoegd voor de copy fix

class CreateDeal extends Component
{
    use WithFileUploads;

    public $is_active = true;
    public $title, $description, $price, $discounted_price, $airline, $referral_url;
    public $departure_city, $departure_country, $arrival_city, $arrival_country, $arrival_continent;
    public $departure_date;
    public $duration_days = 8;
    public $tags = [];
    public $images = [];

    public $vertrekLocaties = [
        'Amsterdam (Schiphol)' => 'Nederland',
        'Eindhoven' => 'Nederland',
        'Rotterdam / Den Haag' => 'Nederland',
        'Brussel (Zaventem)' => 'België',
        'Brussel (Charleroi)' => 'België',
        'Düsseldorf (Intl)' => 'Duitsland',
        'Düsseldorf (Weeze)' => 'Duitsland',
    ];

    public $beschikbareLanden = [
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
        'Verenigde Staten' => ['New York', 'Los Angeles', 'Miami', 'Las Vegas', 'San Francisco', 'Orlando', 'Chicago', 'Hawaii'],
        'Canada' => ['Toronto', 'Vancouver', 'Montreal', 'Calgary', 'Ottawa'],
        'Mexico' => ['Cancún', 'Mexico-Stad', 'Playa del Carmen', 'Tulum', 'Guadalajara', 'Puerto Vallarta'],
        'Costa Rica' => ['San José', 'Liberia', 'Tamarindo', 'Puerto Viejo'],
        'Panama' => ['Panama-Stad', 'Bocas del Toro'],
        'Brazilië' => ['Rio de Janeiro', 'São Paulo', 'Salvador', 'Fortaleza', 'Belo Horizonte', 'Manaus', 'Florianópolis'],
        'Colombia' => ['Bogotá', 'Medellín', 'Cartagena', 'Cali', 'Santa Marta', 'San Andrés'],
        'Suriname' => ['Paramaribo', 'Nieuw Nickerie', 'Albina'],
        'Chili' => ['Santiago', 'Valparaíso', 'San Pedro de Atacama', 'Punta Arenas'],
        'Argentinië' => ['Buenos Aires', 'Córdoba', 'Mendoza', 'Bariloche', 'Ushuaia'],
        'Peru' => ['Lima', 'Cusco', 'Arequipa', 'Iquitos'],
        'Aruba' => ['Oranjestad'], 'Bonaire' => ['Kralendijk'], 'Curaçao' => ['Willemstad'],
        'Dominicaanse Republiek' => ['Punta Cana', 'Santo Domingo', 'Puerto Plata'],
        'Cuba' => ['Havana', 'Varadero', 'Trinidad'],
        'Jamaica' => ['Montego Bay', 'Kingston'],
        'Bahama\'s' => ['Nassau', 'Freeport'],
        'Egypte' => ['Hurghada', 'Sharm el-Sheikh', 'Caïro', 'Luxor', 'Marsa Alam'],
        'Marokko' => ['Marrakech', 'Agadir', 'Casablanca', 'Fez', 'Tanger'],
        'Zuid-Afrika' => ['Kaapstad', 'Johannesburg', 'Krugerpark', 'Durban', 'Pretoria'],
        'Kaapverdië' => ['Sal', 'Boa Vista', 'São Vicente', 'Santiago'],
        'Kenia' => ['Nairobi', 'Mombasa', 'Kisumu'],
        'Tanzania' => ['Zanzibar', 'Dar es Salaam', 'Arusha'],
        'Senegal' => ['Dakar', 'Cap Skirring'],
        'Mauritius' => ['Port Louis', 'Grand Baie', 'Flic en Flac'],
        'Seychellen' => ['Mahé', 'Praslin', 'La Digue'],
        'Ver. Arabische Emiraten' => ['Dubai', 'Abu Dhabi', 'Sharjah'],
        'Irak' => ['Koerdistan (Erbil)', 'Sulaymaniyah', 'Duhok', 'Bagdad'],
        'Qatar' => ['Doha'], 'Oman' => ['Muscat', 'Salalah'], 'Jordanië' => ['Amman', 'Aqaba'],
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
        'Singapore' => ['Singapore'], 'Sri Lanka' => ['Colombo', 'Kandy', 'Galle'],
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
            'Aruba' => 'Caraïben', 'Bonaire' => 'Caraïben', 'Curaçao' => 'Caraïben', 'Dominicaanse Republiek' => 'Caraïben', 'Cuba' => 'Caraïben', 'Jamaica' => 'Caraïben', 'Bahama\'s' => 'Caraïben',
            'Egypte' => 'Afrika', 'Marokko' => 'Afrika', 'Zuid-Afrika' => 'Afrika', 'Kaapverdië' => 'Afrika', 'Kenia' => 'Afrika', 'Tanzania' => 'Afrika', 'Senegal' => 'Afrika', 'Mauritius' => 'Afrika', 'Seychellen' => 'Afrika',
            'Ver. Arabische Emiraten' => 'Midden-Oosten', 'Irak' => 'Midden-Oosten', 'Qatar' => 'Midden-Oosten', 'Oman' => 'Midden-Oosten', 'Jordanië' => 'Midden-Oosten',
            'Indonesië' => 'Azië', 'Thailand' => 'Azië', 'Vietnam' => 'Azië', 'Japan' => 'Azië', 'China' => 'Azië', 'India' => 'Azië', 'Malediven' => 'Azië', 'Filipijnen' => 'Azië', 'Maleisië' => 'Azië', 'Zuid-Korea' => 'Azië', 'Singapore' => 'Azië', 'Sri Lanka' => 'Azië',
            'Australië' => 'Oceanië', 'Nieuw-Zeeland' => 'Oceanië', 'Fiji' => 'Oceanië'
        ];
        return $map[$country] ?? 'Overig';
    }

    public function toggleStatus()
    {
        $this->is_active = !$this->is_active;
    }

    public function updatedDepartureCity($value)
    {
        $this->departure_country = $this->vertrekLocaties[$value] ?? null;
    }

    public function updatedArrivalCountry($value)
    {
        $this->arrival_continent = $this->getContinentMapping($value);
        $this->arrival_city = null;
    }

    public function saveDeal()
    {
        $this->validate([
            'title' => 'required|min:5',
            'price' => 'required|numeric',
            'discounted_price' => 'nullable|numeric',
            'departure_city' => 'required',
            'departure_country' => 'required',
            'arrival_city' => 'required',
            'arrival_country' => 'required',
            'arrival_continent' => 'required',
            'airline' => 'nullable',
            'departure_date' => 'required|date',
            'duration_days' => 'required|integer|min:1',
            'description' => 'required',
            'referral_url' => 'required|url',
            'images.*' => 'image|max:20480', // 20MB limiet
        ]);

        $deal = Deal::create([
            'title' => $this->title,
            'price' => $this->price,
            'discounted_price' => $this->discounted_price,
            'departure_city' => $this->departure_city,
            'departure_country' => $this->departure_country,
            'arrival_city' => $this->arrival_city,
            'arrival_country' => $this->arrival_country,
            'arrival_continent' => $this->arrival_continent,
            'airline' => $this->airline,
            'departure_date' => $this->departure_date,
            'duration_days' => $this->duration_days,
            'description' => $this->description,
            'referral_url' => $this->referral_url,
            'tags' => $this->tags,
            'is_active' => $this->is_active,
        ]);

        if ($this->images) {
            $destinationPath = public_path('uploads');

            // Map check!
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($this->images as $index => $image) {
                $filename = time() . '-' . $index . '-' . $image->getClientOriginalName();

                // Livewire-Proof Copy
                File::copy(
                    $image->getRealPath(),
                    $destinationPath . '/' . $filename
                );

                if ($index === 0) {
                    $deal->update(['image_path' => $filename]);
                }

                $deal->images()->create([
                    'path' => $filename,
                    'is_primary' => ($index === 0),
                ]);
            }
        }

        session()->flash('message', 'Deal succesvol online gezet! ✈️');
        return redirect()->route('admin.deals');
    }

    public function render()
    {
        return view('livewire.admin.create-deal')->layout('layouts.app');
    }
}
