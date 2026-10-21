<?php
namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'Canada'               => [
                'Ontario'          => [
                    'Toronto',
                    'Ottawa',
                    'Hamilton',
                ],
                'British Columbia' => [
                    'Vancouver',
                    'Victoria',
                    'Kelowna',
                ],
                'Alberta'          => [
                    'Calgary',
                    'Edmonton',
                    'Red Deer',
                ],
            ],

            'United States'        => [
                'California' => [
                    'Los Angeles',
                    'San Francisco',
                    'San Diego',
                ],
                'New York'   => [
                    'New York City',
                    'Buffalo',
                    'Rochester',
                ],
                'Texas'      => [
                    'Houston',
                    'Dallas',
                    'Austin',
                ],
            ],

            'United Kingdom'       => [
                'England'  => [
                    'London',
                    'Manchester',
                    'Birmingham',
                ],
                'Scotland' => [
                    'Edinburgh',
                    'Glasgow',
                    'Aberdeen',
                ],
                'Wales'    => [
                    'Cardiff',
                    'Swansea',
                    'Newport',
                ],
            ],

            'Australia'            => [
                'Victoria'        => [
                    'Melbourne',
                    'Geelong',
                    'Ballarat',
                ],
                'New South Wales' => [
                    'Sydney',
                    'Newcastle',
                    'Wollongong',
                ],
                'Queensland'      => [
                    'Brisbane',
                    'Gold Coast',
                    'Cairns',
                ],
            ],

            'Germany'              => [
                'Bavaria' => [
                    'Munich',
                    'Nuremberg',
                    'Augsburg',
                ],
                'Berlin'  => [
                    'Berlin',
                ],
                'Hesse'   => [
                    'Frankfurt',
                    'Wiesbaden',
                    'Darmstadt',
                ],
            ],

            'Malaysia'             => [
                'Selangor'     => [
                    'Shah Alam',
                    'Petaling Jaya',
                    'Subang Jaya',
                ],
                'Kuala Lumpur' => [
                    'Kuala Lumpur',
                ],
                'Johor'        => [
                    'Johor Bahru',
                    'Batu Pahat',
                    'Muar',
                ],
            ],

            'New Zealand'          => [
                'Auckland Region'    => [
                    'Auckland',
                ],
                'Waikato'            => [
                    'Hamilton',
                ],
                'Manawatu-Whanganui' => [
                    'Palmerston North',
                ],
                'Wellington Region'  => [
                    'Wellington',
                ],
                'Canterbury'         => [
                    'Christchurch',
                    'Lincoln',
                ],
                'Otago'              => [
                    'Dunedin',
                ],
            ],

            'South Korea'          => [
                'Seoul'             => [
                    'Seoul',
                ],
                'Busan'             => [
                    'Busan',
                ],
                'Daegu'             => [
                    'Daegu',
                ],
                'Incheon'           => [
                    'Incheon',
                ],
                'Gwangju'           => [
                    'Gwangju',
                ],
                'Daejeon'           => [
                    'Daejeon',
                ],
                'Ulsan'             => [
                    'Ulsan',
                ],
                'Sejong'            => [
                    'Sejong',
                ],
                'Gyeonggi'          => [
                    'Suwon',
                    'Seongnam',
                    'Yongin',
                    'Anyang',
                    'Bucheon',
                    'Ansan',
                    'Anseong',
                    'Pocheon',
                    'Uijeongbu',
                    'Goyang',
                ],
                'Gangwon'           => [
                    'Chuncheon',
                    'Wonju',
                    'Gangneung',
                    'Samcheok',
                ],
                'North Chungcheong' => [
                    'Cheongju',
                    'Chungju',
                    'Jecheon',
                ],
                'South Chungcheong' => [
                    'Cheonan',
                    'Asan',
                    'Gongju',
                    'Nonsan',
                ],
                'North Jeolla'      => [
                    'Jeonju',
                    'Iksan',
                    'Gunsan',
                ],
                'South Jeolla'      => [
                    'Mokpo',
                    'Suncheon',
                    'Naju',
                ],
                'North Gyeongsang'  => [
                    'Andong',
                    'Gyeongsan',
                    'Pohang',
                    'Gyeongju',
                    'Gimcheon',
                ],
                'South Gyeongsang'  => [
                    'Changwon',
                    'Jinju',
                    'Gimhae',
                    'Yangsan',
                ],
                'Jeju'              => [
                    'Jeju',
                ],
            ],

            'Finland'              => [
                'Uusimaa'              => [
                    'Helsinki',
                    'Espoo',
                ],
                'Kanta-Hame'           => [
                    'Hameenlinna',
                ],
                'North Karelia'        => [
                    'Joensuu',
                ],
                'Central Finland'      => [
                    'Jyvaskyla',
                ],
                'Kainuu'               => [
                    'Kajaani',
                ],
                'Central Ostrobothnia' => [
                    'Kokkola',
                ],
                'Kymenlaakso'          => [
                    'Kotka',
                ],
                'North Savo'           => [
                    'Kuopio',
                ],
                'Paijat-Hame'          => [
                    'Lahti',
                ],
                'South Karelia'        => [
                    'Lappeenranta',
                ],
                'North Ostrobothnia'   => [
                    'Oulu',
                ],
                'Satakunta'            => [
                    'Pori',
                ],
                'Lapland'              => [
                    'Rovaniemi',
                ],
                'Pirkanmaa'            => [
                    'Tampere',
                ],
                'Southwest Finland'    => [
                    'Turku',
                ],
                'Ostrobothnia'         => [
                    'Vaasa',
                ],
                'South Savo'           => [
                    'Mikkeli',
                ],
                'South Ostrobothnia'   => [
                    'Seinajoki',
                ],
            ],

            'Czech Republic'       => [
                'Prague'            => [
                    'Prague',
                ],
                'South Moravian'    => [
                    'Brno',
                ],
                'South Bohemian'    => [
                    'Ceske Budejovice',
                ],
                'Moravian-Silesian' => [
                    'Ostrava',
                    'Opava',
                    'Havirov',
                ],
                'Hradec Kralove'    => [
                    'Hradec Kralove',
                ],
                'Vysocina'          => [
                    'Jihlava',
                ],
                'Liberec'           => [
                    'Liberec',
                ],
                'Olomouc'           => [
                    'Olomouc',
                ],
                'Pardubice'         => [
                    'Pardubice',
                ],
                'Plzen'             => [
                    'Plzen',
                ],
                'Usti nad Labem'    => [
                    'Usti nad Labem',
                ],
                'Zlin'              => [
                    'Zlin',
                    'Kunovice',
                ],
                'Central Bohemian'  => [
                    'Mlada Boleslav',
                ],
            ],

            'Saudi Arabia'         => [
                'Riyadh'           => [
                    'Riyadh',
                    'Al Kharj',
                    'Majmaah',
                    'Shaqra',
                ],
                'Makkah'           => [
                    'Jeddah',
                    'Makkah',
                    'Taif',
                ],
                'Eastern Province' => [
                    'Dammam',
                    'Dhahran',
                    'Al Ahsa',
                ],
                'Madinah'          => [
                    'Madinah',
                ],
                'Al Qassim'        => [
                    'Buraydah',
                ],
                'Asir'             => [
                    'Abha',
                ],
                'Jazan'            => [
                    'Jazan',
                ],
                'Tabuk'            => [
                    'Tabuk',
                ],
                'Hail'             => [
                    'Hail',
                ],
                'Al Jawf'          => [
                    'Sakaka',
                ],
                'Najran'           => [
                    'Najran',
                ],
                'Northern Borders' => [
                    'Arar',
                ],
                'Al Bahah'         => [
                    'Al Bahah',
                ],
            ],

            'Japan'                => [
                'Hokkaido'  => [
                    'Sapporo',
                    'Hakodate',
                    'Asahikawa',
                    'Obihiro',
                ],
                'Aomori'    => [
                    'Aomori',
                    'Hirosaki',
                ],
                'Iwate'     => [
                    'Morioka',
                ],
                'Miyagi'    => [
                    'Sendai',
                ],
                'Akita'     => [
                    'Akita',
                ],
                'Yamagata'  => [
                    'Yamagata',
                ],
                'Fukushima' => [
                    'Fukushima',
                    'Aizuwakamatsu',
                    'Koriyama',
                ],
                'Ibaraki'   => [
                    'Mito',
                    'Tsukuba',
                    'Ami',
                ],
                'Tochigi'   => [
                    'Utsunomiya',
                ],
                'Gunma'     => [
                    'Maebashi',
                    'Takasaki',
                ],
                'Saitama'   => [
                    'Saitama',
                    'Kawagoe',
                    'Ageo',
                ],
                'Chiba'     => [
                    'Chiba',
                    'Kashiwa',
                    'Matsudo',
                    'Abiko',
                ],
                'Tokyo'     => [
                    'Tokyo',
                    'Hachioji',
                    'Machida',
                    'Kodaira',
                    'Koganei',
                    'Mitaka',
                ],
                'Kanagawa'  => [
                    'Yokohama',
                    'Kawasaki',
                    'Sagamihara',
                ],
                'Niigata'   => [
                    'Niigata',
                    'Nagaoka',
                ],
                'Toyama'    => [
                    'Toyama',
                ],
                'Ishikawa'  => [
                    'Kanazawa',
                    'Nonoichi',
                ],
                'Fukui'     => [
                    'Fukui',
                ],
                'Yamanashi' => [
                    'Kofu',
                ],
                'Nagano'    => [
                    'Nagano',
                    'Matsumoto',
                    'Ueda',
                ],
                'Gifu'      => [
                    'Gifu',
                ],
                'Shizuoka'  => [
                    'Shizuoka',
                    'Hamamatsu',
                ],
                'Aichi'     => [
                    'Nagoya',
                    'Toyota',
                    'Okazaki',
                    'Kasugai',
                ],
                'Mie'       => [
                    'Tsu',
                    'Yokkaichi',
                ],
                'Shiga'     => [
                    'Otsu',
                    'Hikone',
                    'Kusatsu',
                ],
                'Kyoto'     => [
                    'Kyoto',
                ],
                'Osaka'     => [
                    'Osaka',
                    'Suita',
                    'Sakai',
                    'Higashiosaka',
                ],
                'Hyogo'     => [
                    'Kobe',
                    'Himeji',
                    'Nishinomiya',
                    'Amagasaki',
                ],
                'Nara'      => [
                    'Nara',
                    'Kashihara',
                ],
                'Wakayama'  => [
                    'Wakayama',
                ],
                'Tottori'   => [
                    'Tottori',
                ],
                'Shimane'   => [
                    'Matsue',
                    'Izumo',
                ],
                'Okayama'   => [
                    'Okayama',
                    'Kurashiki',
                ],
                'Hiroshima' => [
                    'Hiroshima',
                    'Higashihiroshima',
                ],
                'Yamaguchi' => [
                    'Yamaguchi',
                    'Shimonoseki',
                ],
                'Tokushima' => [
                    'Tokushima',
                ],
                'Kagawa'    => [
                    'Takamatsu',
                ],
                'Ehime'     => [
                    'Matsuyama',
                ],
                'Kochi'     => [
                    'Kochi',
                ],
                'Fukuoka'   => [
                    'Fukuoka',
                    'Kitakyushu',
                    'Kurume',
                ],
                'Saga'      => [
                    'Saga',
                ],
                'Nagasaki'  => [
                    'Nagasaki',
                    'Sasebo',
                ],
                'Kumamoto'  => [
                    'Kumamoto',
                ],
                'Oita'      => [
                    'Oita',
                    'Beppu',
                ],
                'Miyazaki'  => [
                    'Miyazaki',
                ],
                'Kagoshima' => [
                    'Kagoshima',
                ],
                'Okinawa'   => [
                    'Naha',
                    'Nishihara',
                    'Ginowan',
                ],
            ],

            'France'               => [
                'Ile-de-France'              => [
                    'Paris',
                    'Arcueil',
                    'Cergy',
                    'Creteil',
                    'Evry-Courcouronnes',
                    'Guyancourt',
                    'Nanterre',
                    'Saint-Denis',
                    'Versailles',
                ],
                'Auvergne-Rhone-Alpes'       => [
                    'Lyon',
                    'Grenoble',
                    'Clermont-Ferrand',
                    'Saint-Etienne',
                    'Chambery',
                    'Annecy',
                ],
                'Bourgogne-Franche-Comte'    => [
                    'Dijon',
                    'Besancon',
                    'Belfort',
                ],
                'Brittany'                   => [
                    'Rennes',
                    'Brest',
                    'Lorient',
                ],
                'Centre-Val de Loire'        => [
                    'Tours',
                    'Orleans',
                ],
                'Corsica'                    => [
                    'Corte',
                ],
                'Grand Est'                  => [
                    'Strasbourg',
                    'Nancy',
                    'Metz',
                    'Reims',
                    'Troyes',
                ],
                'Hauts-de-France'            => [
                    'Lille',
                    'Amiens',
                    'Compiegne',
                    'Arras',
                    'Valenciennes',
                ],
                'Normandy'                   => [
                    'Rouen',
                    'Caen',
                    'Le Havre',
                ],
                'Nouvelle-Aquitaine'         => [
                    'Bordeaux',
                    'Poitiers',
                    'Limoges',
                    'La Rochelle',
                    'Pau',
                ],
                'Occitanie'                  => [
                    'Toulouse',
                    'Montpellier',
                    'Nimes',
                    'Perpignan',
                    'Albi',
                ],
                'Pays de la Loire'           => [
                    'Nantes',
                    'Angers',
                    'Le Mans',
                ],
                'Provence-Alpes-Cote d Azur' => [
                    'Marseille',
                    'Aix-en-Provence',
                    'Nice',
                    'Avignon',
                    'Toulon',
                ],
                'Guadeloupe'                 => [
                    'Pointe-a-Pitre',
                ],
                'Martinique'                 => [
                    'Schoelcher',
                ],
                'Reunion'                    => [
                    'Saint-Denis',
                ],
            ],

            'Ireland'              => [
                'Dublin'    => [
                    'Dublin',
                    'Blanchardstown',
                ],
                'Cork'      => [
                    'Cork',
                ],
                'Galway'    => [
                    'Galway',
                ],
                'Limerick'  => [
                    'Limerick',
                ],
                'Kildare'   => [
                    'Maynooth',
                ],
                'Waterford' => [
                    'Waterford',
                ],
                'Sligo'     => [
                    'Sligo',
                ],
                'Louth'     => [
                    'Dundalk',
                ],
                'Carlow'    => [
                    'Carlow',
                ],
                'Donegal'   => [
                    'Letterkenny',
                ],
                'Kerry'     => [
                    'Tralee',
                ],
                'Westmeath' => [
                    'Athlone',
                ],
            ],

            'Lithuania'            => [
                'Vilnius County'     => [
                    'Vilnius',
                ],
                'Kaunas County'      => [
                    'Kaunas',
                ],
                'Klaipeda County'    => [
                    'Klaipeda',
                ],
                'Siauliai County'    => [
                    'Siauliai',
                ],
                'Panevezys County'   => [
                    'Panevezys',
                ],
                'Alytus County'      => [
                    'Alytus',
                ],
                'Marijampole County' => [
                    'Marijampole',
                ],
                'Utena County'       => [
                    'Utena',
                ],
            ],

            'Romania'              => [
                'Bucharest'     => [
                    'Bucharest',
                ],
                'Alba'          => [
                    'Alba Iulia',
                ],
                'Arad'          => [
                    'Arad',
                ],
                'Bacau'         => [
                    'Bacau',
                ],
                'Brasov'        => [
                    'Brasov',
                ],
                'Cluj'          => [
                    'Cluj-Napoca',
                ],
                'Constanta'     => [
                    'Constanta',
                ],
                'Dolj'          => [
                    'Craiova',
                ],
                'Galati'        => [
                    'Galati',
                ],
                'Iasi'          => [
                    'Iasi',
                ],
                'Bihor'         => [
                    'Oradea',
                ],
                'Hunedoara'     => [
                    'Petrosani',
                ],
                'Arges'         => [
                    'Pitesti',
                ],
                'Prahova'       => [
                    'Ploiesti',
                ],
                'Sibiu'         => [
                    'Sibiu',
                ],
                'Suceava'       => [
                    'Suceava',
                ],
                'Dambovita'     => [
                    'Targoviste',
                ],
                'Gorj'          => [
                    'Targu Jiu',
                ],
                'Mures'         => [
                    'Targu Mures',
                ],
                'Timis'         => [
                    'Timisoara',
                ],
                'Caras-Severin' => [
                    'Resita',
                ],
            ],

            'Malta'                => [
                'Central Region'       => [
                    'Msida',
                ],
                'South Eastern Region' => [
                    'Cospicua',
                    'Luqa',
                    'Paola',
                    'Valletta',
                ],
            ],

            'United Arab Emirates' => [
                'Abu Dhabi'      => [
                    'Abu Dhabi',
                    'Al Ain',
                ],
                'Dubai'          => [
                    'Dubai',
                ],
                'Sharjah'        => [
                    'Sharjah',
                ],
                'Ajman'          => [
                    'Ajman',
                ],
                'Ras Al Khaimah' => [
                    'Ras Al Khaimah',
                ],
                'Fujairah'       => [
                    'Fujairah',
                ],
                'Umm Al Quwain'  => [
                    'Umm Al Quwain',
                ],
            ],

            'Turkey'               => [
                'Adana'          => ['Adana'],
                'Adiyaman'       => ['Adiyaman'],
                'Afyonkarahisar' => ['Afyonkarahisar'],
                'Agri'           => ['Agri'],
                'Aksaray'        => ['Aksaray'],
                'Amasya'         => ['Amasya'],
                'Ankara'         => ['Ankara'],
                'Antalya'        => ['Antalya', 'Alanya'],
                'Ardahan'        => ['Ardahan'],
                'Artvin'         => ['Artvin'],
                'Aydin'          => ['Aydin'],
                'Balikesir'      => ['Balikesir', 'Bandirma'],
                'Bartin'         => ['Bartin'],
                'Batman'         => ['Batman'],
                'Bayburt'        => ['Bayburt'],
                'Bilecik'        => ['Bilecik'],
                'Bingol'         => ['Bingol'],
                'Bitlis'         => ['Bitlis'],
                'Bolu'           => ['Bolu'],
                'Burdur'         => ['Burdur'],
                'Bursa'          => ['Bursa'],
                'Canakkale'      => ['Canakkale'],
                'Cankiri'        => ['Cankiri'],
                'Corum'          => ['Corum'],
                'Denizli'        => ['Denizli'],
                'Diyarbakir'     => ['Diyarbakir'],
                'Duzce'          => ['Duzce'],
                'Edirne'         => ['Edirne'],
                'Elazig'         => ['Elazig'],
                'Erzincan'       => ['Erzincan'],
                'Erzurum'        => ['Erzurum'],
                'Eskisehir'      => ['Eskisehir'],
                'Gaziantep'      => ['Gaziantep'],
                'Giresun'        => ['Giresun'],
                'Gumushane'      => ['Gumushane'],
                'Hakkari'        => ['Hakkari'],
                'Hatay'          => ['Antakya', 'Iskenderun'],
                'Igdir'          => ['Igdir'],
                'Isparta'        => ['Isparta'],
                'Istanbul'       => ['Istanbul'],
                'Izmir'          => ['Izmir'],
                'Kahramanmaras'  => ['Kahramanmaras'],
                'Karabuk'        => ['Karabuk'],
                'Karaman'        => ['Karaman'],
                'Kars'           => ['Kars'],
                'Kastamonu'      => ['Kastamonu'],
                'Kayseri'        => ['Kayseri'],
                'Kilis'          => ['Kilis'],
                'Kirikkale'      => ['Kirikkale'],
                'Kirklareli'     => ['Kirklareli'],
                'Kirsehir'       => ['Kirsehir'],
                'Kocaeli'        => ['Izmit', 'Gebze'],
                'Konya'          => ['Konya'],
                'Kutahya'        => ['Kutahya'],
                'Malatya'        => ['Malatya'],
                'Manisa'         => ['Manisa'],
                'Mardin'         => ['Mardin'],
                'Mersin'         => ['Mersin', 'Tarsus'],
                'Mugla'          => ['Mugla'],
                'Mus'            => ['Mus'],
                'Nevsehir'       => ['Nevsehir'],
                'Nigde'          => ['Nigde'],
                'Ordu'           => ['Ordu'],
                'Osmaniye'       => ['Osmaniye'],
                'Rize'           => ['Rize'],
                'Sakarya'        => ['Sakarya'],
                'Samsun'         => ['Samsun'],
                'Sanliurfa'      => ['Sanliurfa'],
                'Siirt'          => ['Siirt'],
                'Sinop'          => ['Sinop'],
                'Sirnak'         => ['Sirnak'],
                'Sivas'          => ['Sivas'],
                'Tekirdag'       => ['Tekirdag'],
                'Tokat'          => ['Tokat'],
                'Trabzon'        => ['Trabzon'],
                'Tunceli'        => ['Tunceli'],
                'Usak'           => ['Usak'],
                'Van'            => ['Van'],
                'Yalova'         => ['Yalova'],
                'Yozgat'         => ['Yozgat'],
                'Zonguldak'      => ['Zonguldak'],
            ],

            'Switzerland'          => [
                'Basel-Stadt' => ['Basel'],
                'Bern'        => ['Bern'],
                'Jura'        => ['Delemont'],
                'Fribourg'    => ['Fribourg'],
                'Geneva'      => ['Geneva', 'Bellevue'],
                'Vaud'        => ['Lausanne', 'Glion'],
                'Lucerne'     => ['Lucerne'],
                'Ticino'      => ['Lugano', 'Manno'],
                'Neuchatel'   => ['Neuchatel'],
                'St. Gallen'  => ['St. Gallen'],
                'Aargau'      => ['Windisch'],
                'Zurich'      => ['Zurich', 'Winterthur'],
            ],

            'Spain'                => [
                'Community of Madrid' => [
                    'Madrid',
                    'Alcala de Henares',
                    'Villanueva de la Canada',
                    'Villaviciosa de Odon',
                ],
                'Catalonia'           => [
                    'Barcelona',
                    'Bellaterra',
                    'Girona',
                    'Lleida',
                    'Tarragona',
                    'Vic',
                ],
                'Andalusia'           => [
                    'Seville',
                    'Granada',
                    'Malaga',
                    'Cordoba',
                    'Cadiz',
                    'Jaen',
                    'Almeria',
                    'Huelva',
                ],
                'Valencian Community' => [
                    'Valencia',
                    'Alicante',
                    'Elche',
                    'Castellon de la Plana',
                ],
                'Basque Country'      => [
                    'Bilbao',
                    'San Sebastian',
                    'Vitoria-Gasteiz',
                ],
                'Galicia'             => [
                    'Santiago de Compostela',
                    'A Coruna',
                    'Vigo',
                ],
                'Castile and Leon'    => [
                    'Salamanca',
                    'Valladolid',
                    'Burgos',
                    'Leon',
                    'Segovia',
                ],
                'Castilla-La Mancha'  => [
                    'Ciudad Real',
                    'Toledo',
                    'Albacete',
                ],
                'Aragon'              => ['Zaragoza'],
                'Asturias'            => ['Oviedo', 'Gijon'],
                'Cantabria'           => ['Santander'],
                'Navarre'             => ['Pamplona'],
                'La Rioja'            => ['Logrono'],
                'Region of Murcia'    => [
                    'Murcia',
                    'Cartagena',
                ],
                'Extremadura'         => [
                    'Badajoz',
                    'Caceres',
                ],
                'Balearic Islands'    => [
                    'Palma',
                ],
                'Canary Islands'      => [
                    'Las Palmas de Gran Canaria',
                    'San Cristobal de La Laguna',
                ],
            ],

            'Singapore'            => [
                'Singapore' => [
                    'Singapore',
                ],
            ],

            'Latvia'               => [
                'Riga Planning Region'    => [
                    'Riga',
                ],
                'Latgale Planning Region' => [
                    'Daugavpils',
                    'Rezekne',
                ],
                'Zemgale Planning Region' => [
                    'Jelgava',
                ],
                'Kurzeme Planning Region' => [
                    'Liepaja',
                    'Ventspils',
                ],
                'Vidzeme Planning Region' => [
                    'Valmiera',
                ],
            ],

            'Italy'                => [
                'Abruzzo'               => [
                    'L Aquila',
                    'Chieti',
                    'Teramo',
                ],
                'Aosta Valley'          => [
                    'Aosta',
                ],
                'Apulia'                => [
                    'Bari',
                    'Foggia',
                    'Lecce',
                    'Casamassima',
                ],
                'Basilicata'            => [
                    'Potenza',
                ],
                'Calabria'              => [
                    'Arcavacata di Rende',
                    'Catanzaro',
                    'Reggio Calabria',
                ],
                'Campania'              => [
                    'Naples',
                    'Caserta',
                    'Benevento',
                    'Fisciano',
                ],
                'Emilia-Romagna'        => [
                    'Bologna',
                    'Ferrara',
                    'Modena',
                    'Parma',
                ],
                'Friuli-Venezia Giulia' => [
                    'Trieste',
                    'Udine',
                ],
                'Lazio'                 => [
                    'Rome',
                    'Cassino',
                    'Viterbo',
                ],
                'Liguria'               => [
                    'Genoa',
                ],
                'Lombardy'              => [
                    'Milan',
                    'Bergamo',
                    'Brescia',
                    'Castellanza',
                    'Pavia',
                    'Pieve Emanuele',
                    'Varese',
                ],
                'Marche'                => [
                    'Ancona',
                    'Camerino',
                    'Macerata',
                    'Urbino',
                ],
                'Molise'                => [
                    'Campobasso',
                ],
                'Piedmont'              => [
                    'Turin',
                    'Vercelli',
                    'Bra',
                ],
                'Sardinia'              => [
                    'Cagliari',
                    'Sassari',
                ],
                'Sicily'                => [
                    'Palermo',
                    'Catania',
                    'Messina',
                    'Enna',
                ],
                'Trentino-Alto Adige'   => [
                    'Trento',
                    'Bolzano',
                ],
                'Tuscany'               => [
                    'Florence',
                    'Pisa',
                    'Siena',
                    'Lucca',
                ],
                'Umbria'                => [
                    'Perugia',
                ],
                'Veneto'                => [
                    'Padua',
                    'Venice',
                    'Verona',
                ],
            ],

            'India'                => [
                'Andhra Pradesh'    => [
                    'Visakhapatnam',
                    'Vijayawada',
                    'Guntur',
                    'Tirupati',
                    'Anantapur',
                ],
                'Arunachal Pradesh' => [
                    'Itanagar',
                    'Pasighat',
                    'Aalo',
                ],
                'Assam'             => [
                    'Guwahati',
                    'Dibrugarh',
                    'Silchar',
                    'Tezpur',
                ],
                'Bihar'             => [
                    'Patna',
                    'Gaya',
                    'Darbhanga',
                    'Bhagalpur',
                ],
                'Chhattisgarh'      => [
                    'Raipur',
                    'Bhilai',
                    'Bilaspur',
                    'Bastar',
                ],
                'Goa'               => [
                    'Panaji',
                    'Farmagudi',
                ],
                'Gujarat'           => [
                    'Ahmedabad',
                    'Gandhinagar',
                    'Vadodara',
                    'Surat',
                    'Rajkot',
                    'Anand',
                ],
                'Haryana'           => [
                    'Gurugram',
                    'Faridabad',
                    'Hisar',
                    'Rohtak',
                    'Sonipat',
                    'Ambala',
                ],
                'Himachal Pradesh'  => [
                    'Shimla',
                    'Hamirpur',
                    'Palampur',
                    'Solan',
                    'Baddi',
                ],
                'Jharkhand'         => [
                    'Ranchi',
                    'Dhanbad',
                    'Jamshedpur',
                    'Deoghar',
                ],
                'Karnataka'         => [
                    'Bangalore',
                    'Mysore',
                    'Mangalore',
                    'Belagavi',
                    'Dharwad',
                    'Manipal',
                    'Gulbarga',
                ],
                'Kerala'            => [
                    'Thiruvananthapuram',
                    'Kochi',
                    'Kozhikode',
                    'Kottayam',
                    'Kannur',
                    'Kasaragod',
                ],
                'Madhya Pradesh'    => [
                    'Bhopal',
                    'Indore',
                    'Gwalior',
                    'Jabalpur',
                    'Sagar',
                ],
                'Maharashtra'       => [
                    'Mumbai',
                    'Pune',
                    'Nagpur',
                    'Nashik',
                    'Aurangabad',
                    'Kolhapur',
                    'Amravati',
                ],
                'Manipur'           => [
                    'Imphal',
                ],
                'Meghalaya'         => [
                    'Shillong',
                    'Baridua',
                ],
                'Mizoram'           => [
                    'Aizawl',
                ],
                'Nagaland'          => [
                    'Kohima',
                    'Dimapur',
                ],
                'Odisha'            => [
                    'Bhubaneswar',
                    'Cuttack',
                    'Rourkela',
                    'Sambalpur',
                    'Berhampur',
                ],
                'Punjab'            => [
                    'Chandigarh',
                    'Amritsar',
                    'Patiala',
                    'Ludhiana',
                    'Jalandhar',
                    'Bathinda',
                ],
                'Rajasthan'         => [
                    'Jaipur',
                    'Jodhpur',
                    'Udaipur',
                    'Ajmer',
                    'Kota',
                    'Bikaner',
                ],
                'Sikkim'            => [
                    'Gangtok',
                ],
                'Tamil Nadu'        => [
                    'Chennai',
                    'Coimbatore',
                    'Madurai',
                    'Tiruchirappalli',
                    'Vellore',
                    'Salem',
                    'Chidambaram',
                ],
                'Telangana'         => [
                    'Hyderabad',
                    'Warangal',
                ],
                'Tripura'           => [
                    'Agartala',
                ],
                'Uttar Pradesh'     => [
                    'Lucknow',
                    'Kanpur',
                    'Varanasi',
                    'Noida',
                    'Greater Noida',
                    'Agra',
                    'Aligarh',
                    'Allahabad',
                    'Bareilly',
                    'Gorakhpur',
                ],
                'Uttarakhand'       => [
                    'Dehradun',
                    'Roorkee',
                    'Nainital',
                    'Haridwar',
                    'Pantnagar',
                ],
                'West Bengal'       => [
                    'Kolkata',
                    'Howrah',
                    'Durgapur',
                    'Kharagpur',
                    'Siliguri',
                    'Bardhaman',
                    'Bolpur',
                ],
                'Delhi'             => [
                    'New Delhi',
                    'Delhi',
                ],
                'Jammu and Kashmir' => [
                    'Srinagar',
                    'Jammu',
                ],
                'Ladakh'            => [
                    'Leh',
                ],
                'Puducherry'        => [
                    'Puducherry',
                    'Karaikal',
                ],
            ],

            'Belgium'              => [
                'Brussels-Capital Region' => [
                    'Brussels',
                    'Saint-Gilles',
                ],
                'Flemish Region'          => [
                    'Antwerp',
                    'Bruges',
                    'Ghent',
                    'Leuven',
                    'Hasselt',
                    'Mechelen',
                ],
                'Walloon Region'          => [
                    'Liege',
                    'Louvain-la-Neuve',
                    'Mons',
                    'Namur',
                    'Tournai',
                    'Ramegnies-Chin',
                ],
            ],

            'Cyprus'               => [
                'Nicosia District'   => [
                    'Nicosia',
                    'Lefkosia',
                ],
                'Limassol District'  => [
                    'Limassol',
                    'Kato Polemidia',
                ],
                'Larnaca District'   => [
                    'Larnaca',
                ],
                'Paphos District'    => [
                    'Paphos',
                ],
                'Famagusta District' => [
                    'Famagusta',
                    'Sotira',
                ],
                'Kyrenia District'   => [
                    'Kyrenia',
                ],
                'Lefke District'     => [
                    'Lefke',
                ],
            ],

            'Kyrgyzstan'           => [
                'Bishkek'           => [
                    'Bishkek',
                ],
                'Osh City'          => [
                    'Osh',
                ],
                'Batken Region'     => [
                    'Batken',
                ],
                'Jalal-Abad Region' => [
                    'Jalal-Abad',
                ],
                'Issyk-Kul Region'  => [
                    'Karakol',
                ],
                'Naryn Region'      => [
                    'Naryn',
                ],
                'Talas Region'      => [
                    'Talas',
                ],
                'Chuy Region'       => [
                    'Tokmok',
                ],
            ],

            'Sweden'               => [
                'Stockholm County'       => [
                    'Stockholm',
                    'Flemingsberg',
                    'Huddinge',
                ],
                'Uppsala County'         => [
                    'Uppsala',
                ],
                'Skane County'           => [
                    'Lund',
                    'Malmo',
                    'Kristianstad',
                ],
                'Vastra Gotaland County' => [
                    'Gothenburg',
                    'Boras',
                    'Skovde',
                    'Trollhattan',
                ],
                'Ostergotland County'    => [
                    'Linkoping',
                ],
                'Vasterbotten County'    => [
                    'Umea',
                ],
                'Norrbotten County'      => [
                    'Lulea',
                ],
                'Jonkoping County'       => [
                    'Jonkoping',
                ],
                'Varmland County'        => [
                    'Karlstad',
                ],
                'Orebro County'          => [
                    'Orebro',
                ],
                'Dalarna County'         => [
                    'Falun',
                ],
                'Gavleborg County'       => [
                    'Gavle',
                ],
                'Halland County'         => [
                    'Halmstad',
                ],
                'Blekinge County'        => [
                    'Karlskrona',
                ],
                'Vastmanland County'     => [
                    'Vasteras',
                ],
                'Kronoberg County'       => [
                    'Vaxjo',
                ],
                'Vasternorrland County'  => [
                    'Sundsvall',
                ],
            ],
        ];

        foreach ($map as $countryName => $states) {
            $country = Country::where('name', $countryName)->first();

            if (! $country) {
                continue;
            }

            foreach ($states as $stateName => $cities) {
                /*
                 * Important:
                 * State name alone দিয়ে lookup করছি না।
                 *
                 * একই নামের state/region অন্য country-তেও থাকতে পারে।
                 * তাই country_id + state name দিয়ে resolve করা হচ্ছে।
                 */
                $state = State::where('country_id', $country->id)
                    ->where('name', $stateName)
                    ->first();

                if (! $state) {
                    continue;
                }

                foreach ($cities as $i => $name) {
                    City::updateOrCreate(
                        [
                            'state_id' => $state->id,
                            'name'     => $name,
                        ],
                        [
                            'slug'        => Str::slug($name),
                            'latitude'    => null,
                            'longitude'   => null,
                            'description' => $name
                            . ', '
                            . $stateName
                            . ', '
                            . $countryName
                            . '.',
                            'sort_order'  => $i,
                            'is_active'   => true,
                        ]
                    );
                }
            }
        }
    }
}
